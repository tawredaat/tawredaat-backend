<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\ShopProductImage\DestroyAction;
use App\Helpers\UploadFile;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ShopProductImage\DeleteFilteredRequest;
use App\Http\Requests\Admin\ShopProductImage\DeleteSelectedRequest;
use App\Http\Requests\Admin\UploadImagesProductsRequest;
use App\Models\ShopProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Yajra\Datatables\Datatables;

class ShopProductMassUploadImageController extends Controller
{
    //upload Multiple image to mas upload products file
    public function upload()
    {
        $title = 'Select multiple images|max count must be <= 25 image';
        return view('Admin._shop_products.upload_images', compact('title'));
    }

    public function view()
    {
        $records = ShopProductImage::all();
        return Datatables::of($records)->make(true);
    }

    public function store(UploadImagesProductsRequest $request)
    {
        // set_time_limit(0);

        DB::beginTransaction();
        try {
            for ($i = 0; $i < count($request->file('images')); $i++) {
                $image = UploadFile::UploadProductFile($request->file('images')[$i],
                    'shop_products');
                ShopProductImage::create(['image' => $image]);
            }
            DB::commit();
            return response()->json(['success' => $image]);
        } catch (ValidationException $exception) {
            DB::rollback();
            return response()->json(['message' => $exception->getMessage()]);
        }
    }

    public function delete(Request $request, $id)
    {
        $product = ShopProductImage::findOrFail($id);
        UploadFile::RemoveFile($product->image);
        $product->delete();
        return response()->json([], 200);
    }

    public function deleteSelected(DeleteSelectedRequest $request, DestroyAction $destroy_action)
    {
        DB::beginTransaction();
        try {
            $images = ShopProductImage::whereIn('id', $request->input('images', []))
                ->get();

            foreach ($images as $image) {
                $destroy_action->execute($image);
            }
            DB::commit();
            session()->flash('_added', 'Products images data has been deleted successfully');
            return redirect()->route('shop.products.upload.image');
        } catch (\Exception $exception) {
            DB::rollback();
            session()->flash('error', 'Cannot delete!' . $exception->getMessage());
            return redirect()->route('shop.products.upload.image');
        }
    }

    public function deleteFiltered(DeleteFilteredRequest $request, DestroyAction $destroy_action)
    {
        DB::beginTransaction();
        try {
            $images = ShopProductImage::where('image', 'like', '%' . $request->search_term . '%')
                ->orWhere('id', 'like', '%' . $request->search_term . '%')
                ->get();
            foreach ($images as $image) {
                $destroy_action->execute($image);
            }
            DB::commit();
            return response()->json([], 204);
        } catch (\Exception $exception) {
            DB::rollback();
            return response()->json(['error=', $exception->getMessage()], 500);
        }
    }
}
