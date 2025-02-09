<?php

namespace App\Http\Controllers\User\Api;

use App\Http\Resources\BrandListResource;
use App\Http\Resources\CategoryListResource;
use App\Http\Resources\ShopProductListResource;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ShopProduct;

class SiteMapController extends BaseResponse
{
    public function __invoke()
    {
        try {
            $products = ShopProduct::with('brand')->get();
            $brands = Brand::all();
            $categories = Category::whereNull('parent')->with('childs','childs.childs')->get();
            return
                ['validator' => null, 'success' => 'Site Map',
                'errors' => null,
                 'object' => [
                   'Products' => ShopProductListResource::collection($products)],
                   'Brands' => BrandListResource::collection($brands),
                   'Categories' => CategoryListResource::collection($categories)
                ];
        } catch (\Exception$exception) {
            return ['validator' => null, 'success' => null,
                'errors' => $exception, 'object' => null];
        }

    }
}
