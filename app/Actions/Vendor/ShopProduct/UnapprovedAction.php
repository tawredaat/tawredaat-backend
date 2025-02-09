<?php

namespace App\Actions\Vendor\ShopProduct;

use App\Models\VendorShopProduct;

class UnapprovedAction
{
    public function execute($id)
    {
        $product = VendorShopProduct::findOrFail($id);

        $product->is_approved = 0;

        $product->save();
    }
}
