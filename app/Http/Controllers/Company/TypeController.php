<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CompanyType;
use Yajra\Datatables\Datatables;
use App\Http\Requests\Company\StoreTypeRequest;
use Illuminate\Support\Facades\DB;

class TypeController extends Controller
{
    /**
    * Display a listing of the resource.
    */
    public function index()
    {
        $MainTitle = 'Company Types';
        $SubTitle  = 'View';
        return view('Company._types.index',compact('MainTitle','SubTitle'));
    }
    /**
    * Display a listing of the resource in DT.
    */
    public function company_types()
    {
        $records = auth('company')->user()->company_types()->get();
        return Datatables::of($records)->make(true);
    }
    /**
     * Show the form for creating a new resource.
    */
    public function create()
    {
        $MainTitle = 'Company Types';
        $SubTitle  = 'Create';
        $mycompany_types= auth('company')->user()->company_types->pluck('id');
        $company_types=CompanyType::whereNotIn('id',$mycompany_types)->get();        
        return view('Company._types.create',compact('MainTitle','SubTitle','company_types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTypeRequest $request)
    {
        DB::beginTransaction();
        try {
        auth('company')->user()->company_types()->attach($request->company_types);
        DB::commit();
        session()->flash('_added','company_type of operations has been createed succssfuly');
        return redirect()->route('company.types.index');
        }catch (\Exception $exception) {
            DB::rollback();
            abort(500);
        }
    }
    /**
     * Show the form for editing the specified resource.
    */
    public function edit($id)
    {
        
        // $MainTitle = 'Company Types';
        // $SubTitle  = 'Edit';
        // $company_type   = company_type_operation::findOrFail($id); 
        // if(auth('company')->user()->id==$company_type->company_id) {
        // return view('Company._types.edit',compact('MainTitle','SubTitle','company_type'));
        // }
        // abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
    */
    public function update(Updatecompany_typeOfOperationRequest $request, $id)
    {
        // $input = $request->all();
        // DB::beginTransaction();
        // try {
        // company_type_operation::where('id',$id)->update([
        //     'name_en'  => $input['name_en'],
        //     'name_ar'  => $input['name_ar'],
        // ]);
        // DB::commit();
        // session()->flash('_updated','Branch data has been updated succssfuly');
        // return redirect()->route('company.types.index');
        // }catch (\Exception $exception) {
        //     DB::rollback();
        //     abort(500);
        // }   
    }
    /**
     * Remove the specified resource from storage.
    */
    public function destroy($id)
    {
        $company_type = CompanyType::findOrFail($id);
        auth('company')->user()->company_types()->detach($id);
        return response()->json(['success' => 'Data is successfully deleted']);
    }
}
