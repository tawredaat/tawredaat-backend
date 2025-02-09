<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\StoreShopBennerRequest;
use App\Http\Requests\Admin\UpdateShopBennerRequest;
use App\Models\ShopBanner;
use App\Helpers\UploadFile;
use Illuminate\Support\Facades\DB;
class ShopBannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $MainTitle = 'Shop Banners';
        $SubTitle  = 'View';
        return view('Admin._shop_banners.index',compact('MainTitle','SubTitle'));
    }
   /**
     * Display a listing of the resource in DT.
     */
    public function banners()
    {
        $records = ShopBanner::all();
        return Datatables::of($records)->make(true);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $MainTitle = 'Shop Banners';
        $SubTitle  = 'Add';
        return view('Admin._shop_banners.create',compact('MainTitle','SubTitle'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreShopBennerRequest $request)
    {
        $input = $request->all();
        $img = null;
        $mob_img = null;
        //upload new file
        if ($request->file('img'))
            $img =  UploadFile::UploadSinglelFile($request->file('img'),'shop_banners');

        //upload new file
        if ($request->file('mobileimg'))
            $mob_img =  UploadFile::UploadSinglelFile($request->file('mobileimg'),'shop_banners');


        DB::beginTransaction();
        try {
            ShopBanner::create([
                'img'       => $img,
                'mobileimg' => $mob_img,
                'url'       => $input['url'],
                'en'=> [
                        'alt' => $input['altEN'],
                        ],
                'ar' => [
                        'alt' => $input['altAR'],
                        ],
            ]);
            DB::commit();
        session()->flash('_added','Shop Banner has been created succssfuly');
        return redirect()->route('shop.banners.index');
        }
        catch (\Exception $exception) {
            DB::rollback();
            abort(500);
        }

    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $banner    = ShopBanner::findOrFail($id);
        $MainTitle = 'Shop Banners';
        $SubTitle  = 'Edit';
        return view('Admin._shop_banners.edit',compact('MainTitle','SubTitle','banner'));
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(UpdateShopBennerRequest $request, $id)
    {
        $banner = ShopBanner::findOrFail($id);
        $input = $request->all();
        //upload new file
        if ($request->file('img'))
        {
            //Remove old file
            UploadFile::RemoveFile($banner->img);
            $img =  UploadFile::UploadSinglelFile($request->file('img'),'shop_banners');
        }
        else
            $img = $banner->img;
        //upload new file
        if ($request->file('mobileimg'))
        {
            //Remove old file
            UploadFile::RemoveFile($banner->mobileimg);
            $mob_img =  UploadFile::UploadSinglelFile($request->file('mobileimg'),'shop_banners');
        }
        else
            $mob_img = $banner->mobileimg;

        DB::beginTransaction();
        try {
            $banner->img  = $img;
            $banner->mobileimg = $mob_img;
            $banner->url  = $input['url'];
            $banner->translate('en')->alt  = $input['altEN'];
            $banner->translate('ar')->alt  = $input['altAR'];
            $banner->save();
            DB::commit();
            session()->flash('_updated','Shop Banner data has been updated succssfuly');
            return back();
        }
        catch (\Exception $exception) {
            DB::rollback();
            abort(500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $banner = ShopBanner::find($id);
        //Remove old file
        if($banner->img)
            UploadFile::RemoveFile($banner->img);
        if($banner->mobileimg)
            UploadFile::RemoveFile($banner->mobileimg);
        $banner->delete();
        return response()->json(['success' => 'Data is successfully deleted']);
    }
}
