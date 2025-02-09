<?php

namespace App\Actions\Admin\CategoryBanner;

use App\Helpers\UploadFile;
use App\Models\CategoryBanner;
use Illuminate\Http\Request;

class UpdateAction
{
    public function execute(Request $request, $id)
    {
        $category_banner = CategoryBanner::findOrFail($id);

        //upload new file
        if ($request->file('image_ar')) {
            //Remove old file
            UploadFile::RemoveFile($category_banner->translate('ar')->image);
            $image_ar = UploadFile::UploadSinglelFile(
                $request->file('image_ar'),
                'category_banners'
            );
        } else {
            $image_ar = $category_banner->translate('ar')->image;
        }

        //upload new file
        if ($request->file('image_en')) {
            //Remove old file
            UploadFile::RemoveFile($category_banner->translate('en')->image);
            $image_en = UploadFile::UploadSinglelFile(
                $request->file('image_en'),
                'category_banners'
            );
        } else {
            $image_en = $category_banner->translate('en')->image;
        }

        //upload new file
        if ($request->file('mobile_image_ar')) {
            //Remove old file
            UploadFile::RemoveFile($category_banner->translate('ar')->mobile_image);
            $mobile_image_ar = UploadFile::UploadSinglelFile(
                $request->file('mobile_image_ar'),
                'category_banners'
            );
        } else {
            $mobile_image_ar = $category_banner->translate('ar')->mobile_image;
        }

        if ($request->file('mobile_image_en')) {
            //Remove old file
            UploadFile::RemoveFile($category_banner->translate('en')->mobile_image);
            $mobile_image_en = UploadFile::UploadSinglelFile(
                $request->file('mobile_image_en'),
                'category_banners'
            );
        } else {
            $mobile_image_en = $category_banner->translate('en')->mobile_image;
        }

        $category_banner->translate('ar')->image = $image_ar;
        $category_banner->translate('en')->image = $image_en;
        $category_banner->translate('ar')->mobile_image = $mobile_image_ar;
        $category_banner->translate('en')->mobile_image = $mobile_image_en;
        $category_banner->url = $request->url;
        $category_banner->translate('en')->alt = $request->alt_en;
        $category_banner->translate('ar')->alt = $request->alt_ar;
        $category_banner->save();
    }
}