<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ProductResource;

class ProductRfqResource extends JsonResource
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
            'message' => $this->message,
            'product' => new ProductResource($this->companyProduct?$this->companyProduct->product:null),
            // 'user' => $this->user,
            'company' => $this->company,
        ];
    }
}
