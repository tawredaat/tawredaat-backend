<?php

namespace App\Http\Controllers\User\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\User\BrandRepo;
use App\Http\Resources\Collections\CompaniesCollection;
use App\Http\Requests\User\Api\SearchRequest;
class BrandController extends BaseResponse
{

    protected $brandRepo;

    public function __construct(BrandRepo $brandRepo)
    {
        $this->brandRepo = $brandRepo;
    }

    public function view(Request $request) {
       $this->brandRepo->setReq($request);
        $result = $this->brandRepo->getBrands();
         if($result['success']){
            $results = [];
            $filter = [];
             $results['brands'] =$result['object']['brands'];
             $results['pagination'] =$result['object']['pagination'];
             array_push($filter, ['type' => __('home.category'), 'list' => $result['object']['categories']]);
             array_push($filter, ['type' => __('home.brandOrigin'), 'list' => $result['object']['countries']]);
             array_push($filter, ['type' => __('home.company'), 'list' => $result['object']['companies']]);
             $results['filter']    = $filter;
             return $this->response(200,$result['success'],200,[],0,$results);
         }
         elseif ($result['errors'])
             return $this->response(500,$result['errors'],500);
         else
             return $this->response(500,"Error",500);
    }
    /**
     * Search in brands
     *
     * @param SearchRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(SearchRequest $request) {
        $this->brandRepo->setReq($request);
         $result = $this->brandRepo->getBrands();
          if($result['success']){
            $results = [];
            $filter = [];
            $results['brands']     =$result['object']['brands'];
            $results['pagination'] =$result['object']['pagination'];
            array_push($filter, ['type' => __('home.category'), 'list' => $result['object']['categories']]);
            array_push($filter, ['type' =>  __('home.brandOrigin'), 'list' => $result['object']['countries']]);
            array_push($filter, ['type' =>  __('home.company'), 'list' => $result['object']['companies']]);
            $results['filter']    = $filter;
            $results['search_key'] =$result['object']['key'];
            return $this->response(200,$result['success'],200,[],0,$results);
          }
          elseif ($result['errors'])
              return $this->response(500,$result['errors'],500);
          else
              return $this->response(500,"Error",500);
     }

    public function distributes($id) {
        $result = $this->brandRepo->companies($id);
            if($result['success']){
                $results=[];
                $results['distributorsType'] = $result['object']['distributors'];
                $results['brand'] = $result['object']['brand'];
                return $this->response(200,$result['success'],200,[],(int)$id,$results);
            }
            elseif($result['validator'])
                return $this->response( 101,"Validation Error",200,$result['validator']);
            elseif ($result['errors'])
              return $this->response(500,$result['errors'],500);
            else
              return $this->response(500,"Error",500);
     }

    public function show($id) {
         $result = $this->brandRepo->brand($id);
            if($result['success'])
              return $this->response(200,$result['success'],200,[],0,$result['object']);
            elseif($result['validator'])
                return $this->response( 101,"Validation Error",200,$result['validator']);
            elseif ($result['errors'])
              return $this->response(500,$result['errors'],500);
            else
              return $this->response(500,"Error",500);
     }
  
    public function brandSeo($id){
        $result = $this->brandRepo->brandSeo($id);
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
  
   public function brandsSeo(){
        $result = $this->brandRepo->brandsSeo();
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
