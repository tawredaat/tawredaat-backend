<?php

namespace App\Http\Resources\Collections;

use App\Http\Resources\ShopProductForHomeResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ShopProductsForHomeCollection extends ResourceCollection
{
    private $user;

    public function __construct($resource, $user)
    {
        parent::__construct($resource);

        $this->user = $user;
    }
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = [];
        foreach ($this->collection as $product) {
            array_push($data, new ShopProductForHomeResource($product, $this->user));
        }
        return $data;
    }
}
