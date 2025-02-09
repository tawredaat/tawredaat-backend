<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AssignSubscriptionRequest;
use App\Mail\addSubscriptionToCompanyMail;
use App\Models\Company;
use App\Models\CompanySubscription;
use App\Models\Subscription;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Helpers\General;

class AssignSubscriptionController extends Controller
{
    public function __invoke(AssignSubscriptionRequest $request)
    {
        DB::beginTransaction();
        // try {
            $input = $request->all();
            $subscription = Subscription::find($input['subscriptionId']);
            $today = date("Y-m-d");
            $today = strtotime(date("Y-m-d", strtotime($today)) . " +$subscription->durationInMonth month");
            $endDate = date("Y-m-d",$today);
            CompanySubscription::create([
                'subscription_id' => $subscription->id,
                'company_id'      => $input['companyId'],
                'start_date'      => now(),
                'end_date'        => $endDate,
                'durationInMonth' => $subscription->durationInMonth,
                'price'           => $subscription->price,
                'rank_points'     => $subscription->rank_points,
            ]);

            $company = Company::find($input['companyId']);
            $code = General::generateCode(6);
            $company->password = bcrypt($code);
            $company->save();
            Mail::to($company->pri_contact_email)->send(new addSubscriptionToCompanyMail($company->name,$subscription->name,$code,$company->pri_contact_email,$company->id));

            session()->flash('_added', 'The Company has been assigned to ' . $subscription->name . ' Successfully');
            DB::commit();
            return redirect()->route('subscriptions.index');
        // } catch (\Exception $exception) {
        //     DB::rollback();
        //     abort(500);
        // }
    }
}
