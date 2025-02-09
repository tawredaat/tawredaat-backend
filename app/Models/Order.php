<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    // public function items()
    // {
    //     return $this->hasMany('App\Models\OrderItem', 'order_id');
    // }

    public function payment()
    {
        return $this->belongsTo('App\Models\Payment', 'payment_id');
    }

    public function canceledBy()
    {
        return $this->belongsTo('App\Admin', 'cancelled_by');
    }

    public function status()
    {
        return $this->belongsTo('App\Models\OrderStatus', 'order_status_id');
    }

    public function userAddress()
    {
        return $this->belongsTo('App\Models\UserAddress', 'user_address_id');
    }

    public function scopeToSendEmail($query)
    {
        return $query->where('cancelled', 0)
            ->select('id', 'user_id', 'subtotal', 'total', 'discount',
                'payment_id', 'order_status_id', 'address',
                'user_address_id', 'promocode',
                'delivery_charge', 'created_at')
        // user
            ->with(['user' => function ($query) {
                $query->select('id', 'name', 'last_name', 'email', 'phone', 'full_name');
            }])
        // payment
            ->with(['payment' => function ($query) {
                $query->select('id')
                    ->with(['translations' => function ($query) {
                        $query->select('id', 'payment_id', 'name', 'locale');
                    }]);
            }])
        // items
            ->with(['allItems' => function ($query) {
                $query->select('id', 'order_id', 'shop_product_id', 'manual_product_name',
                    'quantity', 'price', 'amount', 'bundel_id')
                    ->with(['shopProduct' => function ($query) {
                        $query->select('id', 'image', 'new_price', 'old_price', 'sku_code',
                            'brand_id')
                            ->with(['translations' => function ($query) {
                                $query->select('id', 'shop_product_id', 'name', 'locale');
                            }])
                            ->with(['brand' => function ($query) {
                                $query->select('id')
                                    ->with(['translations' => function ($query) {
                                        $query->select('id', 'brand_id', 'name', 'locale');
                                    }]);
                            }]);
                    }]);
            }]);
    }
    
    public function items()
    {
        return $this->hasMany('App\Models\OrderItem', 'order_id')
                    ->whereNull('bundel_id');
    }
    
    public function allItems()
    {
        return $this->hasMany('App\Models\OrderItem', 'order_id');
    }
    
    public function bundelItem()
    {
    return $bundelItems = OrderItem::where('order_id', $this->id)
        ->whereNotNull('bundel_id')
        ->groupBy('bundel_id')
        ->get();   
    }
        
    public function bundelItems()
    {
        $bundelIds =  OrderItem::where('order_id', $this->id)
            ->whereNotNull('bundel_id')->distinct()
            ->pluck('bundel_id');
        return Bundel::whereIn('id' , $bundelIds)->with('items')->get();
    }
    
    public function bundelsTotal()
    {
        $total = 0;
        foreach($this->bundelItem() as $item)
        {
            // Retrieve the shop product price from the database
            $product = ShopProduct::find($item->shop_product_id);
            $price = $product->new_price; // Assuming each product has a price field

            // Check if the item has a bundelId and apply discount if necessary
            if (!is_null($item->bundel_id)) {
                // Get the bundle details, for example discount percentage
                $bundle = Bundel::find($item->bundel_id);
                $discount = $bundle->discount_percentage; // Assuming you have this field in the bundle table
    
                // Apply the discount
                $discountedPrice = $price - ($price * ($discount / 100));
    
                // Add the discounted price to the total
                $total += $discountedPrice * $item->qty;
            } else {
                // Add the normal price to the total
                $total += $price * $item->qty;
            }
        }
            return $total;
    }
    
    public function bundels()
    {
        return $this->hasMany('App\Models\OrderItem', 'order_id');
    }

    public function total()
    {
        $subtotal = 0;
        $promocode = null;

        foreach ($this->items as $item) {
            $item_price = $item->shopProduct->new_price ?? 0;
            $subtotal += $item_price * $item->qty;
        }
        $total = round($subtotal, 2);

        $deliveryCharge = 0;

        if ($this->promocode_id) {
            $promocode = Promocode::findOrFail($this->promocode_id);
            $discount_data = $promocode->getDiscountValue($subtotal, $deliveryCharge);
            $deliveryCharge = $discount_data['delivery_charge'];
            $total = $discount_data['total'];
        } else {
            $total + $deliveryCharge;
        }

        return $total;
    }
    
    public function totalItemsAndBundels()
    {
     $totalCart = $this->total() + $this->bundelsTotal();
     $free_shipping_amount = Setting::first()->free_shipping_amount;
     $additiona_percentage = $this->payment->additional_percentage;
     $deliveryCharge = $this->userAddress->city->shipping_fees;
        
         if($totalCart < $free_shipping_amount)
         {
            $total = $totalCart + $deliveryCharge +(( $deliveryCharge + $totalCart) * ($additiona_percentage/100));
         }else{
            $total = $totalCart + ($totalCart * ($additiona_percentage/100));
         }
         return $total;
    }
}
