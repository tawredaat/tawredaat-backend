<?php

namespace App\Http\Controllers\User\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\User\Api\StoreRFQRequest;
use App\Http\Requests\User\Api\StoreProductRfqBestSelling;

use App\Repository\User\RfqRepo;
class RfqController extends BaseResponse
{

    protected $rfqRepo;

    public function __construct(RfqRepo $rfqRepo)
    {
        $this->rfqRepo = $rfqRepo;
    }

    public function level3categories()
    {
        $result = $this->rfqRepo->allLevelThree();
        if($result['success'])
            return $this->response(200,$result['success'],200,[],0,$result['object']);
        elseif ($result['errors'])
            return $this->response(500,$result['errors'],500);
        else
            return $this->response(500,"Error",500);
    }

    public function view() {
       $result = $this->rfqRepo->getRfqs();
        if($result['success'])
            return $this->response(200,$result['success'],200,[],0,$result['object']);
        elseif($result['validator'])
            return $this->response( 101,"Validation Error",200,$result['validator']);
        elseif ($result['errors'])
            return $this->response(500,$result['errors'],500);
        else
            return $this->response(500,"Error",500);
     }

    public function send(StoreRFQRequest $request) {
        $this->rfqRepo->setReq($request);
        $result = $this->rfqRepo->store();
        if($result['success'])
            return $this->response(200,$result['success'],200);
        elseif($result['validator'])
            return $this->response( 101,"Validation Error",200,$result['validator']);
        elseif ($result['errors'])
            return $this->response(500,$result['errors'],500);
        else
            return $this->response(500,"Error",500);
     }

    public function accept($id) {
       $result = $this->rfqRepo->accept($id);
        if($result['success'])
            return $this->response(200,$result['success'],200);
        elseif($result['validator'])
            return $this->response( 101,"Validation Error",200,$result['validator']);
        elseif ($result['errors'])
            return $this->response(500,$result['errors'],500);
        else
            return $this->response(500,"Error",500);
     }

    public function reject($id) {
       $result = $this->rfqRepo->reject($id);
        if($result['success'])
            return $this->response(200,$result['success'],200);
        elseif($result['validator'])
            return $this->response( 101,"Validation Error",200,$result['validator']);
        elseif ($result['errors'])
            return $this->response(500,$result['errors'],500);
        else
            return $this->response(500,"Error",500);
     }

    public function companyResponse($id) {
        $result = $this->rfqRepo->companyResponse($id);
         if($result['success'])
             return $this->response(200,$result['success'],200,[],(int)$id,$result['object']);
         elseif($result['validator'])
             return $this->response( 101,"Validation Error",200,$result['validator']);
         elseif ($result['errors'])
             return $this->response(500,$result['errors'],500);
         else
             return $this->response(500,"Error",500);
    }

    /**
     * Request for best selling prices of a product
     *
     * @param ProductID $id
     *
     * */
    public function productRfqBestSelling(StoreProductRfqBestSelling $request,$id) {
        $this->rfqRepo->setReq($request);
        $result = $this->rfqRepo->productRfqBestSelling($id);
         if($result['success'])
             return $this->response(200,$result['success'],200,[],(int)$id,$result['object']);
         elseif($result['validator'])
             return $this->response( 101,"Validation Error",200,$result['validator']);
         elseif ($result['errors'])
             return $this->response(500,$result['errors'],500);
         else
             return $this->response(500,"Error",500);
    }

}
