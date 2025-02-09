<?php

namespace App\Actions\Vendor\ShopProductPDF;

use App\Helpers\UploadFile;
use App\Models\VendorShopProductPdf;

class UploadAction
{
    public function execute($file)
    {
        $pdf = UploadFile::UploadProductFile(
            $file,
            'vendor_shop_products'
        );

        VendorShopProductPdf::create(['pdf' => $pdf]);
    }
}
