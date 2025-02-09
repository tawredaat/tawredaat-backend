<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Specification;
use Yajra\DataTables\DataTables;

class SpecificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $main_title = 'Products Specifications';

        $sub_title = 'View';

        return view('Vendor.specifications.index', compact('main_title', 'sub_title'));
    }

    public function data()
    {
        $records = Specification::all();

        return DataTables::of($records)->make(true);

    }

}