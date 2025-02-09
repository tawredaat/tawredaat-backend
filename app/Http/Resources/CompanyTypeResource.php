<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyTypeResource extends JsonResource
{
    public $searchSelection;
    /**
     * CategoryResource constructor.
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
            'name' => $this->name,
        ];
    }
}
