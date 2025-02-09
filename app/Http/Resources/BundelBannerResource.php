<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BundelBannerResource extends JsonResource
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
            'url' => $this->url,
            'image' => $this->img ? asset('storage/' . $this->img) : null,
            'alt' => $this->alt,
            'mobile_img' => $this->mobileimg ? asset('storage/' . $this->mobileimg) : null,
        ];
    }
}
