<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Collections\RRFCategoriesCollections;

class RfqResource extends JsonResource
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
            'status' => intval($this->status),
            'categories'=> new RRFCategoriesCollections($this->rfq_category),
            'date'=>date('M d, Y',strtotime($this->created_at)),
            'time'=>date('h:i a',strtotime($this->created_at)),
            // 'user' => $this->user,
        ];
    }
}
