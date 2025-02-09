<?php

namespace App\Actions\Admin\CategoryBanner;

use App\Helpers\UploadFile;
use App\Models\CategoryBanner;

class DestroyAction
{
    public function execute($id)
    {
        $category_banner = CategoryBanner::findOrFail($id);

        // remove old file
        if ($category_banner->translate('ar')->image) {
            UploadFile::RemoveFile($category_banner->translate('ar')->image);
        }

        if ($category_banner->translate('en')->image) {
            UploadFile::RemoveFile($category_banner->translate('en')->image);
        }

        if ($category_banner->translate('ar')->mobile_image) {
            UploadFile::RemoveFile($category_banner->translate('ar')->mobile_image);
        }

        if ($category_banner->translate('en')->mobile_image) {
            UploadFile::RemoveFile($category_banner->translate('en')->mobile_image);
        }

        $category_banner->delete();
    }
}
