<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Advertising;
use App\Models\Category;
use Yajra\Datatables\Datatables;
use App\Helpers\UploadFile;
use App\Http\Requests\Admin\UpdateAdRequest;
use App\Http\Requests\Admin\StoreAdRequest;
use Illuminate\Support\Facades\DB;

class AdsController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('Admin._advertisings.index');
    }

    /**
     * Display a listing of the resource in DT.
     */
    public function advertisings(Request $request)
    {

        $records = Advertising::where('type', $request->input('type', 'company'))->get();
        return Datatables::of($records)->make(true);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $level1Categories = Category::where('level', 'level1')->get();
        return view('Admin._advertisings.create', compact('level1Categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdRequest $request)
    {
        $input = $request->all();
        if (Advertising::where('type', $request->input('type'))->where('alignment', $request->input('alignment'))->where('type', '!=', 'category')->count()) {
            session()->flash('error', 'Advertising already exist');
            return redirect(route('advertisings.create') . '?type=' . $request->input('type'))->withInput();
        }
        if (Advertising::where('type', $request->input('type'))->where('alignment', $request->input('alignment'))->where('category_id', $request->input('category_id'))->count()) {
            session()->flash('error', 'Advertising already exist');
            return redirect(route('advertisings.create') . '?type=' . $request->input('type'))->withInput();
        }
        DB::beginTransaction();
        try {
            //upload new file
            if ($request->file('image'))
                $image =  UploadFile::UploadSinglelFile($request->file('image'), 'ads');
            else
                $image = null;

            if ($request->file('mobileimg'))
                $mob_image =  UploadFile::UploadSinglelFile($request->file('mobileimg'), 'ads');
            else
                $mob_image = null;

            Advertising::create([
                'type'          => $request->input('type'),
                'category_id'   => $request->input('category_id'),
                'image'     => $image,
                'mobileimg'     => $mob_image,
                'alignment' => $input['alignment'],
                'url'       => $input['url'],
                'en'        =>  ['alt' => $input['alt_en']],
                'ar'        =>  ['alt' => $input['alt_ar']],
            ]);
            DB::commit();
            session()->flash('_added', 'Advertising has been Created Succssfuly');
            return redirect(route('advertisings.index') . '?type=' . $request->input('type'));
        } catch (\Exception $exception) {
            DB::rollback();
            abort(500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $advertising  = Advertising::findOrFail($id);
        $level1Categories = Category::where('level', 'level1')->get();
        return view('Admin._advertisings.edit', compact('advertising', 'level1Categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdRequest $request, $id)
    {
        $input = $request->all();
        $ad = Advertising::findOrFail($id);
        DB::beginTransaction();
        try {
            //upload new file
            if ($request->file('image')) {
                //Remove old file
                UploadFile::RemoveFile($ad->image);
                $ad->image =  UploadFile::UploadSinglelFile($request->file('image'), 'ads');
            }

            if ($request->file('mobileimg')) {
                //Remove old file
                UploadFile::RemoveFile($ad->mobileimg);
                $ad->mobileimg =  UploadFile::UploadSinglelFile($request->file('mobileimg'), 'ads');
            }
            $ad->translate('en')->alt  = $input['alt_en'];
            $ad->translate('ar')->alt  = $input['alt_ar'];
            $ad->alignment             = $input['alignment'];
            $ad->url                   = $input['url'];
            $ad->category_id           = $request->category_id ? $input['category_id'] : null;
            $ad->save();
            DB::commit();
            session()->flash('_added', 'Advertising has been Updated Succssfuly');
            return back();
        } catch (\Exception $exception) {
            DB::rollback();
            abort(500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy($id)
    // {
    //     $advertising = Advertising::find($id)->delete();
    //     //Remove old file
    //     UploadFile::RemoveFile($advertising->image);
    //     return response()->json(['success' => 'Data is successfully deleted']);
    // }
}
