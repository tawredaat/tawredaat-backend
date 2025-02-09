<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UploadPDFsProductsRequest;
use Illuminate\Http\Request;
use App\Models\ProductPDF;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;
use App\Helpers\UploadFile;

class MassUploadPDFProductController extends Controller
{
    //upload Multiple PDF to mas upload products file
    public function upload()
    {
        $title ='Select multiple PDF files|max count must be <= 50 file';
        return view('Admin._products.pdf',compact('title'));
    }
    public function view(){
        $records = ProductPDF::all();
        return Datatables::of($records)->make(true);
    }
    public function store(UploadPDFsProductsRequest $request)
    {
        DB::beginTransaction();
        try {
           for($i=0; $i<count($request->file('pdfs')); $i++)
            {
                $pdf =  UploadFile::UploadProductFile($request->file('pdfs')[$i],'products');
				ProductPDF::create(['pdf'=>$pdf]);
        	}
            DB::commit();
        	return response()->json(['success'=>$pdf]);
            // return redirect()->route('subscriptions.index');
        } catch (\Exception $exception) {
            DB::rollback();
            return abort(500);
        }
    }
   public function delete(Request $request, $id){
        $pdf=ProductPDF::findOrFail($id);
        if ($pdf->pdf) {
           UploadFile::RemoveFile($pdf->pdf);
        }
        $pdf->delete();
        return response()->json([],200);
    }
}
