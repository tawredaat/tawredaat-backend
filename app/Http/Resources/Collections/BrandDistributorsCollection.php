<?php

namespace App\Http\Resources\Collections;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\BrandDistributorResource;

class BrandDistributorsCollection extends ResourceCollection
{
    private $brand_companies;

    public function __construct($resource, $brand_companies)
    {
        parent::__construct($resource);

        $this->brand_companies = $brand_companies;
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
    	foreach ($this->collection as $dist) {
    		array_push($data, new BrandDistributorResource($dist, $this->brand_companies));
    	}
    	return $data;
    }
}
