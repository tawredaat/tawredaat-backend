<?php

namespace App\Actions\Vendor\ShopProduct;

use App\Helpers\UploadFile;
use App\Models\VendorShopProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UpdateAction
{
    public function execute(Request $request, $id)
    {
        $product = VendorShopProduct::findOrFail($id);

        //upload  new image file
        if ($request->file('image')) {
            //Remove old file
            UploadFile::RemoveFile($product->image);
            $product->image = UploadFile::UploadSinglelFile($request->file('image'), 'shop_products');
        }
        //upload  new image file
        if ($request->file('mobile_img')) {
            //Remove old file
            UploadFile::RemoveFile($product->mobile_img);
            $product->mobile_img = UploadFile::UploadSinglelFile($request->file('mobile_img'), 'shop_products');
        }
        //upload  new PDF file
        if ($request->file('pdf')) {
            if ($product->pdf) {
                //Remove old file
                UploadFile::RemoveFile($product->pdf);
            }
            $product->pdf = UploadFile::UploadSinglelFile($request->file('pdf'), 'shop_products');
        }
        $product->category_id = $request->input('category_id');
        $product->brand_id = $request->input('brand_id');
        $product->sku_code = $request->input('sku_code');
        $product->video = $request->input('video');
        $product->old_price = $request->input('old_price') ? $request->input('old_price') : 0;
        $product->new_price = $request->input('new_price');
        $product->sold_by_souqkahrba = $request->input('sold_by_souq') ? $request->input('sold_by_souq') : 0;
        $product->qty = $request->input('qty');
        $product->quantity_type_id = $request->input('qty_type');
        $product->translate('en')->name = $request->input('name_en');
        $product->translate('ar')->name = $request->input('name_ar');
        $product->translate('en')->slug = Str::slug($request->input('name_en'));
        $product->translate('ar')->slug = slugInArabic($request->input('name_ar'));
        $product->translate('en')->title = $request->input('title_en');
        $product->translate('ar')->title = $request->input('title_ar');
        $product->translate('en')->alt = $request->input('alt_en');
        $product->translate('ar')->alt = $request->input('alt_ar');
        $product->translate('en')->description = $request->input('description_en');
        $product->translate('ar')->description = $request->input('description_ar');
        $product->translate('en')->description_meta = $request->input('description_meta_en');
        $product->translate('ar')->description_meta = $request->input('description_meta_ar');
        $product->translate('en')->keywords_meta = $request->input('keywords_meta_en');
        $product->translate('ar')->keywords_meta = $request->input('keywords_meta_ar');
        $product->translate('en')->keywords = $request->input('keywords_en');
        $product->translate('ar')->keywords = $request->input('keywords_ar');
        $product->save();
    }
}
