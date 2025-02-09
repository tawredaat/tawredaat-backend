<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductSpecificationResource extends JsonResource
{
    public $searchSelection;
    /**
     * ProductSpecificationResource constructor.
     * @param $resource
     */
    public function __construct($resource,$searchSelection = 0)
    {
        parent::__construct($resource);
        $this->searchSelection = $searchSelection;

    }
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => intval($this->id),
            'selected'=>intval($this->searchSelection),
            'specification' => $this->specification?$this->specification->name:'',
            'value'=>$this->value,
        ];
    }
}
