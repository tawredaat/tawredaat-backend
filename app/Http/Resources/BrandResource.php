<?php

namespace App\Http\Resources;

use App\Models\BrandBanner;
use Illuminate\Http\Resources\Json\JsonResource;

class BrandResource extends JsonResource
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
            'selected' => intval($this->searchSelection),
            'name' => $this->name,
            'slug' => $this->slug(),
            'description' => $this->description,
            'show' => $this->show ,
            'image' => $this->image ? asset('storage/' . $this->image) : null,
            'alt' => $this->alt,
            'country' => new CountryResource($this->country),
            'banners' => BrandBannerResource::
                collection(BrandBanner::where('brand_id', $this->id)->get()),
            'mobileimg' => asset('storage/' . $this->mobileimg),
        ];
    }
}
