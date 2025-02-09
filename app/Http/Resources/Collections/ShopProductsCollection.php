<?php

namespace App\Http\Resources\Collections;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\ShopProductResource;

class ShopProductsCollection extends ResourceCollection
{
    private $user;

    public function __construct($resource, $user)
    {
        parent::__construct($resource);

        $this->user = $user;
    }
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
    	$data = [];
    	foreach ($this->collection as $product) {
    		array_push($data, new ShopProductResource($product,$this->user));
    	}
    	return $data;
    }
}
