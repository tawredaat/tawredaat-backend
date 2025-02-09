<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class ShopProductListResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        // Content-Language
        $locale = $request->header('Content-Language');
        if ($locale == 'en') {
            $brand_slug = Str::slug($this->brand->translate('en')->name);
        } else
            $brand_slug = slugInArabic($this->brand->translate('ar')->name);

        return [
            'id' => intval($this->id),
            'slug' => $this->slug(),
            'brand_slug' => $brand_slug,

        ];
    }
}
