<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\PaymentNote;

class PaymentResource extends JsonResource
{
    /**
     * PaymentResource constructor.
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
            'note' => $this->note,
            'additional_percentage' => $this->additional_percentage,
            'payment_type' =>  $this->payment_type ==0 ? 'full_payment' : 'partial_payment',
            'image' => $this->image !== null ? asset('storage/' . $this->image) : null,
        ];
    }
}
