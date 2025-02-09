<?php

namespace App\Actions\Vendor\ShopProductImage;

use App\Helpers\UploadFile;
use App\Models\File;

class DeleteAction
{
    public function execute($id)
    {
        $image = File::findOrFail($id);

        //Remove old file
        if ($image->path) {
            UploadFile::RemoveFile($image->path);
        }

        $image->delete();
    }
}
