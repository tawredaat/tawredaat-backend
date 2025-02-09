<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class BundelSeoResource extends JsonResource
{
    public function __construct($resource, $searchSelection = 0)
    {
        parent::__construct($resource);
        $this->searchSelection = $searchSelection;

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
            'title' => $this->title,
            'description' => $this->description,
          	'image' => $this->image !== null ? asset('storage/' . $this->image) : null,
        ];
    }
}
