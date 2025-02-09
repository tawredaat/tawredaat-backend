<?php

namespace App\Http\Controllers\User\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\User\CompanyRepo;
use App\Http\Requests\User\Api\SearchRequest;
class CompanyController extends BaseResponse
{

    protected $companyRepo;

    public function __construct(CompanyRepo $companyRepo)
    {
        $this->companyRepo = $companyRepo;
    }

    public function view(Request $request) {
       $this->companyRepo->setReq($request);
        $result = $this->companyRepo->getCompanies();
         if($result['success']){
            $results = [];
            $filter = [];
            $results['companies'] =$result['object']['companies'];
            $results['pagination'] =$result['object']['pagination'];
            array_push($filter, ['type' => __('home.brand'), 'list' => $result['object']['brands']]);
            array_push($filter, ['type' => __('home.category'), 'list' => $result['object']['categories']]);
            array_push($filter, ['type' => __('home.area'), 'list' => $result['object']['areas']]);
            array_push($filter, ['type' => __('home.companyType'), 'list' => $result['object']['types']]);
            $results['filter']    = $filter;
             return $this->response(200,$result['success'],200,[],0,$results);
         }
         elseif ($result['errors'])
             return $this->response(500,$result['errors'],500);
         else
             return $this->response(500,"Error",500);
    }

    public function search(SearchRequest $request) {
        $this->companyRepo->setReq($request);
         $result = $this->companyRepo->getCompanies();
          if($result['success']){
             $results = [];
             $filter = [];
              $results['companies']  =$result['object']['companies'];
              $results['pagination'] =$result['object']['pagination'];
              array_push($filter, ['type' => __('home.brand'), 'list' => $result['object']['brands']]);
              array_push($filter, ['type' => __('home.category'), 'list' => $result['object']['categories']]);
              array_push($filter, ['type' => __('home.area'), 'list' => $result['object']['areas']]);
              array_push($filter, ['type' => __('home.companyType'), 'list' => $result['object']['types']]);
              $results['filter']    = $filter;
              $results['search_key'] =$result['object']['key'];
              return $this->response(200,$result['success'],200,[],0,$results);
          }
          elseif ($result['errors'])
              return $this->response(500,$result['errors'],500);
          else
              return $this->response(500,"Error",500);
     }

    public function show($id) {
         $result = $this->companyRepo->company($id);
            if($result['success'])
              return $this->response(200,$result['success'],200,[],0,$result['object']);
            elseif($result['validator'])
                return $this->response( 101,"Validation Error",200,$result['validator']);
            elseif ($result['errors'])
              return $this->response(500,$result['errors'],500);
            else
              return $this->response(500,"Error",500);
     }
}
