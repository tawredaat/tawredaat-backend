<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\StoreBennerRequest;
use App\Http\Requests\Admin\UpdateBennerRequest;
use App\Http\Requests\Admin\AdsBannerRequest;
use App\Models\Banner;
use App\Models\AdBanner;
use App\Helpers\UploadFile;
use Illuminate\Support\Facades\DB;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $MainTitle = 'Banners';
        $SubTitle  = 'View';
        return view('Admin._banners.index', compact('MainTitle', 'SubTitle'));
    }
    /**
     * Display a listing of the resource in DT.
     */
    public function banners()
    {
        $records = Banner::all();
        return Datatables::of($records)->make(true);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function createFirstSection()
    {
        $records = Banner::all();
        $MainTitle = 'Home Banner Create';
        $SubTitle  = 'Add';
        return view('Admin._banners.home', compact('MainTitle', 'SubTitle'));
    }

    public function createSecondSection()
    {
        $MainTitle = 'Second Section Banners';
        $SubTitle  = 'Add';
        return view('Admin._banners.create_second', compact('MainTitle', 'SubTitle'));
    }

    public function createThirdSection()
    {
        $MainTitle = 'Third Section Banners';
        $SubTitle  = 'Add';
        return view('Admin._banners.create_third', compact('MainTitle', 'SubTitle'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeHomeBanner(StoreBennerRequest $request)
    {
        $input = $request->all();

        //upload new file
        if ($request->file('imgAr'))
            $imgAr =  UploadFile::UploadSinglelFile($request->file('imgAr'), 'banners');
        else
            $imgAr = null;

        if ($request->file('imgEn'))
            $imgEn =  UploadFile::UploadSinglelFile($request->file('imgEn'), 'banners');
        else
            $imgEn = null;

        //upload new file
        if ($request->file('mobileimgAr'))
            $mob_imgAR =  UploadFile::UploadSinglelFile($request->file('mobileimgAr'), 'banners');
        else
            $mob_imgAR = null;

        if ($request->file('mobileimgEn'))
            $mob_imgEn =  UploadFile::UploadSinglelFile($request->file('mobileimgEn'), 'banners');
        else
            $mob_imgEn = null;
        DB::beginTransaction();
        try {
            Banner::create([
                /* 'img'    => $img,
                'mobileimg' => $mob_img, */
                // 'url'    => $input['url'], 
                'section' => $input['section'],
                'en' => [
                    'alt'       => $input['altEN'],
                    'img'       => $imgEn,
                    'mobileimg' => $mob_imgEn,
                    'url'       => $input['urlEn'],
                ],
                'ar' => [
                    'alt'       => $input['altAR'],
                    'img'       => $imgAr,
                    'mobileimg' => $mob_imgAR,
                    'url'       => $input['urlAr'],
                ],
            ]);
            DB::commit();
            session()->flash('_added', 'Banner has been created succssfuly');
            return redirect()->route('banners.index');
        } catch (\Exception $exception) {
            DB::rollback();
            abort(500);
        }
    }

    public function storeSecondSection(StoreBennerRequest $request)
    {
        $input = $request->all();
        //upload new file
        if ($request->file('imgAr'))
            $imgAr =  UploadFile::UploadSinglelFile($request->file('imgAr'), 'banners');
        else
            $imgAr = null;

        if ($request->file('imgEn'))
            $imgEn =  UploadFile::UploadSinglelFile($request->file('imgEn'), 'banners');
        else
            $imgEn = null;

        //upload new file
        if ($request->file('mobileimgAr'))
            $mob_imgAR =  UploadFile::UploadSinglelFile($request->file('mobileimgAr'), 'banners');
        else
            $mob_imgAR = null;

        if ($request->file('mobileimgEn'))
            $mob_imgEn =  UploadFile::UploadSinglelFile($request->file('mobileimgEn'), 'banners');
        else
            $mob_imgEn = null;

        DB::beginTransaction();
        try {
            Banner::create([
                /* 'img'    => $img,
                'mobileimg' => $mob_img, */
                // 'url'    => $input['url'], 
                'section' => 2,
                'en' => [
                    'alt'       => $input['altEN'],
                    'img'       => $imgEn,
                    'mobileimg' => $mob_imgEn,
                    'url'       => $nput['urlEN'],
                ],
                'ar' => [
                    'alt'       => $input['altAR'],
                    'img'       => $imgAr,
                    'mobileimg' => $mob_imgAR,
                    'url'       => $nput['urlAR'],
                ],
            ]);
            DB::commit();
            session()->flash('_added', 'Banner has been created succssfuly');
            return redirect()->route('banners.index');
        } catch (\Exception $exception) {
            DB::rollback();
            abort(500);
        }
    }

    public function storeThirdSection(StoreBennerRequest $request)
    {
        $input = $request->all();
        //upload new file
        if ($request->file('imgAr'))
            $imgAr =  UploadFile::UploadSinglelFile($request->file('imgAr'), 'banners');
        else
            $imgAr = null;

        if ($request->file('imgEn'))
            $imgEn =  UploadFile::UploadSinglelFile($request->file('imgEn'), 'banners');
        else
            $imgEn = null;

        //upload new file
        if ($request->file('mobileimgAr'))
            $mob_imgAR =  UploadFile::UploadSinglelFile($request->file('mobileimgAr'), 'banners');
        else
            $mob_imgAR = null;

        if ($request->file('mobileimgEn'))
            $mob_imgEn =  UploadFile::UploadSinglelFile($request->file('mobileimgEn'), 'banners');
        else
            $mob_imgEn = null;

        DB::beginTransaction();
        try {
            Banner::create([
                /* 'img'    => $img,
                'mobileimg' => $mob_img, */
                // 'url'    => $input['url'], 
                'section' => 3,
                'en' => [
                    'alt'       => $input['altEN'],
                    'img'       => $imgEn,
                    'mobileimg' => $mob_imgEn,
                    'url'       => $nput['urlEN'],
                ],
                'ar' => [
                    'alt'       => $input['altAR'],
                    'img'       => $imgAr,
                    'mobileimg' => $mob_imgAR,
                    'url'       => $nput['urlAR'],
                ],
            ]);
            DB::commit();
            session()->flash('_added', 'Banner has been created succssfuly');
            return redirect()->route('banners.index');
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
        $banner    = Banner::findOrFail($id);
        $MainTitle = 'Banners';
        $SubTitle  = 'Edit';
        return view('Admin._banners.edit', compact('MainTitle', 'SubTitle', 'banner'));
    }

    /**
     * Update the specified resource in storage.
     *
     */
   public function update(UpdateBennerRequest $request, $id)
    {
        $banner = Banner::findOrFail($id);
        $input = $request->all();
        //upload new file
        if ($request->file('image_ar')) {
            //Remove old file
            UploadFile::RemoveFile($banner->translate('ar')->img);
            $img_ar =  UploadFile::UploadSinglelFile($request->file('image_ar'), 'banners');
        } else {
            $img_ar = $banner->translate('ar')->img;
        }

        if ($request->file('image_en')) {
            //Remove old file
            UploadFile::RemoveFile($banner->translate('en')->img);
            $img_en =  UploadFile::UploadSinglelFile($request->file('image_en'), 'banners');
        } else {
            $img_en = $banner->translate('en')->img;
        }


        //upload new file
        if ($request->file('mobile_image_ar')) {
            //Remove old file
            UploadFile::RemoveFile($banner->translate('ar')->mobileimg);
            $mob_img_ar =  UploadFile::UploadSinglelFile($request->file('mobile_image_ar'), 'banners');
        } else {
            $mob_img_ar = $banner->translate('en')->mobileimg;
        }

        //upload new file
        if ($request->file('mobile_image_en')) {
            //Remove old file
            UploadFile::RemoveFile($banner->translate('en')->mobileimg);
            $mob_img_en =  UploadFile::UploadSinglelFile($request->file('mobile_image_en'), 'banners');
        } else {
            $mob_img_en = $banner->translate('en')->mobileimg;
        }
        
        DB::beginTransaction();
        try {
            $banner->translate('ar')->img  = $img_ar;
            $banner->translate('en')->img  = $img_en;
            $banner->translate('ar')->mobileimg  = $mob_img_ar;
            $banner->translate('en')->mobileimg  = $mob_img_en;
            $request->section !== null ? $banner->section  = $input['section'] : $banner->section ;
            $banner->translate('en')->url = $input['urlEN'];
            $banner->translate('ar')->url = $input['urlAR'];
            $banner->translate('en')->alt  = $input['altEN'];
            $banner->translate('ar')->alt  = $input['altAR'];
            $banner->save();
            DB::commit();
            session()->flash('_updated', 'Banner data has been updated succssfuly');
            return redirect()->back();
        } catch (\Exception $exception) {
            dd($exception);
            DB::rollback();
            abort(500);
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function ads()
    {
        $MainTitle = 'Banners';
        $SubTitle  = 'Control Ads';
        $AdBanner  = AdBanner::first();
        if ($AdBanner)
            return view('Admin._banners.EditAds', compact('MainTitle', 'SubTitle', 'AdBanner'));
        return view('Admin._banners.ads', compact('MainTitle', 'SubTitle'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function adsStore(AdsBannerRequest $request)
    {
        $input = $request->all();
        if ($request->file('firstImage_en'))
            $firstImage_en =  UploadFile::UploadSinglelFile($request->file('firstImage_en'), 'banners');
        else
            $firstImage_en = '-';
        if ($request->file('firstImage_ar'))
            $firstImage_ar =  UploadFile::UploadSinglelFile($request->file('firstImage_ar'), 'banners');
        else
            if ($request->file('mobileFirstImage_en'))
            $mobileFirstImage_en =  UploadFile::UploadSinglelFile($request->file('mobileFirstImage_en'), 'banners');
        else
            $mobileFirstImage_en = '-';
        if ($request->file('mobileFirstImage_ar'))
            $mobileFirstImage_ar =  UploadFile::UploadSinglelFile($request->file('mobileFirstImage_ar'), 'banners');
        else
            $mobileFirstImage_ar = '-';

        if ($request->file('mobileSecondImage_en'))
            $mobileSecondImage_en =  UploadFile::UploadSinglelFile($request->file('mobileSecondImage_en'), 'banners');
        else
            $mobileSecondImage_en = '-';
        if ($request->file('mobileSecondImage_ar'))
            $mobileSecondImage_ar =  UploadFile::UploadSinglelFile($request->file('mobileSecondImage_ar'), 'banners');
        else
            $mobileSecondImage_ar = '-';
        if ($request->file('secondImage_en'))
            $secondImage_en =  UploadFile::UploadSinglelFile($request->file('secondImage_en'), 'banners');
        else
            $secondImage_en = '-';
        if ($request->file('secondImage_ar'))
            $secondImage_ar =  UploadFile::UploadSinglelFile($request->file('secondImage_ar'), 'banners');
        else
            $secondImage_ar = '-';
        DB::beginTransaction();
        try {
            AdBanner::create([
                'firstURL' => $input['firstURL'],
                'secondURL' => $input['secondURL'],
                'en' => [
                    'firstImage'   => $firstImage_en,
                    'secondImage'   => $secondImage_en,
                    'mobileFirstImage'   => $mobileFirstImage_en,
                    'mobileSecondImage'   => $mobileSecondImage_en,
                    'firstImageAlt'       => $input['firstImageAlt_en'],
                    'secondImageAlt'      => $input['secondImageAlt_en'],
                ],
                'ar' => [
                    'firstImage'   => $firstImage_ar,
                    'secondImage'   => $secondImage_ar,
                    'mobileFirstImage'   => $mobileFirstImage_ar,
                    'mobileSecondImage'   => $mobileSecondImage_ar,
                    'firstImageAlt'       => $input['firstImageAlt_ar'],
                    'secondImageAlt'      => $input['secondImageAlt_ar'],
                ],
            ]);
            DB::commit();
            session()->flash('_added', 'Banner Ads section saved Succssfuly');
            return back();
        } catch (\Exception $exception) {
            DB::rollback();
            abort(500);
        }
    }
    /**
     * Update the specified resource in storage.
     *
     */
    public function adsUpdate(AdsBannerRequest $request, $id)
    {
        $ad = AdBanner::findOrFail($id);
        $input = $request->all();
        //upload new file
        if ($request->file('firstImage_en')) {
            //Remove old file
            UploadFile::RemoveFile($ad->translate('en')->firstImage);
            $firstImage_en =  UploadFile::UploadSinglelFile($request->file('firstImage_en'), 'banners');
        } else
            $firstImage_en = $ad->translate('en')->firstImage;
        if ($request->file('firstImage_ar')) {
            //Remove old file
            UploadFile::RemoveFile($ad->translate('ar')->firstImage);
            $firstImage_ar =  UploadFile::UploadSinglelFile($request->file('firstImage_ar'), 'banners');
        } else
            $firstImage_ar = $ad->translate('ar')->firstImage;







        //upload new file
        if ($request->file('mobileFirstImage_en')) {
            //Remove old file
            UploadFile::RemoveFile($ad->translate('en')->mobileFirstImage);
            $mobileFirstImage_en =  UploadFile::UploadSinglelFile($request->file('mobileFirstImage_en'), 'banners');
        } else
            $mobileFirstImage_en = $ad->translate('en')->mobileFirstImage;
        if ($request->file('mobileFirstImage_ar')) {
            //Remove old file
            UploadFile::RemoveFile($ad->translate('ar')->mobileFirstImage);
            $mobileFirstImage_ar =  UploadFile::UploadSinglelFile($request->file('mobileFirstImage_ar'), 'banners');
        } else
            $mobileFirstImage_ar = $ad->translate('ar')->mobileFirstImage;




        //upload new file
        if ($request->file('mobileSecondImage_en')) {
            //Remove old file
            UploadFile::RemoveFile($ad->translate('en')->mobileSecondImage);
            $mobileSecondImage_en =  UploadFile::UploadSinglelFile($request->file('mobileSecondImage_en'), 'banners');
        } else
            $mobileSecondImage_en = $ad->translate('en')->mobileSecondImage;
        if ($request->file('mobileSecondImage_ar')) {
            //Remove old file
            UploadFile::RemoveFile($ad->translate('ar')->mobileSecondImage);
            $mobileSecondImage_ar =  UploadFile::UploadSinglelFile($request->file('mobileSecondImage_ar'), 'banners');
        } else
            $mobileSecondImage_ar = $ad->translate('ar')->mobileSecondImage;







        //upload new file
        if ($request->file('secondImage_en')) {
            //Remove old file
            UploadFile::RemoveFile($ad->translate('en')->secondImage);
            $secondImage_en =  UploadFile::UploadSinglelFile($request->file('secondImage_en'), 'banners');
        } else
            $secondImage_en = $ad->translate('en')->secondImage;
        if ($request->file('secondImage_ar')) {
            //Remove old file
            UploadFile::RemoveFile($ad->translate('ar')->secondImage);
            $secondImage_ar =  UploadFile::UploadSinglelFile($request->file('secondImage_ar'), 'banners');
        } else
            $secondImage_ar = $ad->translate('ar')->secondImage;
        DB::beginTransaction();
        try {
            $ad->firstURL  = $input['firstURL'];
            $ad->secondURL  = $input['secondURL'];
            $ad->translate('en')->firstImage  = $firstImage_en;
            $ad->translate('ar')->firstImage  = $firstImage_ar;

            $ad->translate('en')->mobileFirstImage  = $mobileFirstImage_en;
            $ad->translate('ar')->mobileFirstImage  = $mobileFirstImage_ar;


            $ad->translate('en')->secondImage  = $secondImage_en;
            $ad->translate('ar')->secondImage  = $secondImage_ar;


            $ad->translate('en')->mobileSecondImage  = $mobileSecondImage_en;
            $ad->translate('ar')->mobileSecondImage  = $mobileSecondImage_ar;


            $ad->translate('en')->firstImageAlt  = $input['firstImageAlt_en'];
            $ad->translate('ar')->firstImageAlt  = $input['firstImageAlt_ar'];
            $ad->translate('en')->secondImageAlt  = $input['secondImageAlt_en'];
            $ad->translate('ar')->secondImageAlt  = $input['secondImageAlt_ar'];
            $ad->save();
            DB::commit();
            session()->flash('_updated', 'Banner Ads data has been updated succssfuly');
            return back();
        } catch (\Exception $exception) {
            DB::rollback();
            abort(500);
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $banner = Banner::find($id);
        //Remove old file
        if ($banner->img)
            UploadFile::RemoveFile($banner->img);
        if ($banner->mobileimg)
            UploadFile::RemoveFile($banner->mobileimg);
        $banner->delete();
        return response()->json(['success' => 'Data is successfully deleted']);
    }
}
