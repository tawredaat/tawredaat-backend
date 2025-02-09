<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Setting;
use App\Models\CartItem;
use App\Models\Bundel;
use App\Models\Promocode;
// use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use SoftDeletes;

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function userAddress()
    {
        return $this->belongsTo('App\Models\UserAddress', 'user_address_id');
    }

    public function payment()
    {
        return $this->belongsTo('App\Models\Payment', 'payment_id');
    }

    public function scopePaymentOnline($query)
    {
        return $query->where('payment_id', config('payment_paymob.online_card.payment_id', 3))
            ->orWhere('payment_id', config('payment_paymob.valu.payment_id', 2));
    }

    public function promocode()
    {
        return $this->belongsTo('App\Models\Promocode', 'promocode_id');
    }

    public function items()
    {
        return $this->hasMany('App\Models\CartItem', 'cart_id')
                    ->whereNull('bundel_id');
    }
    
    public function allItems()
    {
        return $this->hasMany('App\Models\CartItem', 'cart_id');
    }
    
    public function bundelItem()
    {
        return $bundelItems = CartItem::where('cart_id' , $this->id)->where('bundel_id' , '<>' , null)->get();
    }
    
    public function bundelItems()
    {
        $bundelIds =  CartItem::where('cart_id', $this->id)
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
        return $this->hasMany('App\Models\CartItem', 'cart_id');
    }

    public function cartCalculation()
    {
        $subtotal = 0;
        $discount = 0;
        $promocode = null;
        $address = null;

        foreach ($this->items as $item) {
            $product = $item->shopProduct->first();
            $item_price = $item->shopProduct->new_price;
            $subtotal += $item_price * $item->qty;
        }
        $total = round($subtotal, 2);

        $deliveryCharge = 0;
        $address_country = $this->userAddress ? ($this->userAddress->country ? $this->userAddress->country->name : '') : '';
        $address_area = $this->userAddress ? $this->userAddress->area : '';
        $address_street = $this->userAddress ? $this->userAddress->street : '';
        $address_building = $this->userAddress ? $this->userAddress->building : '';
        $address_landmark = $this->userAddress ? $this->userAddress->landmark : '';

        $address = $address_country . ', ' . $address_area . ', ' . $address_street . ', ' . $address_building . ', ' . $address_landmark;

        if ($this->userAddress) {
            $deliveryCharge = $this->userAddress->city->shipping_fees;
        }

        if ($this->promocode_id) {
            $promocode = Promocode::findOrFail($this->promocode_id);
            $discount_data = $promocode->getDiscountValue($subtotal, $deliveryCharge);
            $deliveryCharge = $discount_data['delivery_charge'];
            $discount = $discount_data['discount'];
        }

        // get free shipping amount
        $free_shipping_amount = Setting::first()->free_shipping_amount;
        if (!is_null($free_shipping_amount)) {
            if ($subtotal >= $free_shipping_amount) {
                $deliveryCharge = 0;
            }
        }
        return [
            'deliveryCharge' => $deliveryCharge,
            'total' => $subtotal + $deliveryCharge - $discount,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'promocode' => $promocode,
            'address' => $address,
        ];
    }

    public function total()
    {
        $subtotal = 0;
        $promocode = null;

        foreach ($this->items as $item) {
            $item_price = $item->shopProduct->new_price;
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
     $additional_percentage = $this->payment->additional_percentage;
     $deliveryCharge = $this->userAddress->city->shipping_fees;
     $promocode = Promocode::find($this->promocode_id);
      
          if($promocode && ($promocode->min_amount >= $totalCart) && $promocode->uses >= 1)
          {
            switch($promocode->discount_type)
            {
              case 'value':
                $totalCart -= $promocode->discount;
                break;
              case 'percentage':
                $promoCodeValue = $totalCart * ($promocode->discount / 100);
                if($promoCodeValue > $promocode->max_amount)
                {
                  $totalCart -= $promocode->max_amount;
                }else{
                  $totalCart -= $promoCodeValue;
                }
                break;
              case 'remove shipping fees':
                if($totalCart < $free_shipping_amount)
                 {
                    $totalCart -= $deliveryCharge;
                 }
                break;        
            }
            $promocode->uses -=1;
          }
         if($totalCart < $free_shipping_amount)
         {
            $total = $totalCart + $deliveryCharge +(( $deliveryCharge + $totalCart) * ($additional_percentage/100));
         }else{
            $total = $totalCart + ($totalCart * ($additional_percentage/100));
         }
         return $total;
    }
}
