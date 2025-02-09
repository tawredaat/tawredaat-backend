<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RfqResponseResource extends JsonResource
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
            //'rfq' => $this->rfq,
            'company' => (isset($this->company)) ? $this->company->name : "",
            'status' => intval($this->status),
            'responseDescription' => $this->responseDescription,
        ];
    }
}
