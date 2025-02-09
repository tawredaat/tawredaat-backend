<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserRfqAttachmentResource extends JsonResource
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
            'id'          => intval($this->id),
            'attachment'  => asset('storage'.DIRECTORY_SEPARATOR. $this->attachment),
        ];
    }
}
