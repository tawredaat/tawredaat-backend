<?php

namespace App\Http\Controllers\User\Api;

use App\Repository\User\DynamicPageRepo;

class DynamicPageController extends BaseResponse
{

    protected $dynamicPageRepo;

    public function __construct(DynamicPageRepo $dynamicPageRepo)
    {
        $this->DynamicPageRepo = $dynamicPageRepo;
    }

    /**
     * View all level one categories
     *
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function dynamicPages()
    {
        $result = $this->DynamicPageRepo->dynamicPages();
        if ($result['success']) {
            return $this->response(200, $result['success'], 200, [], 0, $result['object']);
        } elseif ($result['errors']) {
            return $this->response(500, $result['errors'], 500);
        } else {
            return $this->response(500, "Error", 500);
        }

    }
    
    public function pageDetails($id)
    {
        $result = $this->DynamicPageRepo->dynamicDetails($id);
        if ($result['success']) {
            return $this->response(200, $result['success'], 200, [], 0, $result['object']);
        } elseif ($result['errors']) {
            return $this->response(500, $result['errors'], 500);
        } else {
            return $this->response(500, "Error", 500);
        }
    }
    
    public function pageSeo($id)
    {
        $result = $this->DynamicPageRepo->pageSeo($id);
        if ($result['success']) {
            return $this->response(200, $result['success'], 200, [], 0, $result['object']);
        } elseif ($result['errors']) {
            return $this->response(500, $result['errors'], 500);
        } else {
            return $this->response(500, "Error", 500);
        }
    }
}