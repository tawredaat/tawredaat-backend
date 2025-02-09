<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\UploadFile;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SettingsRequest;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $setting = Setting::first();
        if ($setting) {
            $MainTitle = 'Settings';
            $SubTitle = 'Edit';
            return view('Admin._settings.edit', compact('MainTitle', 'SubTitle', 'setting'));
        }
        $MainTitle = 'Settings';
        $SubTitle = 'Create';
        return view('Admin._settings.create', compact('MainTitle', 'SubTitle'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SettingsRequest $request)
    {
        $input = $request->all();
        if ($request->file('logo_en')) {
            $logo = UploadFile::UploadSinglelFile($request->file('logo_en'), 'siteSettings');
        } else {
            $logo = '-';
        }

        if ($request->file('logo_ar')) {
            $logoAr = UploadFile::UploadSinglelFile($request->file('logo_ar'), 'siteSettings');
        } else {
            $logoAr = $logo;
        }

        if ($request->file('favicon')) {
            $favicon = UploadFile::UploadSinglelFile($request->file('favicon'), 'siteSettings');
        } else {
            $favicon = '-';
        }

        if ($request->file('rfq_image_en')) {
            $rfq_image_en = UploadFile::UploadSinglelFile($request->file('rfq_image_en'), 'siteSettings');
        } else {
            $rfq_image_en = '-';
        }

        if ($request->file('rfq_image_ar')) {
            $rfq_image_ar = UploadFile::UploadSinglelFile($request->file('rfq_image_ar'), 'siteSettings');
        } else {
            $rfq_image_ar = $rfq_image_en;
        }

        if ($request->file('site_logo_en')) {
            $site_logo = UploadFile::UploadSinglelFile($request->file('site_logo_en'), 'siteSettings');
        } else {
            $site_logo = '-';
        }

        if ($request->file('site_logo_ar')) {
            $siteLogoAr = UploadFile::UploadSinglelFile($request->file('site_logo_ar'), 'siteSettings');
        } else {
            $siteLogoAr = $site_logo;
        }

        if ($request->file('footer_logo_en')) {
            $footer_logo = UploadFile::UploadSinglelFile($request->file('footer_logo_en'), 'siteSettings');
        } else {
            $footer_logo = '-';
        }

        if ($request->file('footer_logo_ar')) {
            $footerLogoAr = UploadFile::UploadSinglelFile($request->file('footer_logo_ar'), 'siteSettings');
        } else {
            $footerLogoAr = $footer_logo;
        }

        if ($request->file('brand_store_banner')) {
            $brand_store_banner = UploadFile::UploadSinglelFile($request->file('brand_store_banner'),
                'siteSettings');
        } else {
            $brand_store_banner = null;
        }

        DB::beginTransaction();
        try {
            Setting::create([
                'free_shipping_amount' => $input['free_shipping_amount'],
              	'minimum_order_amount' => $input['minimum_order_amount'],
                'email' => $input['email'],
                'logo' => $logo,
                'favicon' => $favicon,
                'site_logo' => $site_logo,
                'footer_logo' => $footer_logo,
                'brand_store_banner' => $brand_store_banner,
                'phone' => $input['phone'],
                'fax' => $input['fax'],
                'facebook' => $input['facebook'],
                'insta' => $input['insta'],
                'youtube' => $input['youtube'],
                'linkedin' => $input['linkedin'],
                'twitter' => $input['twitter'],

                'en' => [
                    'logo' => $logo,
                    'rfq_image' => $rfq_image_en,
                    'site_logo' => $site_logo,
                    'footer_logo' => $footer_logo,
                    'description' => $input['description_en'],
                    'address' => $input['address_en'],
                    'logo_alt' => $input['alt_en'],
                    'title' => $input['title_en'],
                    'footerLogoAlt' => $input['footerLogoAlt_en'],
                    'siteLogoAlt' => $input['siteLogoAlt_en'],
                    'keywords' => $input['keywords_en'],
                    'Meta_Description' => $input['Meta_Description_en'],
                    'rfq_banner' => $request->file('rfq_banner_en') ? UploadFile::UploadSinglelFile($request->file('rfq_banner_en'), 'siteSettings') : null,
                ],
                'ar' => [
                    'logo' => $logoAr,
                    'rfq_image' => $rfq_image_ar,
                    'site_logo' => $siteLogoAr,
                    'footer_logo' => $footerLogoAr,
                    'description' => $input['description_ar'],
                    'address' => $input['address_ar'],
                    'logo_alt' => $input['alt_ar'],
                    'title' => $input['title_ar'],
                    'footerLogoAlt' => $input['footerLogoAlt_ar'],
                    'siteLogoAlt' => $input['siteLogoAlt_ar'],
                    'keywords' => $input['keywords_ar'],
                    'Meta_Description' => $input['Meta_Description_ar'],
                    'rfq_banner' => $request->file('rfq_banner_ar') ? UploadFile::UploadSinglelFile($request->file('rfq_banner_ar'), 'siteSettings') : null,

                ],
            ]);
            DB::commit();
            session()->flash('_added', 'Website settings has been saved Succssfuly');
            return back();
        } catch (\Exception $exception) {
            DB::rollback();
            abort(500);
        }

    }

    /**
     * update a resource in storage.
     */
    public function update(SettingsRequest $request, $id)
    {
        $input = $request->all();
        $setting = Setting::findOrFail($id);
        DB::beginTransaction();

        try {
            if ($request->file('logo_en')) {
                // remove old file
                if ($setting->translate('en')->logo &&
                    $setting->logo != $setting->translate('en')->logo) {
                    UploadFile::RemoveFile($setting->translate('en')->logo);
                }
                $setting->translate('en')->logo =
                UploadFile::UploadSinglelFile($request->file('logo_en'), 'siteSettings');
            }

            if ($request->file('logo_ar')) {
                // remove old file
                if ($setting->translate('ar')->logo && $setting->logo != $setting->translate('ar')->logo) {
                    UploadFile::RemoveFile($setting->translate('ar')->logo);
                }
                $setting->translate('ar')->logo =
                UploadFile::UploadSinglelFile($request->file('logo_ar'), 'siteSettings');
            }

            //upload new file
            if ($request->file('rfq_image_en')) {
                // remove old file
                if ($setting->rfq_image) {
                    UploadFile::RemoveFile($setting->translate('en')->rfq_image);
                }

                $newRfqImage = UploadFile::UploadSinglelFile($request->file('rfq_image_en'),
                    'siteSettings');
                if ($setting->rfq_image == $setting->translate('ar')->rfq_image) {
                    $setting->translate('ar')->rfq_image = $newRfqImage;
                }

                $setting->translate('en')->rfq_image = $newRfqImage;

            }
            if ($request->file('rfq_image_ar')) {
                // remove old file
                if ($setting->translate('ar')->rfq_image && $setting->rfq_image != $setting->translate('ar')->rfq_image) {
                    UploadFile::RemoveFile($setting->translate('ar')->rfq_image);
                }

                $setting->translate('ar')->rfq_image = UploadFile::UploadSinglelFile($request->file('rfq_image_ar'), 'siteSettings');
            }
            if ($request->file('favicon')) {
                if ($setting->favicon) {
                    UploadFile::RemoveFile($setting->favicon);
                }

                $setting->favicon = UploadFile::UploadSinglelFile($request->file('favicon'), 'siteSettings');

            }

            if ($request->file('site_logo_en')) {
                // remove old file
                if ($setting->site_logo) {
                    UploadFile::RemoveFile($setting->translate('en')->site_logo);
                }

                $newLogo = UploadFile::UploadSinglelFile($request->file('site_logo_en'), 'siteSettings');
                if ($setting->site_logo == $setting->translate('ar')->site_logo) {
                    $setting->translate('ar')->site_logo = $newLogo;
                }

                $setting->translate('en')->site_logo = $newLogo;

            }
            if ($request->file('site_logo_ar')) {
                // remove old file
                if ($setting->translate('ar')->site_logo && $setting->site_logo != $setting->translate('ar')->site_logo) {
                    UploadFile::RemoveFile($setting->translate('ar')->site_logo);
                }

                $setting->translate('ar')->site_logo = UploadFile::UploadSinglelFile($request->file('site_logo_ar'), 'siteSettings');
            }

            if ($request->file('footer_logo_en')) {
                // remove old file
                if ($setting->footer_logo) {
                    UploadFile::RemoveFile($setting->translate('en')->footer_logo);
                }

                $newLogo = UploadFile::UploadSinglelFile($request->file('footer_logo_en'),
                    'siteSettings');
                if ($setting->footer_logo == $setting->translate('ar')->footer_logo) {
                    $setting->translate('ar')->footer_logo = $newLogo;
                }

                $setting->translate('en')->footer_logo = $newLogo;

            }

            if ($request->file('footer_logo_ar')) {
                // remove old file
                if ($setting->translate('ar')->footer_logo && $setting->footer_logo != $setting->translate('ar')->footer_logo) {
                    UploadFile::RemoveFile($setting->translate('ar')->footer_logo);
                }

                $setting->translate('ar')->footer_logo = UploadFile::UploadSinglelFile($request->file('footer_logo_ar'), 'siteSettings');
            }

            if ($request->file('rfq_banner_ar')) {
                if ($setting->translate('ar')->rfq_banner) {
                    UploadFile::RemoveFile($setting->translate('ar')->rfq_banner);
                }

                $setting->translate('ar')->rfq_banner = UploadFile::UploadSinglelFile($request->file('rfq_banner_ar'), 'siteSettings');
            }

            if ($request->file('rfq_banner_en')) {
                if ($setting->translate('en')->rfq_banner) {
                    UploadFile::RemoveFile($setting->translate('en')->rfq_banner);
                }

                $setting->translate('en')->rfq_banner = UploadFile::UploadSinglelFile($request->file('rfq_banner_en'), 'siteSettings');
            }

            if ($request->file('brand_store_banner')) {
                // remove old file
                if ($setting->brand_store_banner &&
                    $setting->brand_store_banner != $setting->brand_store_banner) {
                    UploadFile::RemoveFile($setting->brand_store_banner);
                }
                $setting->brand_store_banner = UploadFile::UploadSinglelFile($request->file('brand_store_banner'), 'siteSettings');
            }

            $setting->free_shipping_amount = $input['free_shipping_amount'];
          	$setting->minimum_order_amount = $input['minimum_order_amount'];
            $setting->email = $input['email'];
            $setting->phone = $input['phone'];
            $setting->fax = $input['fax'];
            $setting->facebook = $input['facebook'];
            $setting->insta = $input['insta'];
            $setting->youtube = $input['youtube'];
            $setting->linkedin = $input['linkedin'];
            $setting->twitter = $input['twitter'];
            $setting->translate('en')->description = $input['description_en'];
            $setting->translate('ar')->description = $input['description_ar'];
            $setting->translate('en')->address = $input['address_en'];
            $setting->translate('ar')->address = $input['address_ar'];
            $setting->translate('en')->logo_alt = $input['alt_en'];
            $setting->translate('ar')->logo_alt = $input['alt_ar'];
            $setting->translate('en')->title = $input['title_en'];
            $setting->translate('ar')->title = $input['title_ar'];
            $setting->translate('en')->footerLogoAlt = $input['footerLogoAlt_en'];
            $setting->translate('ar')->footerLogoAlt = $input['footerLogoAlt_ar'];
            $setting->translate('en')->siteLogoAlt = $input['siteLogoAlt_en'];
            $setting->translate('ar')->siteLogoAlt = $input['siteLogoAlt_ar'];
            $setting->translate('en')->keywords = $input['keywords_en'];
            $setting->translate('ar')->keywords = $input['keywords_ar'];
            $setting->translate('en')->Meta_Description = $input['Meta_Description_en'];
            $setting->translate('ar')->Meta_Description = $input['Meta_Description_ar'];
            $setting->save();

            DB::commit();
            session()->flash('_added', 'Website settings has been saved Succssfuly');
            return back();
        } catch (\Exception $exception) {
            DB::rollback();
            abort(500);
        }
    }

    public function showBrandImage()
    {
        $setting = Setting::first();
        $MainTitle = 'Brand Ads Image';
        $SubTitle = 'Edit image';
        return view('Admin.adsImages.brand', compact('MainTitle', 'SubTitle', 'setting'));

    }

    public function addBrandImage(Request $request)
    {

        $this->validate($request, [
            'brand_image' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:50000',
        ]);
        $setting = Setting::first();

        if ($setting->brand_image) {
            UploadFile::RemoveFile($setting->brand_image);
        }

        $newLogo = UploadFile::UploadSinglelFile($request->file('brand_image'), 'siteSettings');

        $setting->brand_image = $newLogo;
        $setting->save();
        session()->flash('_added', 'Ads Brand Image has been saved Succssfuly');
        return back();

    }

    public function showCompanyImage()
    {
        $setting = Setting::first();
        $MainTitle = 'Company Ads Image';
        $SubTitle = 'Edit image';
        return view('Admin.adsImages.company', compact('MainTitle', 'SubTitle', 'setting'));

    }

    public function addCompanyImage(Request $request)
    {
        $this->validate($request, [
            'company_image' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:50000',
        ]);
        $setting = Setting::first();

        if ($setting->company_image) {
            UploadFile::RemoveFile($setting->company_image);
        }

        $newLogo = UploadFile::UploadSinglelFile($request->file('company_image'), 'siteSettings');

        $setting->company_image = $newLogo;
        $setting->save();
        session()->flash('_added', 'Ads Company Image has been saved Succssfuly');
        return back();

    }

}
