<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryNameImageOnlyResource extends JsonResource
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
            'slug' =>$this->slug(),
            'alt' => $this->alt,
            'image' => asset('storage/' . $this->image),
            'level' => str_replace("level", "", $this->level),
            'homeBanners' => new CategoryBannerResource($this->homeBanners()),
            'homeBrands'  => TopBrandHomeScreen::collection($this->homeBrands()),
            'topCategories'  => TopCategoryHomeScreen::collection($this->homeCategories()),
        ];
    }
}
