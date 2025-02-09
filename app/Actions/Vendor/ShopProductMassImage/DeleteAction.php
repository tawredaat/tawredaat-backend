<?php

namespace App\Actions\Vendor\ShopProductMassImage;

use App\Helpers\UploadFile;
use App\Models\VendorShopProductImage;

class DeleteAction
{
    public function execute($id)
    {
        $image = VendorShopProductImage::findOrFail($id);

        UploadFile::RemoveFile($image->image);

        $image->delete();
    }
}
