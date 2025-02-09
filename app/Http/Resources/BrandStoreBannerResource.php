<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BrandStoreBannerResource extends JsonResource
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
            'alt' => $this->alt,
            'mobile_image' => asset('storage/' . $this->mobile_image),
            'url' => $this->url,
        ];
    }
}
