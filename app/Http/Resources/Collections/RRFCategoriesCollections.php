<?php

namespace App\Http\Resources\Collections;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\RRFCategoryResource;

class RRFCategoriesCollections extends ResourceCollection
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
    	foreach ($this->collection as $rfq_category) {
    		array_push($data, new RRFCategoryResource($rfq_category));
    	}
    	return $data;
    }
}
