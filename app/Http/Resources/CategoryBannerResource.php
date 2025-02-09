<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryBannerResource extends JsonResource
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
            'image' => asset('storage/' . $this->image),
            'mobile_image' => asset('storage/' . $this->mobile_image),
            'alt' =>  $this->alt,
            'url' => $this->url,
        ];
    }
}
