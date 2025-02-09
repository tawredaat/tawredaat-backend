<?php

namespace App\Actions\Admin\Vendor;

use App\Helpers\UploadFile;
use App\Models\Vendor;

class DestroyAction
{
    public function execute($id)
    {
        $vendor = Vendor::findOrFail($id);

        // remove vendor's files
        if ($vendor->commercial_license) {
            UploadFile::RemoveFile($vendor->commercial_license);
        }

        if ($vendor->tax_number_certificate) {
            UploadFile::RemoveFile($vendor->tax_number_certificate);
        }

        if ($vendor->added_value_certificate) {
            UploadFile::RemoveFile($vendor->added_value_certificate);
        }

        if ($vendor->contractors_association_certificate) {
            UploadFile::RemoveFile($vendor->contractors_association_certificate);
        }

        $vendor->delete();
    }
}
