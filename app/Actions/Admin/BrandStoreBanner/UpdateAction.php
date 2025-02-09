<?php

namespace App\Actions\Admin\BrandStoreBanner;

use App\Helpers\UploadFile;
use App\Models\BrandStoreBanner;
use Illuminate\Http\Request;

class UpdateAction
{
    public function execute(Request $request, $id)
    {
        $brand_store_banner = BrandStoreBanner::findOrFail($id);

        if ($request->file('image_ar')) {
            //Remove old file
            UploadFile::RemoveFile($brand_store_banner->image_ar);
            $image_ar = UploadFile::UploadSinglelFile(
                $request->file('image_ar'),
                'brand_store_banners'
            );
        } else {
            $image_ar = $brand_store_banner->translate('ar')->image;
        }

        if ($request->file('image_en')) {
            //Remove old file
            UploadFile::RemoveFile($brand_store_banner->image_en);
            $image_en = UploadFile::UploadSinglelFile(
                $request->file('image_en'),
                'brand_store_banners'
            );
        } else {
            $image_en = $brand_store_banner->translate('en')->image;
        }

        if ($request->file('mobile_image')) {
            //Remove old file
            UploadFile::RemoveFile($brand_store_banner->mobile_image);
            $mobile_image = UploadFile::UploadSinglelFile(
                $request->file('mobile_image'),
                'brand_store_banners'
            );
        } else {
            $mobile_image = $brand_store_banner->mobile_image;
        }

        $brand_store_banner->mobile_image = $mobile_image;
        $brand_store_banner->url = $request->url;
        $brand_store_banner->translate('en')->alt = $request->alt_en;
        $brand_store_banner->translate('ar')->alt = $request->alt_ar;
        $brand_store_banner->translate('en')->image = $image_en;
        $brand_store_banner->translate('ar')->image = $image_ar;

        $brand_store_banner->save();
    }
}
