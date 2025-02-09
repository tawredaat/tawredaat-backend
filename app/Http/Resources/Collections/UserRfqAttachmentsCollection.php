<?php

namespace App\Http\Resources\Collections;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\UserRfqAttachmentResource;

class UserRfqAttachmentsCollection extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
    	$data = [];
    	foreach ($this->collection as $attachment) {
    		array_push($data, new UserRfqAttachmentResource($attachment));
    	}
    	return $data;
    }
}
