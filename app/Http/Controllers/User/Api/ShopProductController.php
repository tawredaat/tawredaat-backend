<?php

namespace App\Http\Controllers\User\Api;

use App\Events\User\ShopProductViewed;
use App\Http\Requests\User\Api\ShopProduct\FilterShopProductRequest;
use App\Http\Resources\CategoryBannerResource;
use App\Models\Category;
use App\Models\CategoryBanner;
use App\Repository\User\ShopProductRepo;
use Illuminate\Http\Request;

class ShopProductController extends BaseResponse
{

    protected $shopProductRepo;

    public function __construct(ShopProductRepo $shopProductRepo)
    {
        $this->shopProductRepo = $shopProductRepo;
    }

    public function shop()
    {
        $result['sliders'] = $this->shopProductRepo->sliders()['object']['sliders'];
        $result['featuredCategories'] = $this->shopProductRepo->featuredCategories()['object']['featuredCategories'];
        $result['featuredShopProducts'] = $this->shopProductRepo->featuredShopProduct()['object']['featuredShopProducts'];
        $result['bestSellerProducts'] = $this->shopProductRepo->bestSellerProducts()['object']['bestSellerProducts'];
        return $this->response(200, "Shop Products", 200, [], 0, $result);
    }

    public function show($id)
    {
        $result = $this->shopProductRepo->show($id);
        if ($result['success']) {

            event(new ShopProductViewed($id));

            return $this->response(200, $result['success'], 200, [], 0, $result['object']);
        } elseif ($result['validator']) {
            return $this->response(101, "Validation Error", 200, $result['validator']);
        } elseif ($result['errors']) {
            return $this->response(500, $result['errors'], 500);
        } else {
            return $this->response(500, "Error", 500);
        }

    }

    public function allLevel1()
    {
        $result = $this->shopProductRepo->featuredCategories();
        if ($result['success']) {
            return $this->response(200, $result['success'], 200, [], 0, $result['object']);
        } elseif ($result['errors']) {
            return $this->response(500, $result['errors'] . $result['errors'], 500);
        } else {
            return $this->response(500, "Error" . $result['errors'], 500);
        }

    }
    public function shopCategories($id)
    {
        $result = $this->shopProductRepo->LevelThreeCategories($id);
        if ($result['success']) {
            return $this->response(200, $result['success'], 200, [], 0, $result['object']);
        } elseif ($result['errors']) {
            return $this->response(500, $result['errors'], 500);
        } else {
            return $this->response(500, "Error", 500);
        }

    }
  
    public function productSeo($id)
    {
        $result = $this->shopProductRepo->productSeo($id);
        if ($result['success']) {
            return $this->response(200, $result['success'], 200, [], 0, $result['object']);
        } elseif ($result['errors']) {
            return $this->response(500, $result['errors'], 500);
        } else {
            return $this->response(500, "Error", 500);
        }

    }

    public function getShopProductsByL3Category(Request $request, $id)
    {
        $request->merge(['in_category' => $id]);
        $request->merge(['category_level' => 'level3']);
        $this->shopProductRepo->setReq($request);
        $result = $this->shopProductRepo->getShopProducts();
        if ($result['success']) {
            $results = [];
            $filter = [];
            if (count($result['object']['ShopProducts'])) {
                $results['ShopProducts'] = $result['object']['ShopProducts'];
                $results['pagination'] = $result['object']['pagination'];
                $results['brands'] = $result['object']['brands'];
                array_push($filter, ['type' => __('home.brand'), 'key' => 'brands', 'list' => $result['object']['brands']]);
                array_push($filter, ['type' => __('home.specifications'), 'key' => 'specifications', 'list' => $result['object']['specifications']]);
                $results['filter'] = $filter;
                $results['category'] = $result['object']['category'];
                return $this->response(200, $result['success'], 200, [], 0, $results);
            }
            return $this->response(101, "Validation Error", 200, ['This category has no products']);
        } elseif ($result['validator']) {
            return $this->response(101, "Validation Error", 200, $result['validator']);
        } elseif ($result['errors']) {
            return $this->response(500, $result['errors'], 500);
        } else {
            return $this->response(500, "Error", 500);
        }

    }

    public function filter(FilterShopProductRequest $request)
    {
        $this->shopProductRepo->setReq($request);
        $result = $this->shopProductRepo->getShopProducts();
        if ($result['success']) {
            $results = [];
            $filter = [];
            $selected_filter = [];

            array_push($filter, ['type' => __('home.brand'),
                'key' => 'brand', 'list' => $result['object']['brands']]);

            array_push($filter, ['type' => __('home.specifications'),
                'key' => 'specifications',
                'list' => $result['object']['specifications']]);

            if (!is_null($result['object']['filterd_brands'])) {
                array_push($selected_filter, ['type' => __('home.brand'),
                    'key' => 'brand', 'list' => $result['object']['filterd_brands']]);
            }

            if (!is_null($result['object']['filterd_specifications'])) {
                array_push($selected_filter, ['type' => __('home.specifications'),
                    'key' => 'specifications', 'list' => $result['object']['filterd_specifications']]);
            }

            if (!is_null($result['object']['filterd_categories'])) {
                array_push($selected_filter, ['type' => __('home.categories'),
                    'key' => 'categories', 'list' => $result['object']['filterd_categories']]);
            }
            if (!is_null($result['object']['fromPrice']) ||
                !is_null($result['object']['toPrice'])) {
                $price['form'] = $result['object']['fromPrice'];
                $price['to'] = $result['object']['toPrice'];

                array_push($selected_filter, ['type' => __('home.price'),
                    'key' => 'price',
                    'list' => collect($price)]);
            }

            if (!is_null($result['object']['category'])) {
                $category = Category::findOrFail($result['object']['category']->id);
                $results['category_breadcrumbs'] = $this->breadcrumbs($category);
            }
            $results['subCategories'] = $result['object']['subCategories'] ?? null;

            $results['selected_filter'] = $selected_filter;
            $results['filter'] = $filter;
            $results['ShopProducts'] = $result['object']['ShopProducts'];
            $results['pagination'] = $result['object']['pagination'];
            $results['brands'] = $result['object']['brands'];
            $results['category'] = $result['object']['category'];

            $results['searchKey'] = $result['object']['key'];
            $results['fromPrice'] = $result['object']['fromPrice'];
            $results['toPrice'] = $result['object']['toPrice'];

            return $this->response(200, $result['success'], 200, [], 0, $results);
        } elseif ($result['validator']) {
            return $this->response(101, "Validation Error", 200, $result['validator']);
        } elseif ($result['errors']) {
            return $this->response(500, $result['errors'], 500);
        } else {
            return $this->response(500, "Error", 500);
        }

    }

    private function breadcrumbs($category)
    {
        $categories = [];

        if ($category->level == 'level1') {
            $categories['tiny_category'] = null;
            $categories['sub_category'] = null;
        } elseif ($category->level == 'level2') {
            $categories['tiny_category'] = null;
        }

        $this->getParentCategory($category, $categories);
        return $categories;
    }

    private function getParentCategory($category, &$categories)
    {
        if (is_null($category->parent)) {
            $categories['category'] = ['id' => $category->id,
                'name' => $category->name,
                'banners' => CategoryBannerResource::collection(
                    CategoryBanner::where('category_id', $category->id)->get()
                )];

            return $category->name;
        }

        if (count($categories) == 0) {
            $categories['tiny_category'] = ['id' => $category->id,
                'name' => $category->name,
                'banners' => CategoryBannerResource::collection(
                    CategoryBanner::where('category_id', $category->id)->get()
                )];
        } else {
            $categories['sub_category'] = ['id' => $category->id,
                'name' => $category->name, 'banners' => CategoryBannerResource::collection(
                    CategoryBanner::where('category_id', $category->id)->get()
                )];
        }

        $parent = Category::where('id', $category->parent)->first();

        return $this->getParentCategory($parent, $categories);
    }
}
