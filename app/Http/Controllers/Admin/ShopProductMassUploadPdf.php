<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UploadPDFsProductsRequest;
use Illuminate\Http\Request;
use App\Models\ShopProductPdf;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;
use App\Helpers\UploadFile;

class ShopProductMassUploadPdf extends Controller
{
    //upload Multiple PDF to mas upload products file
    public function upload()
    {
        $title ='Select multiple PDF files|max count must be <= 50 file';
        return view('Admin._shop_products.pdf',compact('title'));
    }
    public function view(){
        $records = ShopProductPdf::all();
        return Datatables::of($records)->make(true);
    }
    public function store(UploadPDFsProductsRequest $request)
    {
        DB::beginTransaction();
        try {
           for($i=0; $i<count($request->file('pdfs')); $i++)
            {
                $pdf =  UploadFile::UploadProductFile($request->file('pdfs')[$i],'shop_products');
				ShopProductPdf::create(['pdf'=>$pdf]);
        	}
            DB::commit();
        	return response()->json(['success'=>$pdf]);
        } catch (\Exception $exception) {
            DB::rollback();
        	return response()->json([]);
        }
    }
   public function delete(Request $request, $id){
        $pdf=ShopProductPdf::findOrFail($id);
        if ($pdf->pdf)
           UploadFile::RemoveFile($pdf->pdf);
        $pdf->delete();
        return response()->json([],200);
    }
}
