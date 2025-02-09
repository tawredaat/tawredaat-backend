<?php

namespace App\Http\Resources;

use App\Http\Resources\Collections\InterestsCollection;
use App\Models\Interest;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * UserResource constructor.
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
            'full_name' => $this->full_name,
            'user_type' => $this->user_type,
            'email' => $this->email,
            'phone' => $this->phone,
            // 'created_at' => $this->created_at,
            // 'name' => $this->name,
            // 'last_name' => $this->last_name,
            // 'title' => $this->title,
            // 'company_name' => $this->company_name,
            // 'photo' => $this->photo ? asset('storage/' . $this->photo) : null,
            // 'isActive' => $this->isActive,
            // 'isVerify' => $this->isVerify,
            // 'provider' => $this->provider,
            // 'interests' => new InterestsCollection(Interest::find($this->interests ? $this->interests->pluck('interest_id') : [])),
        ];
    }
}
