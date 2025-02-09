<?php

namespace App\Http\Controllers\User\Api;

use App\Http\Requests\User\Api\Category\ViewL1CategoryRequest;
use App\Http\Resources\CategoryBannerResource;
use App\Http\Resources\CategoryNameImageOnlyResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ShopProductForHomeResource;
use App\Models\Category;
use App\Models\CategoryBanner;
use App\Models\ShopProduct;
use App\Repository\User\CategoryRepo;

class CategoryController extends BaseResponse
{

    protected $categoryRepo;

    public function __construct(CategoryRepo $categoryRepo)
    {
        $this->categoryRepo = $categoryRepo;
    }

    /**
     * View all level one categories
     *
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function allLevel1()
    {
        $result = $this->categoryRepo->allLevelOne();
        if ($result['success']) {
            return $this->response(200, $result['success'], 200, [], 0, $result['object']);
        } elseif ($result['errors']) {
            return $this->response(500, $result['errors'], 500);
        } else {
            return $this->response(500, "Error", 500);
        }

    }

    public function viewLevel1Category(ViewL1CategoryRequest $request)
    {
        try {
            $level_1_all_categories = Category::where('level', 'level1')->get();
            $category = Category::findOrFail($request->id);
            $all_2_level_categories_products = $this->level2CategoriesProducts($category);

            return $this->response(200, "View Level One Category", 200, [], 0, [
                'category' => ['id' => $category->id,
                    'banner' => CategoryBannerResource::collection(
                        CategoryBanner::where('category_id', $category->id)->get())],
                'allLevel1Categories' => CategoryNameImageOnlyResource::collection($level_1_all_categories),
                'allCategories' => $all_2_level_categories_products,
            ]);

        } catch (\Exception $e) {
            return $this->response(500, "Error" . $e->getMessage(), 500);
        }
    }

    // return level 1 categories and all the featured products under them
    public function level2CategoriesProducts($level_1_category)
    {
        try {
            $categories_products = [];
            $level_2_categories = $level_1_category->childs()
                ->get();

            if (count($level_2_categories) > 0) {
                foreach ($level_2_categories as $level_2_category) {
                    $level_3_categories = $level_2_category->childs()
                        ->pluck('id')->toArray();
                    $shop_products =
                    ShopProduct::whereIn('category_id', $level_3_categories)->limit(15)->get();
                    array_push($categories_products,
                        ['category' => new CategoryResource($level_2_category),
                            'products' => ShopProductForHomeResource::collection($shop_products)]);
                }
            }
            return $categories_products;
        } catch (\Exception $exception) {
            return [];
        }
    }

    /**
     * View level two categories based on level one
     *
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function level1($id)
    {
        $result = $this->categoryRepo->levelOne($id);
        if ($result['success']) {
            return $this->response(200, $result['success'], 200, [], (int) $id, $result['object']);
        } elseif ($result['validator']) {
            return $this->response(101, "Validation Error", 200, $result['validator']);
        } elseif ($result['errors']) {
            return $this->response(500, $result['errors'], 500);
        } else {
            return $this->response(500, "Error", 500);
        }

    }
    /**
     * View level three categories based on level two
     *
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function level2($id)
    {
        $result = $this->categoryRepo->levelTwo($id);
        if ($result['success']) {
            return $this->response(200, $result['success'], 200, [], (int) $id, $result['object']);
        } elseif ($result['validator']) {
            return $this->response(101, "Validation Error", 200, $result['validator']);
        } elseif ($result['errors']) {
            return $this->response(500, $result['errors'], 500);
        } else {
            return $this->response(500, "Error", 500);
        }

    }

    public function show($id){
        $result = $this->categoryRepo->show($id);
        if ($result['success']) {
            return $this->response(200, $result['success'], 200, [], (int) $id, $result);
        } elseif ($result['validator']) {
            return $this->response(101, "Validation Error", 200, $result['validator']);
        } elseif ($result['errors']) {
            return $this->response(500, $result['errors'], 500);
        } else {
            return $this->response(500, "Error", 500);
        }
    }
    
    public function recentlyArrived($id){
        $result = $this->categoryRepo->recentlyArrived($id);
        if ($result['success']) {
            return $this->response(200, $result['success'], 200, [], (int) $id, $result['object']);
        } elseif ($result['validator']) {
            return $this->response(101, "Validation Error", 200, $result['validator']);
        } elseif ($result['errors']) {
            return $this->response(500, $result['errors'], 500);
        } else {
            return $this->response(500, "Error", 500);
        }
    }
    
    public function bestSeller($id){
        $result = $this->categoryRepo->bestSeller($id);
        if ($result['success']) {
            return $this->response(200, $result['success'], 200, [], (int) $id, $result['object']);
        } elseif ($result['validator']) {
            return $this->response(101, "Validation Error", 200, $result['validator']);
        } elseif ($result['errors']) {
            return $this->response(500, $result['errors'], 500);
        } else {
            return $this->response(500, "Error", 500);
        }
    }
    
    public function categoryBrands($id){
        $result = $this->categoryRepo->categoryBrands($id);
        if ($result['success']) {
            return $this->response(200, $result['success'], 200, [], (int) $id, $result);
        } elseif ($result['validator']) {
            return $this->response(101, "Validation Error", 200, $result['validator']);
        } elseif ($result['errors']) {
            return $this->response(500, $result['errors'], 500);
        } else {
            return $this->response(500, "Error", 500);
        }
    }
    
    public function categoryOffers($id){
        $result = $this->categoryRepo->categoryOffers($id);
        if ($result['success']) {
            return $this->response(200, $result['success'], 200, [], (int) $id, $result['object']);
        } elseif ($result['validator']) {
            return $this->response(101, "Validation Error", 200, $result['validator']);
        } elseif ($result['errors']) {
            return $this->response(500, $result['errors'], 500);
        } else {
            return $this->response(500, "Error", 500);
        }
    }

    public function categoryLevelOne($id){
    $result = $this->categoryRepo->categoryLevelOne($id);
    if ($result['success']) {
        return $this->response(200, $result['success'], 200, [], (int) $id, $result['object']);
    } elseif ($result['validator']) {
        return $this->response(101, "Validation Error", 200, $result['validator']);
    } elseif ($result['errors']) {
        return $this->response(500, $result['errors'], 500);
    } else {
        return $this->response(500, "Error", 500);
    }
}

    public function categoryLevelTwo($id){
        $result = $this->categoryRepo->categoryLevelTwo($id);
        if ($result['success']) {
            return $this->response(200, $result['success'], 200, [], (int) $id, $result['object']);
        } elseif ($result['validator']) {
            return $this->response(101, "Validation Error", 200, $result['validator']);
        } elseif ($result['errors']) {
            return $this->response(500, $result['errors'], 500);
        } else {
            return $this->response(500, "Error", 500);
        }
    }
    
    public function categoryLevelThree($id){
        $result = $this->categoryRepo->categoryLevelThree($id);
        if ($result['success']) {
            return $this->response(200, $result['success'], 200, [], (int) $id, $result['object']);
        } elseif ($result['validator']) {
            return $this->response(101, "Validation Error", 200, $result['validator']);
        } elseif ($result['errors']) {
            return $this->response(500, $result['errors'], 500);
        } else {
            return $this->response(500, "Error", 500);
        }
    }
    
    public function categoryLevelThreeProductsCount($id){
        $result = $this->categoryRepo->categoryLevelThreeProductsCount($id);
        if ($result['success']) {
            return $this->response(200, $result['success'], 200, [], (int) $id, $result['object']);
        } elseif ($result['validator']) {
            return $this->response(101, "Validation Error", 200, $result['validator']);
        } elseif ($result['errors']) {
            return $this->response(500, $result['errors'], 500);
        } else {
            return $this->response(500, "Error", 500);
        }
    }
    
    public function categoryLevelThreeFilterList($id){
        $result = $this->categoryRepo->categoryLevelThreeFilterList($id);
        if ($result['success']) {
            return $this->response(200, $result['success'], 200, [], (int) $id, $result['object']);
        } elseif ($result['validator']) {
            return $this->response(101, "Validation Error", 200, $result['validator']);
        } elseif ($result['errors']) {
            return $this->response(500, $result['errors'], 500);
        } else {
            return $this->response(500, "Error", 500);
        }
    }
    
    public function offerBanner(){
        $result = $this->categoryRepo->offerBanner();
        if ($result['success']) {
            return $this->response(200, $result['success'], 200, [], 0 ,$result['object']);
        } elseif ($result['validator']) {
            return $this->response(101, "Validation Error", 200, $result['validator']);
        } elseif ($result['errors']) {
            return $this->response(500, $result['errors'], 500);
        } else {
            return $this->response(500, "Error", 500);
        }
    }
  
    public function categorySeo($id){
        $result = $this->categoryRepo->categorySeo($id);
        if ($result['success']) {
            return $this->response(200, $result['success'], 200, [], 0 ,$result['object']);
        } elseif ($result['validator']) {
            return $this->response(101, "Validation Error", 200, $result['validator']);
        } elseif ($result['errors']) {
            return $this->response(500, $result['errors'], 500);
        } else {
            return $this->response(500, "Error", 500);
        }
    }
  
  public function offerSeo(){
        $result = $this->categoryRepo->offerSeo();
        if ($result['success']) {
            return $this->response(200, $result['success'], 200, [], 0 ,$result['object']);
        } elseif ($result['validator']) {
            return $this->response(101, "Validation Error", 200, $result['validator']);
        } elseif ($result['errors']) {
            return $this->response(500, $result['errors'], 500);
        } else {
            return $this->response(500, "Error", 500);
        }
    }
}