<?php

namespace App\Actions\Admin\VendorShopProduct;

use App\Models\VendorShopProduct;

class ApproveAction
{
    public function execute($product_id)
    {
        $product = VendorShopProduct::findOrFail($product_id);

        if ($product->is_approved == 1) {
            $product->is_approved = 0;
        } else {
            $product->is_approved = 1;
        }

        $product->save();

        return $product->is_approved;
    }
}
