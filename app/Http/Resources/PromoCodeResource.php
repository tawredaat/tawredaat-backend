<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PromoCodeResource extends JsonResource
{
    public $searchSelection;
    /**
     * AreaResource constructor.
     * @param $resource
     */
    public function __construct($resource,$searchSelection = 0)
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
            'code'=>$this->code,
            'discount' => $this->discount,
			'discount_type' => $this->discount_type,
          	'max_discount' => $this->max_amount,
          	'min_amount' => $this->min_amount, //the fewest value the user can apply the promocode
          	'is_valid' => $this->is_valid(),
          	'brands' => json_decode($this->brands),
        ];
    }
}
