<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Collections\ProductSpecificationsCollection;
use App\Http\Resources\Collections\CompaniesCollection;
use App\Http\Resources\Collections\ProductsCollection;
use App\Models\Product;
class ProductResource extends JsonResource
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
        $prices   = [];
        $companies = [];
        $minPrice = null;
        $minUnit  = null;
        $price = null;
        foreach($this->companyProducts as $companyProduct){
                array_push($companies,$companyProduct->company);
                if($companyProduct->discount_type=='percentage')
                        $finalPrice = $companyProduct->price-(($companyProduct->price*$companyProduct->discount)/100);
                else
                        $finalPrice = $companyProduct->price-$companyProduct->discount;
            if($finalPrice){
                array_push($prices,$finalPrice);
                $minPrice = min($prices);
                if($minPrice==$finalPrice)
                    $minUnit= $companyProduct->unit?'/'.$companyProduct->unit->name:'';
            }

        }
        if($minPrice)
            $price = $minPrice .__('home.currency').$minUnit;

        return [
            'id'                => intval($this->id),
            'name'              => $this->name,
            'image'             => $this->image ? asset('storage/' . $this->image) : null,
            'pdf'               => $this->pdf ? asset('storage/' . $this->pdf) : null,
            'sku_code'          =>$this->sku_code,
            'alt'               => $this->alt,
            'phoneNumber'       =>$this->getBestRankCompany(),
            'price'             => $price,
            'brand'             =>$this->brand?$this->brand->name:'',
            'description'       => $this->description,
            'availableCompanies'=>new CompaniesCollection($companies),
            'specifications'    => new ProductSpecificationsCollection($this->specifications),
        ];
    }
}
