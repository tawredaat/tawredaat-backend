<?php

namespace App\Actions\Admin\Order;

use App\Models\Order;
use App\Models\ShopProduct;

class DecreaseShopProductQuantityAction
{
    public function execute($order_id)
    {
        $order = Order::findOrFail($order_id);
        $order_items = $order->items;

        foreach ($order_items as $order_item) {
            $shop_product_id = $order_item->shop_product_id;
            if (is_null($shop_product_id)) {
                continue;
            }
            $product = ShopProduct::findOrFail($shop_product_id);
            $product->update(['qty' => ($product->qty - $order_item->quantity)]);
        }
    }
}
