<?php

namespace App\Actions\Admin\Order;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ShopProduct;
use Exception;
use Illuminate\Http\Request;

class StoreOrderItemsAction
{
    public function execute(Request $request, $order_id)
    {
        Order::findOrFail($order_id);

        if (is_null($request->product_id) && is_null($request->manual_product_name)) {
            return;
        }

        $products = $request->product_id;
        $manual_products = $request->manual_product_name;
        $prices = $request->price;
        $products_count = count($request->product_id);
        $quantities = $request->quantity;

        for ($i = 0; $i < $products_count; $i++) {
            if (is_null($products[$i]) || count($products) == 0) {
                if (is_null($manual_products[$i])) {
                    throw new Exception('No product chosen or entered manually');
                }

                if (is_null($prices[$i])) {
                    throw new Exception('Price must be added with manually added products');
                }

                OrderItem::create([
                    'order_id' => $order_id,
                    'shop_product_id' => null,
                    'manual_product_name' => $manual_products[$i],
                    'quantity' => $quantities[$i],
                    'price' => $prices[$i],
                    'amount' => round($quantities[$i] * $prices[$i], 2),
                    'purchaseQuantity' => $quantities[$i],
                ]);
            } else {
                $product = ShopProduct::findOrFail($products[$i]);
                $price = $product->new_price;

                OrderItem::create([
                    'order_id' => $order_id,
                    'shop_product_id' => $products[$i],
                    'manual_product_name' => null,
                    'quantity' => $quantities[$i],
                    'price' => $price,
                    'amount' => round($quantities[$i] * $price, 2),
                    'purchaseQuantity' => $quantities[$i],
                ]);
            }
        }
    }
}
