<?php

namespace App\Actions\Vendor\ShopProductOffer;

use App\Models\VendorShopProduct;

class RemoveFromOfferAction
{
    public function execute($id)
    {
        $product = VendorShopProduct::findOrFail($id);

        $product->old_price = null;

        $product->save();
    }
}
