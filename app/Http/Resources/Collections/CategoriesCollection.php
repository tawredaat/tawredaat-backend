<?php

namespace App\Http\Resources\Collections;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\CategoryResource;

class CategoriesCollection extends ResourceCollection
{
    public $searchSelection;
    public $view;

    /**
     * CategoriesCollection constructor.
     * @param $resource
     * @param null $searchSelection
     */
    public function __construct($resource, $searchSelection = [],$view=null)
    {
        parent::__construct($resource);
        $this->searchSelection = $searchSelection;
        $this->view = $view;
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
    	foreach ($this->collection as $category) {
            if(in_array($category->id,$this->searchSelection))
                array_push($data, new CategoryResource($category,1,$this->view));
            else
    	    	array_push($data, new CategoryResource($category,0,$this->view));
    	}
    	return $data;
    }
}
