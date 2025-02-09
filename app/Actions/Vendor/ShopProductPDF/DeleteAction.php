<?php

namespace App\Actions\Vendor\ShopProductPDF;

use App\Helpers\UploadFile;
use App\Models\VendorShopProductPdf;

class DeleteAction
{
    public function execute($id)
    {
        $pdf = VendorShopProductPdf::findOrFail($id);

        if ($pdf->pdf) {
            UploadFile::RemoveFile($pdf->pdf);
        }

        $pdf->delete();
    }
}
