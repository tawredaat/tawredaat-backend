<?php

namespace App\Actions\Admin\Vendor;

use App\Helpers\UploadFile;
use App\Models\Vendor;
use Illuminate\Http\Request;

class UpdateAction
{
    public function execute(Request $request, $id)
    {
        $vendor = Vendor::findOrFail($id);

        // upload documents
        $commercial_license = $vendor->commercial_license;

        if ($request->file('commercial_license')) {
            // remove old file
            UploadFile::RemoveFile($vendor->commercial_license);

            $commercial_license =
            UploadFile::UploadSinglelFile(
                $request->file('commercial_license'),
                'vendors'
            );
        }

        $tax_number_certificate = $vendor->tax_number_certificate;

        if ($request->file('tax_number_certificate')) {
            // remove old file
            UploadFile::RemoveFile($vendor->tax_number_certificate);

            $tax_number_certificate =
            UploadFile::UploadSinglelFile(
                $request->file('tax_number_certificate'),
                'vendors'
            );
        }

        $logo = $vendor->logo;

        if ($request->file('logo')) {
            UploadFile::RemoveFile($vendor->logo);

            $logo = UploadFile::UploadSinglelFile(
                $request->file('logo'),
                'vendors'
            );
        }

        $added_value_certificate = $vendor->added_value_certificate;

        if ($request->file('added_value_certificate')) {
            if (!is_null($vendor->added_value_certificate)) {
                UploadFile::RemoveFile($vendor->added_value_certificate);
            }

            $added_value_certificate = UploadFile::UploadSinglelFile(
                $request->file('added_value_certificate'),
                'vendors'
            );
        }

        $contractors_association_certificate =
        $vendor->contractors_association_certificate;

        if ($request->file('contractors_association_certificate')) {
            if (!is_null($vendor->contractors_association_certificate)) {
                UploadFile::RemoveFile($vendor->contractors_association_certificate);
            }

            $contractors_association_certificate = UploadFile::UploadSinglelFile(
                $request->file('contractors_association_certificate'),
                'vendors'
            );
        }

        if ($request->has('is_approved')) {
            $is_approved = 1;
        } else {
            $is_approved = 0;
        }

        // store fields
        $vendor->update([
            'company_name' => $request->company_name,
            'responsible_person_name' => $request->responsible_person_name,
            'responsible_person_mobile_number' => $request->responsible_person_mobile_number,
            'responsible_person_email' => $request->responsible_person_email,
            'company_type' => $request->company_type,
            'commercial_license' => $commercial_license,
            'tax_number_certificate' => $tax_number_certificate,
            'added_value_certificate' => $added_value_certificate,
            'contractors_association_certificate' => $contractors_association_certificate,
            'logo' => $logo,
            'is_approved' => $is_approved,
        ]);

        return $vendor;
    }
}
