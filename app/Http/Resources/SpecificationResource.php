<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ProductSpecificationResource;
use App\Http\Resources\ShopProductSpecificationResource;

class SpecificationResource extends JsonResource
{
    public $searchSelection ;
    public $products;
    /**
     * SpecificationResource constructor.
     * @param $resource
     */
    public function __construct($resource,$searchSelection = [] ,$products=[])
    {
        parent::__construct($resource);
        $this->searchSelection = $searchSelection;
        $this->products = $products;

    }
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $shop_product_values = [];
        $values = [];
        foreach($this->values->whereIn('product_id',$this->products)->sortBy('value',SORT_NUMERIC) as $value){
            if(in_array($value->id,$this->searchSelection))
                array_push($values,new ProductSpecificationResource($value,1));
            else
                array_push($values,new ProductSpecificationResource($value,0));
        }
        foreach($this->shop_values()->whereIn('shop_product_id',$this->products)->groupby('value')->get()->sortBy('value',SORT_NUMERIC) as $value){
            if(in_array($value->id,$this->searchSelection))
                array_push($shop_product_values,new ShopProductSpecificationResource($value,1));
            else
                array_push($shop_product_values,new ShopProductSpecificationResource($value,0));
        }

        return [
            'id' => intval($this->id),
            'specification' => $this->name,
            'values'=>$values,
            'shop_product_values'=>$shop_product_values,
        ];
    }
}
