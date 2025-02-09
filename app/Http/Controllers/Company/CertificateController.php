<?php

namespace App\Http\Controllers\Company;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Certificate;
use Yajra\Datatables\Datatables;
use App\Http\Requests\Company\StoreCertificateRequest;
use Illuminate\Support\Facades\DB;
use App\Helpers\UploadFile;
class CertificateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $MainTitle = 'Certificates';
        $SubTitle  = 'View';
        return view('Company._certificates.index',compact('MainTitle','SubTitle'));
    }
    /**
     * Display a listing of the resource in DT.
     */
    public function certificates()
    {
        $records = Certificate::where('company_id',CompanyID())->get();
        return Datatables::of($records)->make(true);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $MainTitle = 'Certificates';
        $SubTitle  = 'View';
        return view('Company._certificates.create',compact('MainTitle','SubTitle'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCertificateRequest $request)
    {
        $input = $request->all();
        //upload new file
        if ($request->file('filename'))
            $file =  UploadFile::UploadSinglelFile($request->file('filename'),'CompanyCertificates');
        else
            $file = null;
        DB::beginTransaction();
        try {
            Certificate::create([
                'name'       => $file,
                'company_id' => $input['company_id'],
                 'en'    => [
                      'CertiName'     => $input['name_en']
                  ],
                'ar'     => [
                       'CertiName'    => $input['name_ar']
                  ],
            ]);
            DB::commit();
            session()->flash('_added','Certificate has been Created Succssfuly');
            return redirect()->route('company.certificate.index'); 
        }catch (\Exception $exception) {
            DB::rollback();
            abort(500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $certificate  = Certificate::findOrFail($id);
        if ($certificate->name) {
            //Remove old file
            UploadFile::RemoveFile($certificate->name);
        }
        $certificate->delete();
        return response()->json(['success' => 'Data is successfully deleted']);
    }
}
