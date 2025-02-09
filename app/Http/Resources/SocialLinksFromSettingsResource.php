<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SocialLinksFromSettingsResource extends JsonResource
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
            'facebook' => $this->facebook,
            'instagram' => $this->insta,
            'linkedin' => $this->linkedin,
            'youtube' => $this->youtube,
            'whatsapp' => $this->phone,
        ];
        return parent::toArray($request);
    }
}
