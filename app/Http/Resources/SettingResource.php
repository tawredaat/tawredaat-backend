<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
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
            'email' => $this->email,
            'phone' => $this->phone,
            'fax' => $this->fax,
            'address' => $this->address,
            'facebook' => $this->facebook,
            'insta' => $this->insta,
            'youtube' => $this->youtube,
            'linkedin' => $this->linkedin,
            'twitter' => $this->twitter,
            'free_shipping_amount' => $this->free_shipping_amount,
          	'minimum_order_amount' => $this->minimum_order_amount,
            'brand_image' => $this->brand_image ? asset('storage' . DIRECTORY_SEPARATOR . $this->brand_image) : null,
            'company_image' => $this->company_image ? asset('storage' . DIRECTORY_SEPARATOR . $this->company_image) : null,
            'favicon' => $this->favicon ? asset('storage' . DIRECTORY_SEPARATOR . $this->favicon) : null,
            'address' => $this->address,
            'homeTitle' => $this->title,
            'homeMetaKeywords' => $this->keywords,
            'homeMetaDescription' => $this->Meta_Description,
            'description' => $this->description,
            'logo' => $this->logo ? asset('storage' . DIRECTORY_SEPARATOR . $this->logo) : null,
            'logoAlt' => $this->logo_alt,
            'siteLogo' => $this->site_logo ? asset('storage' . DIRECTORY_SEPARATOR . $this->site_logo) : null,
            'sitelogoAlt' => $this->siteLogoAlt,
            'footerLogo' => $this->footer_logo ? asset('storage' . DIRECTORY_SEPARATOR . $this->footer_logo) : null,
            'footerlogoAlt' => $this->footerLogoAlt,
            'rfq_image' => $this->rfq_image ? asset('storage' . DIRECTORY_SEPARATOR . $this->rfq_image) : null,
            'rfq_banner' => $this->rfq_banner ? asset('storage' . DIRECTORY_SEPARATOR . $this->rfq_banner) : null,
            'brand_store_banner'=>$this->brand_store_banner ? asset('storage' . DIRECTORY_SEPARATOR . $this->brand_store_banner) : null,
        ];
    }
}