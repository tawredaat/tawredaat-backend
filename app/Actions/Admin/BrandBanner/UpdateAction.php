<?php

namespace App\Actions\Admin\BrandBanner;

use App\Helpers\UploadFile;
use App\Models\BrandBanner;
use Illuminate\Http\Request;

class UpdateAction
{
    public function execute(Request $request, $id)
    {
        $brand_banner = BrandBanner::findOrFail($id);

        //upload new file
        if ($request->file('image')) {
            //Remove old file
            UploadFile::RemoveFile($brand_banner->image);
            $image = UploadFile::UploadSinglelFile(
                $request->file('image'),
                'brand_banners'
            );
        } else {
            $image = $brand_banner->image;
        }

        //upload new file
        if ($request->file('mobile_image')) {
            //Remove old file
            UploadFile::RemoveFile($brand_banner->mobile_image);
            $mobile_image = UploadFile::UploadSinglelFile(
                $request->file('mobile_image'),
                'brand_banners'
            );
        } else {
            $mobile_image = $brand_banner->mobile_image;
        }

        $brand_banner->image = $image;
        $brand_banner->mobile_image = $mobile_image;
        $brand_banner->url = $request->url;
        $brand_banner->translate('en')->alt = $request->altEN;
        $brand_banner->translate('ar')->alt = $request->altAR;
        $brand_banner->save();
    }
}
