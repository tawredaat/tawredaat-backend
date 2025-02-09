<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\UploadFile;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\UserAddress;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\Datatables\Datatables;
use App\Exports\ExportUsersData;
use Maatwebsite\Excel\Facades\Excel;
  
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $MainTitle = 'Users';
        $SubTitle = 'View';
        return view("Admin._users.index", compact('MainTitle', 'SubTitle'));
    }

    /**
     * Display a listing of the resource in DT.
     */
    public function users(Request $request)
    {

        $records = User::whereNull('device_id')
            ->when($request->input('start_date') && $request->input('end_date'),
                function ($query) use ($request) {
                    $query->whereBetween('created_at', [Carbon::parse($request->start_date),
                        Carbon::parse($request->end_date)]);
                })
            ->when($request->input('column') && $request->input('value'),
                function ($query) use ($request) {
                    $query->when($request->input('column') == 'city',
                        function ($query) use ($request) {
                            return $query->whereHas('addresses', function ($query)
                                 use ($request) {
                                    $query->whereHas('city', function ($query) use ($request) {
                                        $query->whereHas('translations', function ($query) use ($request) {
                                            $query->where('name', 'like', '%' . $request->input('value') . '%');
                                        });
                                    });
                                });
                        });
                })
            ->orderBy('created_at', 'desc')->get();

        return Datatables::of($records)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $MainTitle = 'Users';
        $SubTitle = 'Add';
        return view('Admin._users.create', compact('MainTitle', 'SubTitle'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $input = $request->all();
        if ($request->file('photo'))
        //upload new file
        {
            $photo = UploadFile::UploadSinglelFile($request->file('photo'), 'users');
        } else {
            $photo = null;
        }

        DB::beginTransaction();
        try {
            User::create([
                // first name
                'name' => $input['name'],
                'last_name' => $input['last_name'],
                'email' => $input['email'],
                'password' => bcrypt($input['password']),
                'title' => $input['title'],
                'company_name' => $input['company_name'],
                'phone' => $input['phone'],
                'photo' => $photo,
            ]);
            DB::commit();
            session()->flash('_added', 'User has been created Succssfuly');
            return redirect()->route('users.index');
        } catch (\Exception $exception) {
            DB::rollback();
            return abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $MainTitle = 'Users';
        $SubTitle = 'Edit';
        $user = User::findOrFail($id);
        return view('Admin._users.edit', compact('user', 'MainTitle', 'SubTitle'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $input = $request->all();
        if ($request->has('password')) {
            $password = bcrypt($input['password']);
        } else {
            $password = $user->password;
        }

        if ($request->file('photo')) {
            //Remove old file
            UploadFile::RemoveFile($user->photo);
            //upload new file
            $photo = UploadFile::UploadSinglelFile($request->file('photo'), 'users');
        } else {
            $photo = $user->photo;
        }

        DB::beginTransaction();
        try {
            User::where('id', $id)->update([
                // first name
                'name' => $input['name'],
                'last_name' => $input['last_name'],
                'email' => $input['email'],
                'phone' => $input['phone'],
                'password' => $password,
                'title' => $input['title'],
                'company_name' => $input['company_name'],
                'photo' => $photo,
            ]);
            DB::commit();
            session()->flash('_updated', 'User data has been updated succssfuly');
            return back();
        } catch (\Exception $exception) {
            DB::rollback();
            return abort(500);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        //Remove old file
        if ($user->photo) {
            UploadFile::RemoveFile($user->photo);
        }

        $user->delete();
        return response()->json([], 200);
    }

    public function searchByName(Request $request)
    {
        $part_of_name = trim($request->part_of_name);

        if (empty($part_of_name)) {
            return response()->json([]);
        }

        $users = User::where(function ($query) use ($part_of_name) {
            $query->where('name', 'like', '%' . $part_of_name . '%');
        })
            ->select('id', 'name')->get();

        $formatted_users = [];

        foreach ($users as $user) {
            $formatted_users[] = ['id' => $user->id,
                'text' => $user->name];
        }

        return response()->json($formatted_users);
    }

    public function address(Request $request)
    {
        return UserAddress::where('user_id', $request->user_id)->get();
    }
  
  	public function exportUser($userType)
    {
        try {
            $records = User::where('user_type' , $userType)->get();
            return Excel::download(new ExportUsersData($records), $userType.'_data.csv');
        } catch (\Exception $ex) {
          dd($ex);
            return redirect()->back()->with('error', 'Error occured, Please try again later.');
        }
    }
}
