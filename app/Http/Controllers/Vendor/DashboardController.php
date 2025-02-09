<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('Vendor.dashboard.index');
    }

}