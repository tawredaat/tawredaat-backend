<?php

namespace App\Http\Resources;

use App\Models\BrandBanner;
use App\Http\Resources\Collections\OrderItemsCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderBundelsResource extends JsonResource
{
    public function __construct($resource, $order_id)
    {
        parent::__construct($resource);
        $this->order_id = $order_id;
    }
    
    public function toArray($request)
    {
        return [
            'id' => intval($this->id),
            'name' => $this->name,
            'slug' => $this->slug(),
            'old_price' => $this->products()->sum('new_price'),
            'image' => $this->image ? asset('storage/' . $this->image) : null,
            'alt' => $this->alt,
            'sku_code' => $this->sku_code,
            'discount_percentage' => $this->discount_percentage,
            'total' => $this->bundelItemsTotal() * ((100-$this->discount_percentage)/100),
            'bundel_items' =>new OrderItemsCollection($this->order_items($this->order_id) , $this->user), 
        ];
    }
}
