<?php

namespace App\Actions\Admin\BrandStoreBanner;

use App\Helpers\UploadFile;
use App\Models\BrandStoreBanner;
use Illuminate\Http\Request;

class StoreAction
{
    public function execute(Request $request)
    {

        if ($request->file('image_ar')) {
            $image_ar = UploadFile::UploadSinglelFile($request->file('image_ar'), 'brand_store_banners');
        } else {
            $image_ar = null;
        }


        if ($request->file('image_en')) {
            $image_en = UploadFile::UploadSinglelFile($request->file('image_en'), 'brand_store_banners');
        } else {
            $image_en = null;
        }


        if ($request->file('mobile_image')) {
            $mobile_image = UploadFile::UploadSinglelFile(
                $request->file('mobile_image'),
                'brand_store_banners'
            );
        } else {
            $mobile_image = null;
        }

        BrandStoreBanner::create([
            'mobile_image' => $mobile_image,
            'url' => $request->url,
            'en' => [
                'alt' => $request->alt_en,
                'image' => $image_en,
            ],
            'ar' => [
                'alt' => $request->alt_ar,
                'image' => $image_ar,
            ],
        ]);
    }
}