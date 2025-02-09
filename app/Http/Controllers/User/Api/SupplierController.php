<?php

namespace App\Http\Controllers\User\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\User\Api\StoreSupplierRequest;

use App\Repository\User\SupplierRepo;
class SupplierController extends BaseResponse
{

    protected $supplierRepo;

    public function __construct(SupplierRepo $supplierRepo)
    {
        $this->SupplierRepo = $supplierRepo;
    }

    public function store(StoreSupplierRequest $request) {
        $this->SupplierRepo->setReq($request);
        $result = $this->SupplierRepo->store();
        if($result['success'])
            return $this->response(200,$result['success'],200);
        elseif($result['validator'])
            return $this->response( 101,"Validation Error",200,$result['validator']);
        elseif ($result['errors'])
            return $this->response(500,$result['errors'],500);
        else
            return $this->response(500,"Error",500);
     }
}
