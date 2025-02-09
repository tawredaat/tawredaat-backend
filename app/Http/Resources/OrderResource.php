<?php

namespace App\Http\Resources;

use App\Http\Resources\Collections\OrderItemsCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * OrderResource constructor.
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
        $status_name = $this->cancelled ? __('home.cancelled') : ($this->status ? $this->status->name : '');
        $status_color = $this->cancelled ? '#ff0000' : ($this->status ? $this->status->color : '');

        $additional_total = ($this->total) * ($this->payment->additional_percentage / 100);

        $longitude = $this->userAddress ? $this->userAddress->longitude : null;
        $latitude = $this->userAddress ? $this->userAddress->latitude : null;

        return [
            'id' => intval($this->id),
            'orderNum' => "#$this->id",
            'status' => $status_name,
            'status_id' => $this->order_status_id,
            'statusColor' => $status_color,
            'subtotal' => round("$this->subtotal", 2),
            'total' => round($this->total + $additional_total, 2),
            'discount' => round($this->discount, 2),
            'delivery_charge' => round($this->delivery_charge, 2),
            'address' => $this->address,
            'comment' => $this->comment,
            'date' => date('M d, Y', strtotime($this->created_at)),
            'time' => date('h:i a', strtotime($this->created_at)),
            'isCancelled' => intval($this->cancelled),
            'payment_id' => $this->payment_id,
            'payment' => new PaymentResource($this->payment),
            'longitude' => $longitude,
            'latitude' => $latitude,
            'location' => $longitude && $latitude ? "https://www.google.com/maps/search/?api=1&query={$longitude},{$latitude}" : null,
            'items' => new OrderItemsCollection($this->items),
            'bundel_count' => count($this->bundelItems()),
            'bundels' => $this->bundelItems()->map(function ($bundel) {
                return new OrderBundelsResource($bundel, $this->id); // Pass the order ID
            }),
            'bundels_total' => round($this->bundelsTotal(), 2),
            'additional_percentage' => $this->payment->additional_percentage,
            'additional_total' => round($additional_total, 2),
            'total_without_addition' => round($this->total, 2),
            'total_with_addition' => round($this->total + $additional_total, 2),
        ];
    }
}
