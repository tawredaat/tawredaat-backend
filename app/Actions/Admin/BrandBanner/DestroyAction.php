<?php

namespace App\Actions\Admin\BrandBanner;

use App\Helpers\UploadFile;
use App\Models\BrandBanner;

class DestroyAction
{
    public function execute($id)
    {
        $brand_banner = BrandBanner::findOrFail($id);

        // remove old file
        if ($brand_banner->image) {
            UploadFile::RemoveFile($brand_banner->image);
        }

        if ($brand_banner->mobile_image) {
            UploadFile::RemoveFile($brand_banner->mobile_image);
        }

        $brand_banner->delete();
    }
}
