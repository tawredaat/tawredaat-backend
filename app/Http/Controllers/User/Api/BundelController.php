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
use App\Repository\User\BundelRepo;

class BundelController extends BaseResponse
{

    protected $bundelRepo;

    public function __construct(BundelRepo $bundle_ids)
    {
        $this->BundelRepo = $bundle_ids;
    }

    /**
     * View all level one categories
     *
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function categoryBundels($category_id)
    {
        $result = $this->BundelRepo->categoryBundels($category_id);
        if ($result['success']) {
            return $this->response(200, $result['success'], 200, [], 0, $result['object']);
        } elseif ($result['errors']) {
            return $this->response(500, $result['errors'], 500);
        } else {
            return $this->response(500, "Error", 500);
        }

    }
    
    public function bundelBanner()
    {
        $result = $this->BundelRepo->bundelBanner();
        if ($result['success']) {
            return $this->response(200, $result['success'], 200, [], 0, $result['object']);
        } elseif ($result['errors']) {
            return $this->response(500, $result['errors'], 500);
        } else {
            return $this->response(500, "Error", 500);
        }
    }
    
    public function bundelDetails($id)
    {
        $result = $this->BundelRepo->bundelDetails($id);
        if ($result['success']) {
            return $this->response(200, $result['success'], 200, [], 0, $result['object']);
        } elseif ($result['errors']) {
            return $this->response(500, $result['errors'], 500);
        } else {
            return $this->response(500, "Error", 500);
        }
    }
  
    public function bundelsSeo(){
        $result = $this->BundelRepo->bundelsSeo();
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
  
    public function bundelSeo($id){
        $result = $this->BundelRepo->bundelSeo($id);
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