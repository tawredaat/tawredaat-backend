<?php

namespace App\Actions\Admin\CategoryBanner;

use App\Helpers\UploadFile;
use App\Models\CategoryBanner;
use Illuminate\Http\Request;

class StoreAction
{
    public function execute(Request $request)
    {
        //upload new file
        if ($request->file('image_ar')) {
            $image_ar = UploadFile::UploadSinglelFile($request->file('image_ar'), 'category_banners');
        } else {
            $image_ar = null;
        }

        if ($request->file('image_en')) {
            $image_en = UploadFile::UploadSinglelFile($request->file('image_en'), 'category_banners');
        } else {
            $image_en = null;
        }

        //upload new file
        if ($request->file('mobile_image_ar')) {
            $mobile_image_ar = UploadFile::UploadSinglelFile(
                $request->file('mobile_image_ar'),
                'category_banners'
            );
        } else {
            $mobile_image_ar = null;
        }
        
        if ($request->file('mobile_image_en')) {
            $mobile_image_en = UploadFile::UploadSinglelFile(
                $request->file('mobile_image_en'),
                'category_banners'
            );
        } else {
            $mobile_image_en = null;
        }
        $category_banner = CategoryBanner::create([
            'category_id' => $request->category_id,
            /* 'image' => $image,
            'mobile_image' => $mobile_image, */
            'url' => $request->url,
            'en' => [
                'alt'           => $request->alt_en,
                'image'         => $image_en,
                'mobile_image'  => $mobile_image_en,
            ],
            'ar' => [
                'alt' => $request->alt_ar,
                'image'         => $image_ar,
                'mobile_image'  => $mobile_image_ar,
            ],
        ]);
    }
}
