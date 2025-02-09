<?php

namespace App\Actions\Admin\Vendor;

use App\Models\VendorShopProduct;

class ToggleFeaturedAction
{
    public function execute($id)
    {
        $product = VendorShopProduct::findOrFail($id);

        if ($product->featured) {
            $product->featured = 0;

            $product->save();

            return ([
                'featured' => $product->featured,
                'success' => 'Shop product has been removed from featured.']
            );
        } else {
            $product->featured = 1;

            $product->save();

            return ([
                'featured' => $product->featured,
                'success' => 'Shop product has been added as featured']);
        }
    }
}
