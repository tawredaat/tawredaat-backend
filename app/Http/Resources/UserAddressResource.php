<?php

namespace App\Http\Resources;

use App\Http\Resources\CityResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserAddressResource extends JsonResource
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
        $is_default = $this->is_default;
        if (is_null($is_default)) {
            $is_default = 0;
        }
        return [
            'id' => intval($this->id),
            'country' => new CityResource($this->city),
            'area' => $this->area,
            'detailed_address' => $this->detailed_address,
            'address_type' => $this->address_type,
            'reciever_name' => $this->reciever_name,
            'reciever_phone' => $this->reciever_phone,
            'longitude' => $this->longitude,
            'latitude' => $this->latitude,
            'selected' => (auth('api')->user() && auth('api')->user()->user_address_id == $this->id) ? 1 : 0,
            'is_default' => (bool) $is_default,
        ];
    }
}
