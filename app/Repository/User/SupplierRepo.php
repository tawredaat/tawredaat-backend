<?php

namespace App\Repository\User;

use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Http\Resources\RfqResource;
use Illuminate\Support\Facades\DB;

class SupplierRepo
{
    private $request;
    private $result = array();

    public function setReq(Request $request)
    {  
        $this->request = $request;
    }

    public function store()
    {
        $request = $this->request;
    
        try{
            DB::beginTransaction();
            Supplier::create(
                [
                   'category_name' => json_encode($request->category_name),
                   'city_id'       => $request->city_id,
                   'full_name'     => $request->full_name,
                   'phone'         => $request->phone,
                   'email'         => $request->email,
                ]);
            
            DB::commit();
            return $this->result = ['validator' => null, 'success' => __('home.RFQSent'),'errors'=>null];

        }catch (\Exception $exception) {
            DB::rollback();
            return $this->result = ['validator' => null , 'success' => null,'errors'=>$exception,'object'=>null];
        }
    }
}
