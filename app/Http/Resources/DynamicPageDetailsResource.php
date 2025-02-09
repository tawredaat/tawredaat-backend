<?php

namespace App\Http\Resources;

use App\Models\BrandBanner;
use Illuminate\Http\Resources\Json\JsonResource;

class DynamicPageDetailsResource extends JsonResource
{
    public $searchSelection;
    /**
     * AreaResource constructor.
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
            'name' => $this->name,
            'slug' => $this->slug(),
            'image' => $this->main_banner ? asset('storage/' . $this->main_banner) : null,
            'mobile_image' => $this->main_banner_mobile ? asset('storage/' . $this->main_banner_mobile) : null,
            'description' => $this->description,
            'alt' => $this->alt,
            'page_title' => $this->page_title,
        ];
    }
}
