<?php

namespace App\Http\Resources\Collections;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\CompanyResource;

class CompaniesCollection extends ResourceCollection
{
    /**
     * CompaniesCollection constructor.
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
    	foreach ($this->collection as $company) {
            if(in_array($company->id,$this->searchSelection))
                array_push($data, new CompanyResource($company,1));
            else
    	    	array_push($data, new CompanyResource($company));
    	}
    	return $data;
    }
}
