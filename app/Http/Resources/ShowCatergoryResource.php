<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ShowCategoryResource extends JsonResource
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
            'id' => intval($this->id),
            //'selected' => intval($this->searchSelection),
            'name' => $this->name,
            'slug' => $this->slug(),
            'image' => $this->image ? asset('storage/' . $this->image) : null,
            'alt' => $this->alt,
            'level' => str_replace("level", "", $this->level),
            'parent' => new ShowCategoryResource($this->parent_category),
        ];
    }
}
