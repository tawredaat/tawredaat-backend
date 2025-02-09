<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\SettingsRequest;
use Illuminate\Support\Facades\DB;
use App\Models\SearchStore;
use App\Helpers\UploadFile;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SearchProductsExport;
use App\Exports\SearchCompaniesExport;
use App\Exports\SearchBrandsExport;
use App\Http\Requests\Admin\ExportSearchRequest;
use Carbon\Carbon;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function products()
    {
        return view('Admin._search.product');
    }
    //get products
    public function getProducts(ExportSearchRequest $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        if ($start_date and $end_date) {
            $results = SearchStore::where('search_type','product')->whereBetween('created_at',[Carbon::parse($start_date), Carbon::parse($end_date)])->get();
            return DataTables::of($results)->addColumn('search_value', function (SearchStore $product){
                return $product->search_value;
            })
            ->addColumn('date_added', function (SearchStore $product){
                return date('M d, Y',strtotime($product->created_at));
            })
            ->addColumn('time_added', function (SearchStore $product){
                return date('h:i a',strtotime($product->created_at));
            })
            ->make(true);
        }
        return DataTables::of(SearchStore::where('search_type','product')->get())->addColumn('search_value', function (SearchStore $product){
                return $product->search_value;
            })
            ->addColumn('date_added', function (SearchStore $product){
                return date('M d, Y',strtotime($product->created_at));
            })
            ->addColumn('time_added', function (SearchStore $product){
                return date('h:i a',strtotime($product->created_at));
            })
            ->make(true);
    }
    //export products into excel sheet
    public function getExcelProducts(ExportSearchRequest $request)
    {
        if ($request->filter) {
             return view('Admin._search.product');
        }
        return Excel::download(new SearchProductsExport($request->input('start_date'), $request->input('end_date')), 'SearchInProducts.csv');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function companies()
    {
        return view('Admin._search.company');
    }
    //get companies
    public function getCompanies(ExportSearchRequest $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        if ($start_date and $end_date) {
            $results = SearchStore::where('search_type','company')->whereBetween('created_at',[Carbon::parse($start_date), Carbon::parse($end_date)])->get();
            return DataTables::of($results)->addColumn('search_value', function (SearchStore $company){
                return $company->search_value;
            })
            ->addColumn('date_added', function (SearchStore $company){
                return date('M d, Y',strtotime($company->created_at));
            })
            ->addColumn('time_added', function (SearchStore $company){
                return date('h:i a',strtotime($company->created_at));
            })
            ->make(true);
        }
        return DataTables::of(SearchStore::where('search_type','company')->get())
           ->addColumn('search_value', function (SearchStore $company){
                return $company->search_value;
            })
            ->addColumn('date_added', function (SearchStore $company){
                return date('M d, Y',strtotime($company->created_at));
            })
            ->addColumn('time_added', function (SearchStore $company){
                return date('h:i a',strtotime($company->created_at));
            })
            ->make(true);
    }
        //export companies into excel sheet
    public function getExcelCompanies(ExportSearchRequest $request)
    {
        if ($request->filter) {
             return view('Admin._search.company');
        }
        return Excel::download(new SearchCompaniesExport($request->input('start_date'), $request->input('end_date')), 'SearchInCompanies.csv');
    }
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function brands()
    {
        return view('Admin._search.brand');
    }
    //get brands
    public function getBrands(ExportSearchRequest $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        if ($start_date and $end_date) {
            $results = SearchStore::where('search_type','brand')->whereBetween('created_at',[Carbon::parse($start_date), Carbon::parse($end_date)])->get();
            return DataTables::of($results)->addColumn('search_value', function (SearchStore $brand){
                return $brand->search_value;
            })
            ->addColumn('date_added', function (SearchStore $brand){
                return date('M d, Y',strtotime($brand->created_at));
            })
            ->addColumn('time_added', function (SearchStore $brand){
                return date('h:i a',strtotime($brand->created_at));
            })
            ->make(true);
        }
        return DataTables::of(SearchStore::where('search_type','brand')->get())
           ->addColumn('search_value', function (SearchStore $brand){
                return $brand->search_value;
            })
            ->addColumn('date_added', function (SearchStore $brand){
                return date('M d, Y',strtotime($brand->created_at));
            })
            ->addColumn('time_added', function (SearchStore $brand){
                return date('h:i a',strtotime($brand->created_at));
            })
            ->make(true);
    }
    //export brands into excel sheet
    public function getExcelBrands(ExportSearchRequest $request)
    {
        if ($request->filter) {
             return view('Admin._search.brand');
        }
        return Excel::download(new SearchBrandsExport($request->input('start_date'), $request->input('end_date')), 'SearchInBrands.csv');
    }
}
