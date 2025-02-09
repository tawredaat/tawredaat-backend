<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Branch;
use Yajra\Datatables\Datatables;
use App\Http\Requests\Company\StoreBranchRequest;
use App\Http\Requests\Company\UpdateBranchRequest;
use Illuminate\Support\Facades\DB;
use App\Helpers\UploadFile;
class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $branchs     = Branch::pluck('id');
        $MainTitle   = 'Branches';
        $SubTitle    = 'View';
        return view('Company._branchs.index',compact('MainTitle','SubTitle','branchs'));
    }
    /**
     * Display a listing of the resource in DT.
     */
    public function branches()
    {
        $records = Branch::where('company_id',CompanyID())->get();
        return Datatables::of($records)->make(true);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $MainTitle   = 'Branches';
        $SubTitle    = 'Add';
        return view('Company._branchs.create',compact('MainTitle','SubTitle'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBranchRequest $request)
    {
        //upload new file
        if ($request->file('image'))
            $image =  UploadFile::UploadSinglelFile($request->file('image'),'CompanyBranches');
        else
            $image = null;
        $input = $request->all();
        DB::beginTransaction();
        try {
        Branch::create([
            'image'         => $image,
            'company_id'    => $input['company_id'],
            'location'      => $input['location'],
            'en'    => [
                      'name'     => $input['name_en'],
                      'address'  => $input['address_en'],
                      'alt'      => $input['alt_en']
                  ],
           'ar'     => [
                       'name'    => $input['name_ar'],
                       'address' => $input['address_ar'],
                       'alt'     => $input['alt_ar']
                  ],
        ]);
        DB::commit();
        session()->flash('_added','Branch has been createed succssfuly');
        return redirect()->route('company.branches.index');
        }catch (\Exception $exception){
            DB::rollback();
            abort(500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
      
        $MainTitle = 'Branches';
        $SubTitle  = 'Edit';
        $branch    = Branch::findOrFail($id); 
        if(CompanyID()==$branch->company_id)
            return view('Company._branchs.edit',compact('MainTitle','SubTitle','branch'));
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(UpdateBranchRequest $request, $id)
    {
        $input = $request->all();
        $branch = Branch::find($id);
        //upload new file
        if ($request->file('image'))
        {
            //Remove old file
            UploadFile::RemoveFile($branch->image);
            $image =  UploadFile::UploadSinglelFile($request->file('image'),'CompanyBranches');
        }
        else
            $image = $branch->image;
        
        DB::beginTransaction();
        try {
            $branch->image                    =  $image;
            $branch->location                 =  $input['location'];
            $branch->translate('en')->name    = $input['name_en'];
            $branch->translate('ar')->name    = $input['name_ar'];  
            $branch->translate('en')->address = $input['address_en'];
            $branch->translate('ar')->address = $input['address_ar'];            
            $branch->translate('en')->alt     = $input['alt_en'];            
            $branch->translate('ar')->alt     = $input['alt_ar'];            
            $branch->save();
        DB::commit();
        session()->flash('_updated','Branch data has been updated succssfuly');
        return back();
        }catch (\Exception $exception){
            DB::rollback();
            abort(500);
        }
      
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $branch  = Branch::findOrFail($id);
        //Remove old file
        if ($branch->image) 
            UploadFile::RemoveFile($branch->image);
        $branch->delete();
        return response()->json(['success' => 'Data is successfully deleted']);
    }
}


