<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Admin\ValidSuperAdminPasswordRequest;
use App\Http\Requests\Admin\StoreAdminRequest;
use App\Http\Requests\Admin\UpdateAdminRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\Datatables\Datatables;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $MainTitle = 'Admins';
        $SubTitle = 'View';
        return view('Admin._admins.index', compact('MainTitle', 'SubTitle'));
    }

    public function admins()
    {
        $records = Admin::all();
        return Datatables::of($records)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $MainTitle = 'Admins';
        $SubTitle = 'Add';
        return view('Admin._admins.create', compact('MainTitle', 'SubTitle'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdminRequest $request)
    {
        $input = $request->all();
        DB::beginTransaction();
        try {
            Admin::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => bcrypt($input['password']),
                'privilege' => $input['privilege'],
            ]);
            DB::commit();
            session()->flash('_added', 'Admin has been created succssfuly');
            return redirect()->route('admins.index');
        } catch (\Exception$exception) {
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
        $admin = Admin::findOrFail($id);
        $MainTitle = 'Admins';
        $SubTitle = 'Edit';
        return view('Admin._admins.edit', compact('admin', 'MainTitle', 'SubTitle'));
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(UpdateAdminRequest $request, $id)
    {
        $input = $request->all();
        $admin = Admin::findOrFail($id);
        if (request()->has('password')) {
            $password = bcrypt($input['password']);
        } else {
            $password = $admin->password;
        }

        DB::beginTransaction();
        try {
            Admin::where('id', $id)->update([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => $password,
                'privilege' => $input['privilege'],
            ]);
            DB::commit();
            session()->flash('_updated', 'Admin data has been updated succssfuly');
            return back();
        } catch (\Exception$exception) {
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
        $admin = Admin::findOrFail($id);
        if (($admin->id != 1) && ($admin->id != auth('admin')->user()->id)) {
            $admin->delete();
        }
        return response()->json(['success' => 'Data is successfully deleted']);
    }

    public function validSuperAdminPassword(ValidSuperAdminPasswordRequest $request)
    {
        $password = $request->password;
        // check that password belongs to a super admin
        $super_admins = Admin::where('privilege', 'super')
            ->select('id', 'password')->get();
        foreach ($super_admins as $super_admin) {
            if (Hash::check($password, $super_admin->password)) {
                return response()->json([], 200);
            }
        }
        return response()->json([], 101);
    }
}
