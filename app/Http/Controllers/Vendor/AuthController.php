<?php

namespace App\Http\Controllers\Vendor;

use App\Actions\Vendor\Register\StoreAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Vendor\Auth\LoginRequest;
use App\Http\Requests\Vendor\Auth\RegisterRequest;
use Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function login()
    {
        return view('Vendor.auth.login');
    }

    public function checkLogin(LoginRequest $request)
    {
        if (auth()->guard('vendor')->attempt([
            'responsible_person_email' => $request->email,
            'password' => $request->password,
        ])) {

            return redirect()->route('vendor.index');

        } else {
            session()->flash('error', "Invalid credentials");

            return redirect()->route('vendor.login');
        }
    }

    public function viewRegister()
    {
        return view('Vendor.auth.register');
    }

    public function register(RegisterRequest $request, StoreAction $store_action)
    {
        DB::beginTransaction();

        try {
            $store_action->execute($request);

            DB::commit();

            session()->flash('_added', "Added");

            return redirect()->route('vendor.login');

        } catch (\Exception $exception) {

            DB::rollback();

            session()->flash('error', "Failed, Please try again later.");

            return redirect()->route('vendor.register');
        }
    }

    public function logout()
    {
        auth()->guard('vendor')->logout();

        return redirect()->route('vendor.login');
    }
}