<?php

namespace App\Http\Controllers\User\Api;

use App\Http\Resources\BrandResource;
use App\Http\Resources\BrandStoreBannerResource;
use App\Http\Resources\CategoryResource;
use App\Models\Brand;
use App\Models\BrandStoreBanner;
use App\Models\Category;
use App\Models\CategoryBrandStorePage;

class CategoryBrandController extends BaseResponse
{
    public function index()
    {
        try {
            $show_categories_brands = [];

            $categories_brands = CategoryBrandStorePage::select('category_id', 'brand_id')
                ->groupBy('category_id', 'brand_id')
                ->get()
                ->groupBy('category_id')
                ->map(function ($category) {
                    return $category->pluck('brand_id');
                });

            foreach ($categories_brands as $category_id => $brand_ids) {
                $category = Category::findOrFail($category_id);
                $brands = Brand::whereIn('id', $brand_ids)->get();
                array_push($show_categories_brands, [
                    'category' => new CategoryResource($category),
                    'brands' => BrandResource::collection($brands)]);
            }

            $brand_store_banner_resource = null;
            $brand_store_banner = BrandStoreBanner::first() ?? null;

            if (!is_null($brand_store_banner)) {
                $brand_store_banner_resource = new BrandStoreBannerResource($brand_store_banner);
            }
            return $this->response(200, 'Categories Brands', 200, [], 0,
                ['brand-store_banner' => $brand_store_banner_resource
                    , 'categoriesBrands' => $show_categories_brands]);

        } catch (\Exception $ex) {
            return $this->response(500, 'Error!', 500);
        }
    }
}
