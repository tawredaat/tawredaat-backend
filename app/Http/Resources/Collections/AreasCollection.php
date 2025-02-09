<?php

namespace App\Http\Resources\Collections;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\AreaResource;

class AreasCollection extends ResourceCollection
{
    public $searchSelection;

    /**
     * AreasCollection constructor.
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
    	foreach ($this->collection as $area) {
            if(in_array($area->id,$this->searchSelection))
        		array_push($data, new AreaResource($area,1));
            else
        		array_push($data, new AreaResource($area));
    	}
    	return $data;
    }
}
