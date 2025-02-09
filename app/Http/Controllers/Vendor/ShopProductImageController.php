<?php

namespace App\Http\Controllers\Vendor;

use App\Actions\Vendor\ShopProductImage\DeleteAction;
use App\Actions\Vendor\ShopProductImage\UploadAction;
use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\VendorShopProduct;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ShopProductImageController extends Controller
{
    public function images($id)
    {
        try {
            $product = VendorShopProduct::vendorShopProducts()->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'Product does not exist');

            return redirect()->route('vendor.shop-products.index');
        }

        $main_title = 'Products';

        $sub_title = "Upload images of ";

        return view('Vendor.shop_product_images.images',
            compact('product', 'main_title', 'sub_title'));
    }

    /**
     * return product images to be displayed in DT.
     */
    public function getProductImages($id)
    {
        $records = File::where('model_id', $id)
            ->where('model_type', 'App\Models\VendorShopProduct')->get();

        return DataTables::of($records)->make(true);
    }

    /**
     * store product images in File Table.
     */
    public function upload(Request $request, UploadAction $upload_action, $id)
    {
        try {
            $product = VendorShopProduct::vendorShopProducts()->findOrFail($id);
        } catch (ModelNotFoundException $e) {

            return response()->json(['error' => 'Product not found!'], 200);
        }

        DB::beginTransaction();

        try {

            $upload_action->execute($request, $id);

            DB::commit();

            return response()->json(['success' => 'done']);

        } catch (\Exception $exception) {
            DB::rollback();

            return response()->json([]);
        }
    }

    /**
     * delete a single image from product images .
     */
    public function delete($id, DeleteAction $delete_action)
    {

        DB::beginTransaction();

        try {
            $image = File::findOrFail($id);

        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'Image does not exist');

            return redirect()->route('vendor.shop-products.index');
        }

        try {
            $delete_action->execute($id);

            DB::commit();

            return response()->json([], 200);

        } catch (\Exception $exception) {
            DB::rollback();

            return response()->json([]);
        }
    }

    public function deleteSelected(Request $request, DeleteAction $delete_action)
    {

        if ($request->has('images')) {

            DB::beginTransaction();

            foreach ($request->images as $image_id) {

                try {
                    $image = File::findOrFail($image_id);

                } catch (ModelNotFoundException $e) {
                    session()->flash('error', 'Image does not exist');

                    return redirect()->route('vendor.shop-products.index');
                }

                try {
                    $delete_action->execute($image_id);

                    DB::commit();
                } catch (\Exception $exception) {
                    DB::rollback();

                    session()->flash('error', 'Error');

                    return back();
                }
            }

            session()->flash('_added', 'Images  has been deleted successfully');

            return back();

        } else {

            session()->flash('error', 'Please Select an image');

            return back();
        }
    }
}