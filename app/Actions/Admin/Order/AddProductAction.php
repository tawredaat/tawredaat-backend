<?php

namespace App\Actions\Admin\Order;

use App\Models\OrderItem;
use App\Models\ShopProduct;
use Illuminate\Http\Request;

class AddProductAction
{
    public function execute(Request $request, $id)
    {
        if (!is_null($request->product_id)) {
            $product = ShopProduct::findOrFail($request->product_id);
            $price = $product->new_price;
        } else {
            $price = $request->price;
        }

        $order_item = OrderItem::create([
            'order_id' => $id,
            'shop_product_id' => $request->product_id,
            'manual_product_name' => $request->manual_product_name,
            'quantity' => $request->quantity,
            'price' => $price,
            'amount' => round($request->quantity * $price, 2),
            'purchaseQuantity' => $request->quantity,
        ]);

        return $order_item;
    }
}
