<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanyRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Models\Company;
use App\Http\Requests\Admin\StoreCompanyRequest;
use App\Http\Requests\Admin\UpdateCompanyRequest;
use App\Models\CompanySubscription;
use App\Models\Subscription;
use App\Helpers\UploadFile;
use Illuminate\Support\Facades\DB;
use Auth;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subscribedCompanies = CompanySubscription::pluck('company_id')->all();
        $companiesWithSubscrip = Company::whereNotIn('id', $subscribedCompanies)->get();
        $subscriptions = Subscription::where('visibility', 1)->get();
        $companies = Company::all();
        $MainTitle = 'Companies';
        $SubTitle = 'View';
        return view('Admin._companies.index', compact('MainTitle', 'SubTitle', 'companies', 'subscribedCompanies', 'companiesWithSubscrip', 'subscriptions'));
    }

    public function joins()
    {
        $MainTitle = 'Companies';
        $SubTitle = 'Join requests';
        $requests = CompanyRequest::all();
        //return $requests;
        return view('Admin._companies.joins', compact('MainTitle', 'SubTitle', 'requests'));
    }

    /**
     * Display a listing of the resource in DT.
     */
    public function companies(Request $request)
    {
        $records = Company::with('subscriptions')->when($request->input('start_date') && $request->input('end_date'), function ($query) use ($request) {
            $query->whereBetween('created_at', [Carbon::parse($request->start_date), Carbon::parse($request->end_date)]);
        })->orderBy('created_at','desc')->get();
        return Datatables::of($records)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $MainTitle = 'Companies';
        $SubTitle = 'Add';
        return view('Admin._companies.create', compact('MainTitle', 'SubTitle'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompanyRequest $request)
    {
        $input = $request->all();

        //upload new logo
        if ($request->file('cover'))
            $cover = UploadFile::UploadSinglelFile($request->file('cover'), 'companies');
        else
            $cover = '';

        if ($request->file('mobilecover'))
            $mob_cover = UploadFile::UploadSinglelFile($request->file('mobilecover'), 'companies');
        else
            $mob_cover = '';
        //upload new logo
        if ($request->file('logo'))
            $logo = UploadFile::UploadSinglelFile($request->file('logo'), 'companies');
        else
            $logo = '';
        //upload new brochure
        if ($request->file('brochure'))
            $brochure = UploadFile::UploadSinglelFile($request->file('brochure'), 'companies');
        else
            $brochure = '';
        //upload new price_lists
        if ($request->file('price_lists'))
            $price_lists = UploadFile::UploadSinglelFile($request->file('price_lists'), 'companies');
        else
            $price_lists = '';
        DB::beginTransaction();


        try {
            Company::create([
                'cover' => $cover,
                'mobileCover' => $mob_cover,
                'logo' => $logo,
                'brochure' => $brochure,
                'price_lists' => $price_lists,
                'date' => $input['date'],
                'sales_mobile' => $input['sales_mobile'],
                'company_phone' => $input['company_phone'],
                'company_email' => $input['company_email'],
                'map' => $input['map'],
                'facebook' => $input['facebook'],
                'insta' => $input['insta'],
                'twitter' => $input['twitter'],
                'youtube' => $input['youtube'],
                'linkedin' => $input['linkedin'],
                'pri_contact_name' => $input['pri_contact_name'],
                'pri_contact_phone' => $input['pri_contact_phone'],
                'pri_contact_email' => $input['pri_contact_email'],
                'en' => [
                    'name' => $input['name_en'],
                    'title' => $input['title_en'],
                    'alt' => $input['alt_en'],
                    'address' => $input['company_address_en'],
                    'description' => $input['descri_en'],
                    'description_meta' => $input['descri_meta_en'],
                    'keywords_meta' => $input['keyword_meta_en'],
                    'keywords' => $input['keyword_en'],
                    'products_title' => $input['products_title_en'],
                    'products_description' => $input['products_description_en'],
                    'products_keywords' => $input['products_keywords_en'],

                ],
                'ar' => [
                    'name' => $input['name_ar'],
                    'title' => $input['title_ar'],
                    'alt' => $input['alt_ar'],
                    'address' => $input['company_address_ar'],
                    'description' => $input['descri_ar'],
                    'description_meta' => $input['descri_meta_ar'],
                    'keywords_meta' => $input['keyword_meta_ar'],
                    'keywords' => $input['keyword_ar'],
                    'products_title' => $input['products_title_ar'],
                    'products_description' => $input['products_description_ar'],
                    'products_keywords' => $input['products_keywords_ar'],
                ],
            ]);
            DB::commit();
            session()->flash('_added', 'Company data has been created succssfuly');
            return redirect()->route('companies.index');
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
        $MainTitle = 'Companies';
        $SubTitle = 'Edit';
        $company = Company::findOrFail($id);
        return view('Admin._companies.edit', compact('MainTitle', 'SubTitle', 'company'));
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(UpdateCompanyRequest $request, $id)
    {
        $company = Company::findOrFail($id);
        $input = $request->all();
        //upload cover file
        if ($request->file('cover')) {
            if ($company->cover) {
                //Remove old cover file
                UploadFile::RemoveFile($company->cover);
            }
            $cover = UploadFile::UploadSinglelFile($request->file('cover'), 'companies');
        } else
            $cover = $company->cover;


        //upload cover file
        if ($request->file('mobilecover')) {
            if ($company->mobileCover) {
                //Remove old cover file
                UploadFile::RemoveFile($company->mobileCover);
            }
            $mob_cover = UploadFile::UploadSinglelFile($request->file('mobilecover'), 'companies');
        } else
            $mob_cover = $company->mobileCover;
        //upload logo file
        if ($request->file('logo')) {
            if ($company->logo) {
                //Remove old logo file
                UploadFile::RemoveFile($company->logo);
            }
            $logo = UploadFile::UploadSinglelFile($request->file('logo'), 'companies');
        } else
            $logo = $company->logo;

        //upload brochure file
        if ($request->file('brochure')) {
            if ($company->brochure) {
                //Remove old brochure file
                UploadFile::RemoveFile($company->brochure);
            }
            $brochure = UploadFile::UploadSinglelFile($request->file('brochure'), 'companies');
        } else
            $brochure = $company->brochure;


        //upload price_lists file
        if ($request->file('price_lists')) {
            if ($company->price_lists) {
                //Remove old brochure file
                UploadFile::RemoveFile($company->price_lists);
            }
            $price_lists = UploadFile::UploadSinglelFile($request->file('price_lists'), 'companies');
        } else
            $price_lists = $company->price_lists;

        DB::beginTransaction();
        try {
            $company->logo = $logo;
            $company->cover = $cover;
            $company->mobileCover = $mob_cover;
            $company->brochure = $brochure;
            $company->price_lists = $price_lists;
            $company->date = $input['date'];
            $company->sales_mobile = $input['sales_mobile'];
            $company->company_phone = $input['company_phone'];
            $company->company_email = $input['company_email'];
            $company->map = $input['map'];
            $company->facebook = $input['facebook'];
            $company->insta = $input['insta'];
            $company->twitter = $input['twitter'];
            $company->youtube = $input['youtube'];
            $company->linkedin = $input['linkedin'];
            $company->pri_contact_name = $input['pri_contact_name'];
            $company->pri_contact_phone = $input['pri_contact_phone'];
            $company->pri_contact_email = $input['pri_contact_email'];
            $company->translate('en')->name = $input['name_en'];
            $company->translate('ar')->name = $input['name_ar'];
            $company->translate('en')->title = $input['title_en'];
            $company->translate('ar')->title = $input['title_ar'];
            $company->translate('en')->alt = $input['alt_en'];
            $company->translate('ar')->alt = $input['alt_ar'];
            $company->translate('en')->address = $input['company_address_en'];
            $company->translate('ar')->address = $input['company_address_ar'];
            $company->translate('en')->description = $input['descri_en'];
            $company->translate('ar')->description = $input['descri_ar'];
            $company->translate('en')->description_meta = $input['descri_meta_en'];
            $company->translate('ar')->description_meta = $input['descri_meta_ar'];
            $company->translate('en')->keywords_meta = $input['keyword_meta_en'];
            $company->translate('ar')->keywords_meta = $input['keyword_meta_ar'];
            $company->translate('en')->keywords = $input['keyword_en'];
            $company->translate('ar')->keywords = $input['keyword_ar'];
            $company->translate('en')->products_title = $input['products_title_en'];
            $company->translate('ar')->products_title = $input['products_title_ar'];
            $company->translate('en')->products_description = $input['products_description_en'];
            $company->translate('ar')->products_description = $input['products_description_ar'];
            $company->translate('en')->products_keywords = $input['products_keywords_en'];
            $company->translate('ar')->products_keywords = $input['products_keywords_ar'];
            $company->save();
            DB::commit();
            session()->flash('_updated', 'Company data has been updated succssfuly');
            return back();
        } catch (\Exception $exception) {
            DB::rollback();
            abort(500);
        }
    }
    //

    /**
     * Update company password
     */
    public function updatePassword(Request $request)
    {
        $password = bcrypt($request->password);
        Company::where('id', $request->id)->update(['password' => $password]);
        return response()->json(['success' => 'password successfully updated', 'id' => $request->id]);
    }
    //

    /**
     * show/hide company
     */
    public function ShowHideCompany($id)
    {
        $company = Company::findOrFail($id);
        $hidden = 1;
        if ($company->hidden) {
            $hidden = 0;
        }
        Company::where('id', $id)->update(['hidden' => $hidden]);
        return response()->json(['success' => 'Company updated', 'id' => $id, 'hidden' => $hidden]);
    }
    //

    /**
     * make company as a gold supplier
     */
    public function GoldCompany($id)
    {
        $company = Company::findOrFail($id);
        $gold_sup = 1;
        if ($company->gold_sup) {
            $gold_sup = 0;
        }
        Company::where('id', $id)->update(['gold_sup' => $gold_sup]);
        return response()->json(['success' => 'Company updated', 'id' => $id, 'gold_sup' => $gold_sup]);
    }
    //
    /**
     *login as company from admin panel
     */
    //
    public function login($id)
    {
        $Company = Company::findOrFail($id);
        if ($Company) {
            Auth::guard('company')->login($Company);
            return redirect()->route('company.home');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $company = Company::findOrFail($id);
        //Remove old logo file
        if ($company->logo)
            UploadFile::RemoveFile($company->logo);
        //Remove old brochure file
        if ($company->brochure)
            UploadFile::RemoveFile($company->brochure);
        //Remove old price_lists file
        if ($company->price_lists)
            UploadFile::RemoveFile($company->price_lists);
        $company->delete();
        return response()->json(['success' => 'Data is successfully deleted']);
    }

    /**
     * Mak company featured in home page
     */
    public function makeFeatured($id)
    {
        $company = Company::findOrFail($id);
        DB::beginTransaction();
        try {
            if ($company->feature) {
                $company->feature = 0;
                $company->save();
                DB::commit();
                return response()->json(['id' => $id, 'featured' => $company->feature, 'success' => 'Company has been removed from featured.']);
            } else {
                $company->feature = 1;
                $company->save();
                DB::commit();
                return response()->json(['id' => $id, 'featured' => $company->feature, 'success' => 'Company has been added as featured.']);
            }
        } catch (\Exception $exception) {
            DB::rollback();
            abort(500);
        }
    }

    //update rank point
    public function RankPoint(Request $request)
    {
        $company = Company::findOrFail($request->id);
        DB::beginTransaction();
        try {
            $company->rank = $request->rank;
            $company->save();
            DB::commit();
            session()->flash('_updated', 'Rank point updated successfully to ' . $company->name);
            return back();
        } catch (\Exception $exception) {
            DB::rollback();
            abort(500);
        }
    }
}
