<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Product;
use App\Models\ViewInformation;
use App\Models\GeneralRfq;
use App\Models\PdfDownload;
use App\Models\CompanySubscription;
use App\Models\Subscription;
use App\Models\CallbackRequest;
use App\Http\Requests\Company\SettingsRequest;
use App\Models\SubscriptionHistory;
use Illuminate\Support\Facades\DB;
use App\Helpers\UploadFile;
class CompanyController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if(CompanyID()==$id) {
            $company   = Company::findOrFail($id);
            $MainTitle = 'Company Data';
          $SubTitle = 'Edit';
            return view('Company._companies.edit',compact('MainTitle','SubTitle','company'));
        }
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(SettingsRequest $request, $id)
    {
       // return $request->all();
        $input   = $request->all();
        //return $input;
        $company = Company::findOrFail($id);
        //upload cover file
        if ($request->file('cover'))
        {
           if ($company->cover) {
            //Remove old cover file
            UploadFile::RemoveFile($company->cover);
          }
            $cover =  UploadFile::UploadSinglelFile($request->file('cover'),'companies');
        }
        else
            $cover = $company->cover;
        //upload logo file
        if ($request->file('logo'))
        {
            //Remove old logo file
            UploadFile::RemoveFile($company->logo);
            $logo =  UploadFile::UploadSinglelFile($request->file('logo'),'companies');
        }
        else
            $logo = $company->logo;

        //upload brochure file
        if ($request->file('brochure'))
        {
            if ($company->brochure) {
                //Remove old brochure file
                UploadFile::RemoveFile($company->brochure);
            }
            $brochure =  UploadFile::UploadSinglelFile($request->file('brochure'),'companies');
        }
        else
            $brochure = $company->brochure;


        //upload price_lists file
        if ($request->file('price_lists'))
        {
             if ($company->price_lists) {
                //Remove old brochure file
                UploadFile::RemoveFile($company->price_lists);
            }
            $price_lists =  UploadFile::UploadSinglelFile($request->file('price_lists'),'companies');
        }
        else
            $price_lists = $company->price_lists;


        //return $input;
        DB::beginTransaction();
        try {
            $company->logo               =  $logo;
            $company->cover              =  $cover;
            $company->brochure           =  $brochure;
            $company->price_lists        =  $price_lists;
            $company->date               =  $input['date'];
            $company->sales_mobile       =  $input['sales_mobile'];
            $company->company_phone      =  $input['company_phone'];
           $company->whatsup_number      =  $input['whatsup_number'];
            $company->company_email      =  $input['company_email'];
            $company->map                =  $input['map'];
            $company->facebook           =  $input['facebook'];
            $company->insta              =  $input['insta'];
            $company->twitter            =  $input['twitter'];
            $company->youtube            =  $input['youtube'];
            $company->linkedin           =  $input['linkedin'];
            $company->pri_contact_name   =  $input['pri_contact_name'];
            $company->pri_contact_phone  =  $input['pri_contact_phone'];
            $company->pri_contact_email  =  $input['pri_contact_email'];
            $company->translate('en')->name             = $input['name_en'];
            $company->translate('ar')->name             = $input['name_ar'];
            $company->translate('en')->title            = $input['title_en'];
            $company->translate('ar')->title            = $input['title_ar'];
            $company->translate('en')->alt              = $input['alt_en'];
            $company->translate('ar')->alt              = $input['alt_ar'];
            $company->translate('en')->address          = $input['company_address_en'];
            $company->translate('ar')->address          = $input['company_address_ar'];
            $company->translate('en')->description      = $input['descri_en'];
            $company->translate('ar')->description      = $input['descri_ar'];
            $company->translate('en')->description_meta = $input['descri_meta_en'];
            $company->translate('ar')->description_meta = $input['descri_meta_ar'];
            $company->translate('en')->keywords_meta    = $input['keyword_meta_en'];
            $company->translate('ar')->keywords_meta    = $input['keyword_meta_ar'];
            $company->translate('en')->keywords         = $input['keyword_en'];
            $company->translate('ar')->keywords         = $input['keyword_ar'];
            $company->save();
            DB::commit();
            session()->flash('_updated','data updated succssfuly');
            return back();
        }catch (\Exception $exception)
        {
            DB::rollback();
            abort(500);
        }
    }
   /**
     * Show the table of subscription details.
     *
     */
    public function subscription(){
        $subscription=CompanySubscription::with(['subscription'])->where('company_id',auth('company')->user()->id)->orderBy('created_at','desc')->first();
        $subscriptions=Subscription::where('visibility',1)->get();
        return view('Company._subscriptions.index',compact('subscription','subscriptions'));
    }
   /**
     * renew subscription of company.
     *
     */
    public function renewSubscription(){
        DB::beginTransaction();
        try {
            $company_subscription=CompanySubscription::with('subscription')->where('company_id',auth('company')->user()->id)->where('end_date','<=',\Carbon\Carbon::now()->addMonth())->firstOrFail();
            if($company_subscription->subscription->visibility){
                $company_subscription->pending=2;
                $company_subscription->save();
                DB::commit();
                session()->flash('_updated','Your subscription request sent to the admin successfully');
                return back();
            }
            else{
                session()->flash('error','Your subscription is not visible right now contact admin for more details');
                return back();
            }
        }catch (\Exception $exception)
        {
            DB::rollback();
            return abort(404);
        }
    }
    /**
     * new subscription of company.
     *
     */
    public function newSubscription($id){
        DB::beginTransaction();
        try {
        $subscription=Subscription::where('visibility',1)->where('id',$id)->firstOrFail();
        if(CompanySubscription::where('company_id',auth('company')->user()->id)->where('pending',1)->first()){
            session()->flash('error','You already have sent a subscription request to souqkahrba.com !');
            return back();            
        }
        $company_subscription=CompanySubscription::where('company_id',auth('company')->user()->id)->where('end_date','<',\Carbon\Carbon::now())->first();
        if(empty($company_subscription)){
            $company_subscription=new CompanySubscription();
            $company_subscription->company_id=auth('company')->user()->id;
            $company_subscription->subscription_id=$subscription->id;

        }else{
            $history=new SubscriptionHistory();
            $history->subscription_id=$company_subscription->subscription_id;
            $history->company_id=$company_subscription->company_id;
            $history->start_date=$company_subscription->start_date;
            $history->end_date=$company_subscription->end_date;
            $history->durationInMonth=$company_subscription->durationInMonth;
            $history->price=$company_subscription->price;
            $history->rank_points=$company_subscription->rank_points;
            $history->save();
        }
        $company_subscription->pending=1;
        $company_subscription->subscription_id=$subscription->id;
        $company_subscription->start_date=\Carbon\Carbon::now();
        $company_subscription->durationInMonth=$subscription->durationInMonth;
        $company_subscription->end_date=\Carbon\Carbon::parse($company_subscription->start_date)->addMonths($subscription->durationInMonth);
        $company_subscription->rank_points=$subscription->rank_points;
        $company_subscription->price=$subscription->price;
        $company_subscription->save();
        DB::commit();
        session()->flash('_updated','Your subscription request sent to the admin successfully');
        return back();
        }catch (\Exception $exception)
        {
            DB::rollback();
            return abort(404);
        }
    }
}
