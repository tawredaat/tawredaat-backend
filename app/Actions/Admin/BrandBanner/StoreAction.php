<?php

namespace App\Actions\Admin\BrandBanner;

use App\Helpers\UploadFile;
use App\Models\BrandBanner;
use Illuminate\Http\Request;

class StoreAction
{
    public function execute(Request $request)
    {
        //upload new file
        if ($request->file('image')) {
            $image = UploadFile::UploadSinglelFile($request->file('image'), 'brand_banners');
        } else {
            $image = null;
        }

        //upload new file
        if ($request->file('mobile_image')) {
            $mobile_image = UploadFile::UploadSinglelFile(
                $request->file('mobile_image'),
                'brand_banners'
            );
        } else {
            $mobile_image = null;
        }

        $brand_banner = BrandBanner::create([
            'brand_id' => $request->brand_id,
            'image' => $image,
            'mobile_image' => $mobile_image,
            'url' => $request->url,
            'en' => [
                'alt' => $request->alt_en,
            ],
            'ar' => [
                'alt' => $request->alt_ar,
            ],
        ]);
    }
}
