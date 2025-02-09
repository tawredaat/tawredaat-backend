<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdsBannerResource extends JsonResource
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
            'firstURL' => $this->firstURL,
            'firstImage' => $this->firstImage ? asset('storage/' . $this->firstImage) : null,
            'firstImageAlt' => $this->firstImageAlt,
            'secondURL' => $this->secondURL,
            'secondImage' => $this->secondImage ? asset('storage/' . $this->secondImage) : null,
            'secondImageAlt' => $this->secondImageAlt,
        ];
    }
}
