<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CityRequest;
use App\Models\City;
use App\Models\UserAddress;
use App\Models\Seo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use App\Helpers\UploadFile;

class SeoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $MainTitle = 'SEO';
        $SubTitle = 'View';
        return view('Admin._seo.index', compact('MainTitle', 'SubTitle'));
    }
    //show cities in DT
    public function seos()
    {
        $records = Seo::all();
        return Datatables::of($records)->make(true);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $MainTitle = 'SEO';
        $SubTitle = 'Edit';
        $seo = Seo::findOrFail($id);
        return view('Admin._seo.edit', compact('MainTitle', 'SubTitle', 'seo'));
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $seo = Seo::findOrFail($id);
      
        if ($request->file('image_en')) {
          //Remove old file
          UploadFile::RemoveFile($seo->translate('en')->image);
          $seo->translate('en')->image = UploadFile::UploadSinglelFile($request->file('image_en'), 'seos');
        }

        if ($request->file('image_ar')) {
          //Remove old file
          UploadFile::RemoveFile($seo->translate('ar')->image);
          $seo->translate('ar')->image = UploadFile::UploadSinglelFile($request->file('image_ar'), 'seos');
        }

        DB::beginTransaction();
        try {
            $seo->translate('en')->title = $input['title_en'];
            $seo->translate('ar')->title = $input['title_ar'];
          	$seo->translate('en')->description = $input['description_en'];
            $seo->translate('ar')->description = $input['description_ar'];

            $seo->save();
            DB::commit();
            session()->flash('_updated', 'Seo data has been updated succssfuly');
            return back();
        } catch (\Exception $exception) {
          	dd($exception);
            DB::rollback();
            abort(500);
        }
    }
}
