<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    public $searchSelection;
    /**
     * CompanyResource constructor.
     * @param $resource
     */
    public function __construct($resource,$searchSelection = 0)
    {
        parent::__construct($resource);
        $this->searchSelection = $searchSelection;

    }

    public function hasProducts(){
        $countProducts =   \App\Models\CompanyProduct::where('company_id',$this->id)->first();
        if($countProducts)
            return 1;
       return 0;
    }

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $moreInfo = [
            'companyPhone'=>$this->company_phone,
            'companyEmail'=>$this->company_email,
            'address'=>$this->address,
            'primaryName'=>$this->pri_contact_name,
            'primaryPhone'=>$this->pri_contact_phone,
            'primaryEmail'=>$this->pri_contact_email,
            'salesMobile'=>$this->sales_mobile,
            'map'=>$this->map,
            'facebook'=>$this->facebook,
            'insta'=>$this->insta,
            'linkedin'=>$this->linkedin,
            'youtube'=>$this->youtube,
        ];
        $areas = '';
        foreach($this->areas as $area)
             $areas.=$area->name.', ';
        $types = '';
        foreach($this->company_types as $type)
            $types.=$type->name.', ';
        return [
            'id' => intval($this->id),
            'selected'=>intval($this->searchSelection),
            'name' => $this->name,
            'description'=>$this->description,
            'company_areas'=>$areas,
            'types'=>$types,
            'logo' => $this->logo ? asset('storage/' . $this->logo) : null,
            'alt'=>$this->alt,
            'date'=>date('Y', strtotime($this->date)),
            'subscriptions'=>$this->subscriptions,
            'hasProducts'=>$this->hasProducts(),
            'pri_contact_phone'=>$this->pri_contact_phone,
            'whatsup_number'=>$this->whatsup_number,
            'moreInfo'=>$moreInfo,
            // 'areas'=>$this->areas,
            // 'company_types'=>$this->company_types,
        ];
    }
}
