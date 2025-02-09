<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BrandShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => intval($this->id),
            'name' => $this->name,
            'slug' => $this->slug(),
            'title' => $this->title,
            'description' => $this->description,
            'slug' => $this->slug(),
            'image' => $this->image ? asset('storage/' . $this->image) : null,
            'alt' => $this->alt,
            'mobile_img' => $this->mobile_img,
        ];
    }
}
