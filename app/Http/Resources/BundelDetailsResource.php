<?php

namespace App\Http\Resources;

use App\Models\BrandBanner;
use App\Http\Resources\ShopProductResource;
use Illuminate\Http\Resources\Json\JsonResource;

class BundelDetailsResource extends JsonResource
{
    public $searchSelection;
    /**
     * AreaResource constructor.
     * @param $resource
     */
    public function __construct($resource, $searchSelection = 0)
    {
        parent::__construct($resource);
        $this->searchSelection = $searchSelection;

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
            'title' => $this->title,
            'quantity' => $this->qty,
            'name' => $this->name,
            'description' => $this->description,
            'description_meta' => $this->description_meta,
            'slug' => $this->slug(),
            'seller' => $this->seller,
            'sla' => $this->sla,
            'new_price' => $this->products()->sum('new_price')*((100-$this->discount_percentage)/100),
            'old_price' => $this->products()->sum('new_price'),
            'discount_percentage' => $this->discount_percentage,
            'image' => $this->image ? asset('storage/' . $this->image) : null,
            'alt' => $this->alt,
            'sku_code' => $this->sku_code,
            'note' => $this->note,
            'keywords' => $this->keywords,
            'keywords_meta' => $this->keywords_meta,
            'products_count' =>count($this->products()), 
            'products' => ShopProductResource::collection($this->products()),
        ];
    }
}
