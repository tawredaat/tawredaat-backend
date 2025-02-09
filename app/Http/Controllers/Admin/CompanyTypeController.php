<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use App\Models\CompanyType;
use App\Http\Requests\Admin\CompanyTypeRequest;
use Illuminate\Support\Facades\DB;
class CompanyTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $MainTitle = 'Company Types';
        $SubTitle  = 'View';
        return view('Admin._company_types.index',compact('MainTitle','SubTitle'));
    }
    /**
     * Display a listing of the resource in DT.
     *
     * @return Json object
     */
    public function company_types()
    {
        $records = CompanyType::all();
        return Datatables::of($records)->make(true);
    }    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $MainTitle = 'Company Types';
        $SubTitle  = 'Create';
        return view('Admin._company_types.create',compact('MainTitle','SubTitle'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyTypeRequest $request)
    {
        $input = $request->all();
        DB::beginTransaction();
        try {  
            CompanyType::create([
            'en'   => [
                        'name'=> $input['name_en'],
                    ],
            'ar'   => [
                        'name' => $input['name_ar'],
                    ],
            ]);
            DB::commit();
            session()->flash('_added','Company Type  Create Succssfuly');
            return redirect()->route('company_types.index');
        }catch (\Exception $exception) {
            DB::rollback();
            abort(500);
        }         
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $company_type = CompanyType::findOrFail($id);
       $MainTitle = 'Company Types';
       $SubTitle  = 'Edit';
       return view('Admin._company_types.edit',compact('company_type','MainTitle','SubTitle'));        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CompanyTypeRequest $request, $id)
    {
        $company_type=CompanyType::findOrFail($id);
        $input = $request->all();
        DB::beginTransaction();
        try {         
            $company_type->translate('en')->name  = $input['name_en'];
            $company_type->translate('ar')->name  = $input['name_ar'];
            $company_type->save();
            DB::commit();
            session()->flash('_updated','Company Type updated succssfuly');
            return back();   
        }catch (\Exception $exception) {
            DB::rollback();
            abort(500);
        }                   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $companyType = CompanyType::findOrFail($id);
        $companyType->delete();
        return response()->json([],200);
    }
}
