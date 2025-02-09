<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CategoryResource;

class RRFCategoryResource extends JsonResource
{
    /**
     * BrandResource constructor.
     * @param $resource
     */
    public function __construct($resource)
    {
        parent::__construct($resource);
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
            'category' => isset($this->category) ? $this->category->name : "",//new CategoryResource($this->category),
            'description' => $this->description,
            'quantity'=>$this->quantity,
        ];
    }
}
