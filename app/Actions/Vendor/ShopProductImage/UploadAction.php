<?php

namespace App\Actions\Vendor\ShopProductImage;

use App\Helpers\UploadFile;
use App\Models\VendorShopProduct;
use Illuminate\Http\Request;

class UploadAction
{
    public function execute(Request $request, $id)
    {
        $product = VendorShopProduct::findOrFail($id);

        //upload multiple files
        UploadFile::UploadMultiFiles(
            $request->file('images'),
            'VendorShopProductImages',
            'App\Models\VendorShopProduct',
            $product->id
        );
    }
}
