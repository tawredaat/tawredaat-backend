<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\UploadFile;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UploadImagesProductsRequest;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;

class MassUploadImageProductsController extends Controller
{
    //upload Multiple image to mas upload products file
    public function upload()
    {
        $title = 'Select multiple images|max count must be <= 50 image';
        return view('Admin._products.upload_images', compact('title'));
    }
    public function view()
    {
        $records = ProductImage::all();
        return Datatables::of($records)->make(true);
    }

    public function store(UploadImagesProductsRequest $request)
    {
        DB::beginTransaction();
        try {
            for ($i = 0; $i < count($request->file('images')); $i++) {

                $image = UploadFile::UploadProductFile($request->file('images')[$i], 'products');
                ProductImage::create(['image' => $image]);
            }
            DB::commit();

            return response()->json(['success' => $image]);

        } catch (\Exception $exception) {
            DB::rollback();

            return abort(500);
        }
    }
    public function delete(Request $request, $id)
    {
        $product = ProductImage::findOrFail($id);
        UploadFile::RemoveFile($product->image);
        $product->delete();
        return response()->json([], 200);
    }
}
