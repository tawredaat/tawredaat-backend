<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TopCategoryHomeScreen extends JsonResource
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
            'level'=>$this->level,
            'image' => asset('storage/' . $this->image),
            'alt' =>  $this->alt,
            'url' => $this->url,
            'parent_category' => new TopCategoryHomeScreen($this->parent_category),
        ];
    }
}
