<?php

namespace App\Http\Resources\Collections;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\ShopProductSpecificationResource;

class ShopProductSpecificationsCollection extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
    	$data = [];
    	foreach ($this->collection as $specification) {
    		array_push($data, new ShopProductSpecificationResource($specification));
    	}
    	return $data;
    }
}
