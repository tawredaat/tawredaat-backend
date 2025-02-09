<?php

namespace App\Actions\Vendor\ShopProduct;

use App\Helpers\UploadFile;
use App\Models\VendorShopProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StoreAction
{
    public function execute(Request $request)
    {
        VendorShopProduct::create([
            'vendor_id' => Auth('vendor')->user()->id,

            'image' => $request->file('image') ?
            UploadFile::UploadSinglelFile($request->file('image'), 'products') : null,

            'mobile_img' => $request->file('mobile_img') ?
            UploadFile::UploadSinglelFile($request->file('mobile_img'), 'products') : null,

            'pdf' => $request->file('pdf') ?
            UploadFile::UploadSinglelFile($request->file('pdf'), 'products') : null,

            'category_id' => $request->input('category_id'),

            'brand_id' => $request->input('brand_id'),

            'sku_code' => $request->input('sku_code'),

            'video' => $request->input('video'),

            'old_price' => $request->input('old_price') ?
            $request->input('old_price') : 0,

            'new_price' => $request->input('new_price'),

            'sold_by_souqkahrba' => $request->input('sold_by_souq') ?
            $request->input('sold_by_souq') : 0,

            'qty' => $request->input('qty'),

            'quantity_type_id' => $request->input('qty_type'),

            'en' => [
                'name' => $request->input('name_en'),
                'slug' => Str::slug($request->input('name_en')),
                'title' => $request->input('title_en'),
                'alt' => $request->input('alt_en'),
                'description' => $request->input('description_en'),
                'description_meta' => $request->input('description_meta_en'),
                'keywords_meta' => $request->input('keywords_meta_en'),
                'keywords' => $request->input('keywords_en'),
            ],
            'ar' => [
                'name' => $request->input('name_ar'),
                'name' => $request->input('name_ar'),
                'title' => $request->input('title_ar'),
                'alt' => $request->input('alt_ar'),
                'description' => $request->input('description_ar'),
                'description_meta' => $request->input('description_meta_ar'),
                'keywords_meta' => $request->input('keywords_meta_ar'),
                'keywords' => $request->input('keywords_ar'),

            ],
        ]);
    }
}
