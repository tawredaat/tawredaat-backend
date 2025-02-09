<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Collections\CompaniesCollection;

class BrandDistributorResource extends JsonResource
{
    private $brand_companies;
    /**
     * BrandResource constructor.
     * @param $resource
     */
    public function __construct($resource,$brand_companies)
    {
        parent::__construct($resource);
        $this->brand_companies = $brand_companies;
    }


    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $distributers = [];
        if(count($this->types)){
            foreach($this->brand_companies as $c){
                if($c->company and  $c->company_type_id==$this->id)
                    array_push($distributers,$c->company);
            }
        }
        return [
            'id' => intval($this->id),
            'type' => $this->name,
            'distributers'=>new CompaniesCollection($distributers),
        ];
    }
}
