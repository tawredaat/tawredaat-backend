<?php

namespace App\Http\Resources\Collections;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\SpecificationResource;

class SpecificationsCollection extends ResourceCollection
{
    /**
     * SpecificationsCollection constructor.
     * @param $resource
     * @param null $products
     */
    public function __construct($resource,  $searchSelection = [] , $products = [])
    {
        parent::__construct($resource);
        $this->searchSelection = $searchSelection;
        $this->products = $products;
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
    	foreach ($this->collection as $specification)
    	    	array_push($data, new SpecificationResource($specification,$this->searchSelection , $this->products));
        return $data;
    }
}
