<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SubscriptionRequest;
use App\Models\Company;
use App\Models\CompanySubscription;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use App\Models\Subscription;
use App\Models\SubscriptionHistory;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $MainTitle = 'Subscriptions';
        $SubTitle = 'View';
        return view('Admin._subscriptions.index',compact('MainTitle','SubTitle'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $MainTitle = 'Subscriptions';
        $SubTitle = 'Add';
        return view('Admin._subscriptions.create',compact('MainTitle','SubTitle'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SubscriptionRequest $request)
    {
        $input = $request->all();
        DB::beginTransaction();
        try {
            Subscription::create([
            'durationInMonth' => $input['durationInMonth'],
            'price'           => $input['price'],
            'rank_points'     => $input['rank_points'],
            'visibility'      => $input['visibility'],
            'en'              => [
                                'name' => $input['name_en'],
                              ],
           'ar'              => [
                             'name' => $input['name_ar'],
                            ],
            ]);
            session()->flash('_added','Subscription has been created Successfully');
            DB::commit();
            return redirect()->route('subscriptions.index');
        }catch (\Exception $exception) {
            DB::rollback();
            return abort(500);
        }
    }
    /**
     * Display a listing of the resource in DT.
     */
    public function companies()
    {

        $subscriptionsCompany = CompanySubscription::all();
        return view('Admin._companies.subscriptions',compact('subscriptionsCompany'));
    } 
     /**
     * Show table of subscriptions requests.
     */
    public function requests()
    {
        return view('Admin._companies.subscriptionRequests');
    }        
    /**
     * Display a listing of the resource in DT.
     */
    public function subscriptions()
    {
        $records = Subscription::all();
        return Datatables::of($records)->make(true);
    }
    /**
     * Show table of Companies that expired subscription.
     */
    public function allexpired()
    {
        $records = CompanySubscription::with(['company','subscription'])->where('end_date','<',now()->format('Y-m-d H:i:s'))->get();
        return Datatables::of($records)->make(true);
    }
    /**
     * Show table of Companies that actived subscription.
     */
    public function allactive()
    {
        $records = CompanySubscription::with(['company','subscription'])->where('end_date','>=',now()->format('Y-m-d H:i:s'))->get();
        return Datatables::of($records)->make(true);
    }  
    /**
     * Display a listing of the resource in DT.
     */
    public function renew()
    {
        $records = CompanySubscription::with(['company','subscription'])->where('pending',2)->get();
        return Datatables::of($records)->make(true);
    }
    /**
     * Display a listing of the resource in DT.
     */
    public function new()
    {
        $records = CompanySubscription::with(['company','subscription'])->where('pending',1)->get();
        return Datatables::of($records)->make(true);
    }  
    /**
     * Accept Request of subscription request.
     */
    public function accept($id)
    {
        DB::beginTransaction();
        try {
            $company_subscription = CompanySubscription::with('subscription')->where('id',$id)->where('pending','>',0)->firstOrFail();
            if($company_subscription->pending== 2){
                $history=new SubscriptionHistory();
                $history->subscription_id   = $company_subscription->subscription_id;
                $history->company_id        = $company_subscription->company_id;
                $history->start_date        = $company_subscription->start_date;
                $history->end_date          = $company_subscription->end_date;
                $history->durationInMonth   = $company_subscription->durationInMonth;
                $history->price             = $company_subscription->price;
                $history->rank_points       = $company_subscription->rank_points;
                $history->save();
                                                                                        
            }
                $company_subscription->pending     = 0;
                $company_subscription->rank_points = $company_subscription->subscription->rank_points;
                $company_subscription->start_date  = \Carbon\Carbon::now();
                $company_subscription->end_date    = \Carbon\Carbon::parse($company_subscription->start_date)->addMonths($company_subscription->durationInMonth);
                $company_subscription->save();             
            DB::commit();
            return response()->json([],200);
        }catch (\Exception $exception) {
            DB::rollback();
           abort(500);
        }        
    }                

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $MainTitle = 'Subscriptions';
        $SubTitle = 'Edit';
        $subscription = Subscription::findOrFail($id);
        return view('Admin._subscriptions.edit',compact('subscription','MainTitle','SubTitle'));
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(SubscriptionRequest $request, $id)
    {
        $input = $request->all();
        $subscription = Subscription::findOrFail($id);;
        DB::beginTransaction();
        try {
            $subscription->translate('en')->name  = $input['name_en'];
            $subscription->translate('ar')->name  = $input['name_ar'];
            $subscription->durationInMonth =  $input['durationInMonth'];
            $subscription->price           =  $input['price'];
            $subscription->rank_points     =  $input['rank_points'];
            $subscription->visibility      =  $input['visibility'];
            $subscription->save();
            session()->flash('_added',$subscription->name_en . ' data has been updated successfully');
            DB::commit();
          return back();
        }catch (\Exception $exception) {
            DB::rollback();
           abort(500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     */
    public function destroy($id)
    {
        $subscription= Subscription::findOrFail($id);
        $subscription->delete();
        return response()->json([],200);
    }

    /**
     * Show the form for assigning subscription to a company.
     */
    public function createAssignSubscription()
    {
        $MainTitle = 'Subscriptions';
        $SubTitle  = 'Assign Company';
        $subscribedCompanies = CompanySubscription::pluck('company_id')->all();
        $companies           = Company::whereNotIn('id', $subscribedCompanies)->get();
        $subscriptions       = Subscription::where('visibility',1)->get();
        return view('Admin._subscriptions.assignSubscription',compact('companies','subscriptions','MainTitle','SubTitle'));
    }
}
