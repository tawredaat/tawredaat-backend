<?php

namespace App\Http\Controllers\Vendor;

use App\Actions\Vendor\ShopProductMassImage\DeleteAction;
use App\Actions\Vendor\ShopProductMassImage\UploadAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UploadImagesProductsRequest;
use App\Models\File;
use App\Models\VendorShopProductImage;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ShopProductMassUploadImageController extends Controller
{
    //upload Multiple PDF to mas upload products file
    public function upload()
    {
        $title = 'Select multiple images|max count must be <= 50 image';

        return view('Vendor.shop_product_mass_images.images', compact('title'));
    }

    public function data()
    {
        $records = VendorShopProductImage::all();

        return DataTables::of($records)->make(true);
    }

    public function store(UploadImagesProductsRequest $request, UploadAction $upload_action)
    {
        DB::beginTransaction();

        try {

            for ($i = 0; $i < count($request->file('images')); $i++) {
                $upload_action->execute($request->file('images')[$i]);
            }

            DB::commit();

            return response()->json(['success' => 'Uploaded']);
        } catch (\Exception $exception) {
            DB::rollback();

            return response()->json(['error' => 'Cannot upload'], 101);
        }
    }

    public function delete($id, DeleteAction $delete_action)
    {
        try {
            VendorShopProductImage::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Image not found'], 101);
        }

        DB::beginTransaction();

        try {
            $delete_action->execute($id);

            DB::commit();

            return response()->json([], 200);

        } catch (\Exception $exception) {
            DB::rollback();

            return response()->json(['error' => $exception->getMessage()], 101);

        }

    }
}