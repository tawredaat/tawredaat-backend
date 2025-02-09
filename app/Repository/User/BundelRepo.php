<?php

namespace App\Repository\User;

use App\Helpers\General;
use App\Http\Resources\BundelResource;
use App\Http\Resources\BrandResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\BundelDetailsResource;
use App\Http\Resources\ShopProductResource;
use App\Http\Resources\BundelBannerResource;
use App\Http\Resources\PageSeoResource;
use App\Http\Resources\BundelSeoResource;
use App\Models\Brand;
use App\Models\ShopProduct;
use App\Models\BrandBanner;
use App\Models\BrandCategory;
use App\Models\Category;
use App\Models\BundelCategory;
use App\Models\Bundel;
use App\Models\Banner;
use App\Models\ShopProductSpecification;
use App\Models\Seo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BundelRepo
{
    private $request;
    private $result = array();

    public function categoryBundels($category_id)
    {
        $bundel_ids = BundelCategory::where('category_id', $category_id)->pluck('bundel_id')->toArray();
        $bundels = Bundel::whereIn('id', $bundel_ids)->where('show', 1)->orderBy('created_at', 'desc')->paginate(9);
        $results['bundels'] = BundelResource::collection($bundels);
        $results['pagination'] = General::createPaginationArray($bundels);
        return $this->result = ['validator' => null, 'success' => 'Brand Details', 'errors' => null, 'object' => $results];
    }

    public function bundelBanner()
    {
        $results['main_banner'] = new BundelBannerResource(Banner::where('section' , '=' , 10)->first());
        $bundelCategoriesIds = BundelCategory::distinct()->pluck('category_id');
        $categories = Category::whereIn('id', $bundelCategoriesIds)->where('level' , 'level1')->get();
        $results ['categories'] = CategoryResource::collection($categories);
        return $this->result = ['validator' => null, 'success' => 'Brand Details', 'errors' => null, 'object' => $results];
    }
    
    public function bundelDetails($id)
    {
        $bundel = Bundel::find($id);
        $randomBundels = Bundel::where('id', '!=', $id)
                ->inRandomOrder()
                ->take(6)
                ->get();
        $results['bundel'] = new BundelDetailsResource($bundel);
        $results['related_bundels'] = BundelResource::collection($randomBundels);
        return $this->result = ['validator' => null, 'success' => 'Brand Details', 'errors' => null, 'object' => $results];
    }
  
    public function bundelsSeo()
    {
      	$bundelSeo = Seo::where('page_name' , 'bundels')->first();
        $results['seo'] = new PageSeoResource($bundelSeo);
        return $this->result = ['validator' => null, 'success' => 'Bundels Page Seo', 'errors' => null, 'object' => $results];
    }
  
    public function bundelSeo($id)
    {
      	$bundel = Bundel::find($id);
        $results['seo'] = new BundelSeoResource($bundel);
        return $this->result = ['validator' => null, 'success' => 'Bundel Seo', 'errors' => null, 'object' => $results];
    }
}
