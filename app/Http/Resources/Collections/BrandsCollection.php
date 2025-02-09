<?php

namespace App\Http\Resources\Collections;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\BrandResource;

class BrandsCollection extends ResourceCollection
{
    public $searchSelection;

    /**
     * BrandCollection constructor.
     * @param $resource
     * @param null $searchSelection
     */
    public function __construct($resource, $searchSelection = [])
    {
        parent::__construct($resource);
        $this->searchSelection = $searchSelection;
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
    	foreach ($this->collection as $brand) {
            if(in_array($brand->id,$this->searchSelection))
                array_push($data, new BrandResource($brand,1));
            else
    	    	array_push($data, new BrandResource($brand));
    	}
    	return $data;
    }
}
