<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BrandVisitor;
use App\Models\CompanyVisitor;
use App\Models\SiteVisitor;
use Yajra\Datatables\Datatables;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function site()
    {
        return view('Admin._dashboard.SiteVisitors');
    }
    //get site Visitors
    public function getSiteVisitors()
    {
        return DataTables::of(SiteVisitor::all())
            ->addColumn('user', function (SiteVisitor $user) {
                return $user->user ? $user->user->name : 'anonymous';
            })
            ->addColumn('date_added', function (SiteVisitor $user) {
                return date('M d, Y', strtotime($user->created_at));
            })
            ->addColumn('time_added', function (SiteVisitor $user) {
                return date('h:i a', strtotime($user->created_at));
            })
            ->make(true);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function companies()
    {
        return view('Admin._dashboard.companyVisitors');
    }
    //get company Visitors
    public function getCompanyVisitors()
    {
        return DataTables::of(CompanyVisitor::all())
            ->addColumn('user', function (CompanyVisitor $user) {
                return $user->user ? $user->user->name : 'anonymous';
            })
            ->addColumn('date_added', function (CompanyVisitor $user) {
                return date('M d, Y', strtotime($user->created_at));
            })
            ->addColumn('time_added', function (CompanyVisitor $user) {
                return date('h:i a', strtotime($user->created_at));
            })
            ->make(true);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function brands()
    {
        return view('Admin._dashboard.BrandsVisitors');
    }
    //get brands Visitors
    public function getBrandVisitors()
    {
        return DataTables::of(BrandVisitor::all())
            ->addColumn('user', function (BrandVisitor $user) {
                return $user->user ? $user->user->name : 'anonymous';
            })
            ->addColumn('date_added', function (BrandVisitor $user) {
                return date('M d, Y', strtotime($user->created_at));
            })
            ->addColumn('time_added', function (BrandVisitor $user) {
                return date('h:i a', strtotime($user->created_at));
            })
            ->make(true);
    }
}
