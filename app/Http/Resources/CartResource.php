<?php

namespace App\Http\Resources;

use App\Http\Resources\Collections\CartItemsCollection;
use App\Http\Resources\PaymentResource;
use App\Models\Setting;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    private $user;
    /**
     * CartResource constructor.
     * @param $resource
     */
    public function __construct($resource, $user = null)
    {
        parent::__construct($resource);
        $this->user = $user;
    }

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $cart_calculation = $this->cartCalculation();
        // get free shipping amount
        $free_shipping_amount = Setting::first()->free_shipping_amount;

        $until_free_shipping = null;

        if (!is_null($free_shipping_amount)) {
            if ($free_shipping_amount - $cart_calculation['subtotal'] >= 0) {
                $until_free_shipping = $free_shipping_amount - $cart_calculation['subtotal'];
            } else {
                $until_free_shipping = 0;
            }
        }

        $additional_total = ($this->bundelsTotal() + round($cart_calculation['total'], 2)) * ($this->payment->additional_percentage / 100);
        return [
            'id' => intval($this->id),
            'user_id' => $this->user_id,
            'guest_user_id' => $this->guest_user_id,
            'user_address_id' => $this->user_address_id,
            'address' => $this->userAddress,
            'comment' => $this->comment,
            'free_shipping_amount' => round($free_shipping_amount, 2),
            'until_free_shipping' => round($until_free_shipping, 2),
            'itemsCount' => count($this->items),
            'subtotal' => round($cart_calculation['subtotal'], 2),
            'delivery_charge' => round($cart_calculation['deliveryCharge'], 2),
            'discount' => round($cart_calculation['discount'], 2),
            'itemsTotal' => round($cart_calculation['total'], 2),
            'items' => new CartItemsCollection($this->items, $this->user),
            'bundel_count' => count($this->bundelItems()),
            'bundels' => CartBundelsResource::collection($this->bundelItems()),
            'bundels_total' => round($this->bundelsTotal(), 2),
            'additional_percentage' => $this->payment->additional_percentage,
            'additional_total' => round($additional_total,2),
            'total_without_addition' => round($this->totalItemsAndBundels(),2),
            'total_with_addition' => round($this->bundelsTotal() + $cart_calculation['total'] + $additional_total,2),
            'payment' => new PaymentResource($this->payment),

        ];
    }
}
