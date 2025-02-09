<?php

namespace App\Http\Resources;

use App\Models\BrandBanner;
use App\Http\Resources\Collections\CartItemsCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class CartBundelsResource extends JsonResource
{
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
            'bundel_items' =>new CartItemsCollection($this->items , $this->user), 
        ];
    }
}
