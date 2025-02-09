<?php

namespace App\Actions\Admin\Vendor;

use App\Helpers\UploadFile;
use App\Models\Vendor;
use Illuminate\Http\Request;

class StoreAction
{
    public function execute(Request $request)
    {
        // upload documents
        $commercial_license = UploadFile::UploadSinglelFile(
            $request->file('commercial_license'),
            'vendors'
        );

        $tax_number_certificate = UploadFile::UploadSinglelFile(
            $request->file('tax_number_certificate'),
            'vendors'
        );

        $logo = UploadFile::UploadSinglelFile(
            $request->file('logo'),
            'vendors'
        );

        $added_value_certificate = null;

        $contractors_association_certificate = null;

        if ($request->file('added_value_certificate')) {
            $added_value_certificate = UploadFile::UploadSinglelFile(
                $request->file('added_value_certificate'),
                'vendors'
            );
        }

        if ($request->file('contractors_association_certificate')) {
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
        $vendor = Vendor::create([
            'company_name' => $request->company_name,
            'responsible_person_name' => $request->responsible_person_name,
            'responsible_person_mobile_number' => $request->responsible_person_mobile_number,
            'responsible_person_email' => $request->responsible_person_email,
            'password' => bcrypt($request->password),
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
