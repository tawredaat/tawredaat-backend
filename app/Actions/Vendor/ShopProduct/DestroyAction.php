<?php

namespace App\Actions\Vendor\ShopProduct;

use App\Helpers\UploadFile;
use App\Models\VendorShopProduct;

class DestroyAction
{
    public function execute($id)
    {
        $product = VendorShopProduct::findOrFail($id);

        // Remove old multiple file
        if (count($product->images)) {
            UploadFile::RemoveMultiFiles('App\Models\VendorShopProduct', $id);
        }

        // Remove old single file
        if ($product->image) {
            UploadFile::RemoveFile($product->image);
        }

        // Remove old file
        if (isset($product->pdf)) {
            UploadFile::RemoveFile($product->pdf);
        }

        $product->delete();
    }
}
