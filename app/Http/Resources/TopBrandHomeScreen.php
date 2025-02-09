<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TopBrandHomeScreen extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug(),
            'image' => asset('storage/' . $this->image),
            'mobile_image' => asset('storage/' . $this->mobileimg),
            'alt' =>  $this->alt,
            'url' => $this->url,
        ];
    }
}
