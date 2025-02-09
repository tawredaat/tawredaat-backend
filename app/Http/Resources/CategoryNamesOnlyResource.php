<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryNamesOnlyResource extends JsonResource
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
            'level' => str_replace("level", "", $this->level),
            'childs' => CategoryNamesOnlyResource::collection($this->childs()->get()),
        ];

    }

}
