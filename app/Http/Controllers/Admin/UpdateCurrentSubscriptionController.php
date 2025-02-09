<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\CompanySubscription;
use App\Models\Subscription;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Admin\UpdateCurrentSubscription;
use Carbon\Carbon;
class UpdateCurrentSubscriptionController extends Controller
{
    public function __invoke(UpdateCurrentSubscription $request,$id)
    {
    	 DB::beginTransaction();
        try {
            $Company_subscrib = CompanySubscription::findOrFail($id);
            $input 			  = $request->all();
			if(Carbon::parse($Company_subscrib->start_date)->gt(Carbon::parse($request->end_date))){
			   session()->flash('error', 'end date must be older than start date');
	            return back();
			}
            $companyName = CompanySubscription::where('id',$id)->update(['end_date'=>$input['end_date'],'rank_points'=>$input['rank_points']]);

            session()->flash('_added',$Company_subscrib->company->name_en . ' subscription data has been updateed successfully');
            DB::commit();
            return back();
        } catch (\Exception $exception) {
            DB::rollback();
            return abort(500);
        }
    }
}
