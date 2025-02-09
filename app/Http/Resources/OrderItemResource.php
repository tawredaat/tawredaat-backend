<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
class OrderItemResource extends JsonResource
{
    /**
     * OrderItemResource constructor.
     * @param $resource
     */
    public function __construct($resource)
    {
        parent::__construct($resource);
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
            'id' => intval($this->id),
            'productId' => $this->shopProduct? intval($this->shopProduct->id):0,
            'productName'=>$this->shopProduct?$this->shopProduct->name:'Soled out',
            'productImage'=>$this->shopProduct?asset('storage/' . $this->shopProduct->image) :null,
            'quantity' => "$this->quantity",
            'price'=> "$this->price",
            'amount'=> "$this->amount",
            'productSlug' => $this->shopProduct?$this->shopProduct->slug:null,
            'brand' => $this->shopProduct? new BrandResource($this->shopProduct->brand) :null,
        ];
    }
}
