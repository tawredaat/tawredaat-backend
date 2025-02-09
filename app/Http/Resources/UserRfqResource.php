<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Collections\UserRfqAttachmentsCollection;

class UserRfqResource extends JsonResource
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
            'id'           => intval($this->id),
            'status'       => $this->status,
            'statusColor'  => $this->statusColor(),
            'description'  => $this->description,
            'date'         => date('M d, Y',strtotime($this->created_at)),
            'time'         => date('h:i a',strtotime($this->created_at)),
            'companyResponse' => $this->admin_response,
            'user_name'=> $this->user_name,
            'phone' => $this->phone,
            'email'=> $this->email,
            'attachments'  => new UserRfqAttachmentsCollection($this->attachments),
        ];
    }
}
