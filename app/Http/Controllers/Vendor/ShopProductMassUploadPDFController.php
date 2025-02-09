<?php

namespace App\Http\Controllers\Vendor;

use App\Actions\Vendor\ShopProductPDF\DeleteAction;
use App\Actions\Vendor\ShopProductPDF\UploadAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UploadPDFsProductsRequest;
use App\Models\File;
use App\Models\VendorShopProductPdf;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ShopProductMassUploadPDFController extends Controller
{
    //upload Multiple PDF to mas upload products file
    public function upload()
    {
        $title = 'Select multiple PDF files|max count must be <= 50 file';

        return view('Vendor.shop_product_mass_pdfs.pdfs', compact('title'));
    }

    public function data()
    {
        $records = VendorShopProductPdf::all();

        return DataTables::of($records)->make(true);
    }

    public function store(UploadPDFsProductsRequest $request, UploadAction $upload_action)
    {
        DB::beginTransaction();

        try {

            for ($i = 0; $i < count($request->file('pdfs')); $i++) {
                $upload_action->execute($request->file('pdfs')[$i]);
            }

            DB::commit();

            return response()->json(['success' => 'Uploaded']);

        } catch (\Exception $exception) {
            DB::rollback();

            return response()->json([]);
        }
    }

    public function delete($id, DeleteAction $delete_action)
    {
        try {
            $pdf = VendorShopProductPdf::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json([], 101);
        }

        DB::beginTransaction();

        try {

            $delete_action->execute($id);

            DB::commit();

            return response()->json([], 200);

        } catch (\Exception $exception) {
            DB::rollback();

            return response()->json([], 101);

        }

    }
}
