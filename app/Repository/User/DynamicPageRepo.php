<?php

namespace App\Repository\User;

use App\Helpers\General;
use App\Http\Resources\DynamicPageDetailsResource;
use App\Http\Resources\DynamicPageResource;
use App\Http\Resources\ShopProductResource;
use App\Models\DynamicPage;
use App\Models\DynamicPageShopProducts;
use App\Models\ShopProduct;
use App\Models\Specification;
use App\Models\ShopProductSpecification;
use App\Http\Resources\DynamicPageSeoResource;

class DynamicPageRepo
{
    private $request;
    private $result = array();

    public function dynamicPages()
    {
        $pages = DynamicPage::where('show', 1)->get();
        $results['pages'] = DynamicPageResource::collection($pages);
        return $this->result = ['validator' => null, 'success' => 'Brand Details', 'errors' => null, 'object' => $results];
    }

    public function dynamicDetails($slug)
    {
        try {
            // Retrieve the page where the slugified 'name' matches the entered slug
            $page = DynamicPage::query()
                ->join('dynamic_page_translations as translations', 'dynamic_pages.id', '=', 'translations.dynamic_page_id')
                ->whereRaw('LOWER(REPLACE(translations.name, " ", "-")) = ?', [$slug])
                ->select('dynamic_pages.*') // Ensure you select only the main table fields
                ->first();
    
            if (!$page) {
                // Page not found, handle accordingly
                abort(404, 'Page not found');
            }
    
            // Example: Assuming 'shop_products' is related to DynamicPage
            $shopProductIds = DynamicPageShopProducts::where('dynamic_page_id', $page->id)
                ->pluck('shop_product_id')
                ->toArray();
    
            // Get the input filters
            $input_specifications = request()->input('specification', []); // Default to empty array if not provided
            $input_brands = request()->input('brand', []);
            $min_price = request()->input('min_price', null);
            $max_price = request()->input('max_price', null);
            $search = request()->input('search', null);
            $sort_by = request()->input('Options', null); // Default sort by 'qty'
            $sort_order = request()->input('sort_order', 'desc'); // Default sort order 'desc'
    
            // Step 1: Get all specifications related to products in the dynamic page
            $specifications = Specification::whereIn(
                'id',
                ShopProductSpecification::whereIn('shop_product_id', $shopProductIds)
                    ->whereNotNull('value')
                    ->distinct()
                    ->pluck('specification_id')
                    ->toArray()
            )->get()->sortBy('weight', SORT_DESC);
    
            // Step 2: Format specifications with pagination
            $allSpecifications = $specifications->map(function ($spec) use ($shopProductIds) {
                $shopProductValues = ShopProductSpecification::where('specification_id', $spec->id)
                    ->whereIn('shop_product_id', $shopProductIds)
                    ->paginate(25);  // Paginate the results
    
                $formattedValues = $shopProductValues->map(function ($spv) use ($spec) {
                    return [
                        'id'           => $spv->id,
                        'selected'     => 0,
                        'specification'=> $spec->name,
                        'value'        => $spv->value,
                    ];
                })->unique('value')->values()->toArray();
    
                return [
                    'id'                 => $spec->id,
                    'specification'      => $spec->name,
                    'shop_product_values'=> $formattedValues,
                    'pagination'         => General::createPaginationArray($shopProductValues), // Add pagination info
                ];
            })->values()->toArray();
    
            // Step 3: Apply filters to shop products
            $shopProducts = ShopProduct::whereIn('shop_products.id', $shopProductIds)
                ->where('shop_products.show', 1)
                ->select('shop_products.*')
                ->leftJoin('shop_product_translations', 'shop_products.id', '=', 'shop_product_translations.shop_product_id')
                ->leftJoin('brands', 'shop_products.brand_id', '=', 'brands.id')
                ->leftJoin('brand_translations', 'brands.id', '=', 'brand_translations.brand_id')
                ->distinct('shop_products.id')
                ->when($input_specifications, function ($query) use ($input_specifications) {
                    $shop_product_values = ShopProductSpecification::whereIn('id', $input_specifications)
                        ->distinct()
                        ->select('specification_id', 'value')
                        ->get();
    
                    $specifications = $shop_product_values->pluck('specification_id')->toArray();
                    $values = $shop_product_values->pluck('value')->toArray();
    
                    foreach ($specifications as $specification) {
                        $query->whereIn('shop_products.id', ShopProductSpecification::where('specification_id', $specification)
                            ->whereIn('value', $values)
                            ->pluck('shop_product_id')
                            ->toArray());
                    }
                    return $query;
                })
                ->when($input_brands, function ($query) use ($input_brands) {
                    return $query->whereIn('shop_products.brand_id', $input_brands);
                })
                ->when($min_price, function ($query) use ($min_price) {
                    return $query->where('new_price', '>=', $min_price);
                })
                ->when($max_price, function ($query) use ($max_price) {
                    return $query->where('new_price', '<=', $max_price);
                })
                ->when($search, function ($query) use ($search) {
                    return $query->where(function ($query) use ($search) {
                        $query->where('shop_product_translations.name', 'LIKE', "%{$search}%")
                              ->orWhere('shop_product_translations.description', 'LIKE', "%{$search}%")
                              ->orWhere('shop_products.sku_code', 'LIKE', "%{$search}%")
                              ->orWhere('brand_translations.name', 'LIKE', "%{$search}%");
                    });
                })
                ->when($sort_by, function ($query) use ($sort_by, $sort_order) {
                    switch ($sort_by) {
                        case 'latest':
                            return $query->orderBy('shop_products.created_at', 'desc');
                        case 'highest price':
                            return $query->orderBy('shop_products.new_price', 'desc');
                        case 'lowest price':
                            return $query->orderBy('shop_products.new_price', 'asc');
                        default:
                            return $query->orderBy($sort_by, $sort_order);
                    }
                })
                ->paginate(25);
    
            array_push($allSpecifications, [
                'type' => __('home.price'),
                'key'  => 'price',
                'min_price' => $shopProducts->pluck('new_price')->min(),
                'max_price' => $shopProducts->pluck('new_price')->max(),
            ]);
    
            $results['products'] = ShopProductResource::collection($shopProducts);
            $results['filter'] = $allSpecifications;
            $results['pagination'] = General::createPaginationArray($shopProducts);
            $results['page'] = new DynamicPageDetailsResource($page);
    
            return $this->result = [
                'validator' => null,
                'success' => 'Brand Details',
                'errors' => null,
                'object' => $results
            ];
        } catch (\Exception $e) {
            dd($e);
        }
    }
    
    public function pageSeo($slug)
    {
        $page = DynamicPage::query()
            ->join('dynamic_page_translations as translations', 'dynamic_pages.id', '=', 'translations.dynamic_page_id')
            ->whereRaw('LOWER(REPLACE(translations.name, " ", "-")) = ?', [$slug])
            ->select('dynamic_pages.*') // Ensure you select only the main table fields
            ->first();
        $result = new DynamicPageSeoResource($page);
        return $this->result = ['validator' => null, 'success' => 'Brand Details', 'errors' => null, 'object' => $result];
    }
}