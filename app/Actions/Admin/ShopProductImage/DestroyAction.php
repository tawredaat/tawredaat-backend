<?php

namespace App\Actions\Admin\ShopProductImage;

use App\Helpers\UploadFile;
use App\Models\ShopProductImage;

class DestroyAction
{
    public function execute($image)
    {
        if ($image->image) {
            UploadFile::RemoveFile($image->image);
        }
        $image->delete();
    }
}
