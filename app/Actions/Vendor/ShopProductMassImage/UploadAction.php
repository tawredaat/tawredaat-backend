<?php

namespace App\Actions\Vendor\ShopProductMassImage;

use App\Helpers\UploadFile;
use App\Models\VendorShopProductImage;

class UploadAction
{
    public function execute($file)
    {
        $image = UploadFile::UploadProductFile(
            $file,
            'vendor_shop_products'
        );

        VendorShopProductImage::create(['image' => $image]);
    }
}
