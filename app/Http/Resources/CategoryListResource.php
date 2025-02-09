<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class CategoryListResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
       
        // check app Language
        $locale = $request->header('Content-Language');
        if ($locale == 'en') {
            $slug = Str::slug($this->translate('en')->name);
        } else
            $slug = slugInArabic($this->translate('ar')->name);

        return [
            'id' => intval($this->id),
            'slug' => $this->slug(),
            'level' => $this->level,
            'childs' => CategoryListResource::collection($this->childs)
        ];
    }
}
