<?php

namespace App\Http\Resources\Collections;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\CompanyTypeResource;

class CompanyTypesCollection extends ResourceCollection

{
    public $searchSelection;

    /**
     * CompanyTypesCollection constructor.
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
    	foreach ($this->collection as $type) {
            if(in_array($type->id,$this->searchSelection))
                array_push($data, new CompanyTypeResource($type,1));
            else
    		array_push($data, new CompanyTypeResource($type));
    	}
    	return $data;
    }
}
