<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ShopProductRecentlyViewedResource extends JsonResource
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
            'new_price' => $this->new_price,
            'old_price' => $this->old_price,
            'image' => $this->image ? asset('storage/' . $this->image) : null,
            'mobileimg' => $this->mobileimg ? asset('storage/' . $this->mobileimg) : null,
        ];
    }
}
