<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ShopProductResource;
use App\Http\Resources\CompanyResource;

class CartItemResource extends JsonResource
{
    private $user;
    /**
     * CartItemResource constructor.
     * @param $resource
     */
    public function __construct($resource,$user=null)
    {
        parent::__construct($resource);
        $this->user = $user;
    }


    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'          => intval($this->id),
            'quantity'    => $this->qty,
            'quantity_type'=>$this->shopProduct->QuantityType?$this->shopProduct->QuantityType->name:'',
            'shopProduct' => new ShopProductResource($this->shopProduct,$this->user),
            'price'     =>$this->shopProduct->new_price,
            'amount'     => strval($this->qty*(double)($this->shopProduct->new_price)),
        ];
    }
}
