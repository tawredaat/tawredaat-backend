<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BrandForHomeResource extends JsonResource
{
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
            'name' => $this->name,
            'slug' => $this->slug(),    
            'description' => $this->description,
            'image' => $this->image ? asset('storage/' . $this->image) : null,
            'alt' => $this->alt,
            'mobileimg' => $this->mobileimg ? asset('storage/' . $this->image) : null,

        ];
    }
}
