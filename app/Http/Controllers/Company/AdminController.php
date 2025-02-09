<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Models\CompanyAdmin;
use App\Http\Requests\Company\StoreAdminRequest;
use App\Http\Requests\Company\UpdateAdminRequest;
use Illuminate\Support\Facades\DB;
class AdminController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $MainTitle = 'Admins';
        $SubTitle  = 'View';
        return view('Company._admins.index',compact('MainTitle','SubTitle'));
    }
     /**
     * Display a listing of the resource in DT.
     */
    public function admins()
    {
        $records = CompanyAdmin::where('company_id',CompanyID())->get();
        return Datatables::of($records)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $MainTitle = 'Admins';
        $SubTitle = 'Add';
        return view('Company._admins.create',compact('MainTitle','SubTitle'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdminRequest $request)
    {

        $input = $request->all();
        DB::beginTransaction();
        try {
        CompanyAdmin::create([
            'name_en'    =>  $input['name_en'],
            'email'      => $input['email'],
            'password'   => bcrypt($input['password']),
            'phone'      => $request->phone,
            'company_id' => $input['company_id'],
        ]);
        DB::commit();
        session()->flash('_added','Admin data has been  created succssfuly');
        return redirect()->route('company.admins.index');
        }catch (\Exception $exception) {
            DB::rollback();
            abort(500);
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     */
    public function edit($id)
    {
      
        $admin      = CompanyAdmin::find($id);
        $MainTitle  = 'Admins';
        $SubTitle   = 'Edit';
        if(CompanyID()==$admin->company_id) {
           return view('Company._admins.edit',compact('admin','MainTitle','SubTitle'));
        }
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(UpdateAdminRequest $request, $id)
    {

        $input = $request->all();
        $admin = CompanyAdmin::findOrFail($id);
        if ($input['password'])
                $password = bcrypt($input['password']);
        else
            $password = $admin->password;
        DB::beginTransaction();
        try {
        CompanyAdmin::where('id',$id)->update([
            'name_en'   =>  $input['name_en'],
            'email'      => $input['email'],
            'password'   => $password,
            'phone'      => $request->phone,
        ]);
        DB::commit();
            session()->flash('_updated','Admin data has been updated succssfuly');
            return back();
        }catch (\Exception $exception) {
            DB::rollback();
            abort(500);
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     */
    public function destroy($id)
    {
        $admin = CompanyAdmin::findOrFail($id)->delete();
        return response()->json(['success' => 'Data is successfully deleted']);
    }
}
