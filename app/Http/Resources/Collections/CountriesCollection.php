<?php

namespace App\Http\Resources\Collections;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\CountryResource;

class CountriesCollection extends ResourceCollection
{
    public $searchSelection;

    /**
     * CountriesCollection constructor.
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
    	foreach ($this->collection as $country) {
            if(in_array($country->id,$this->searchSelection))
                array_push($data, new CountryResource($country,1));
            else
                array_push($data, new CountryResource($country));
    	}
    	return $data;
    }
}
