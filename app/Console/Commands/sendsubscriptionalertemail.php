<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PdfDownload;
use App\Models\CompanySubscription;
use App\Models\Company;
use App\Mail\SubscriptionAlertMail;
use Illuminate\Support\Facades\Mail;

class sendsubscriptionalertemail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscription:sendalert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'this command send email for companies who only have less than 10 days for their subscriptions';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
            // $record=new PdfDownload();
            // $record->user_id=1;
            // $record->company_id=1;
            // $record->save();
            // pri_contact_email
        $companies =Company::whereIn('id', CompanySubscription::with('company')->where('end_date','<=',\Carbon\Carbon::now()->addMonth())->pluck('company_id'))->get();
        foreach ($companies as $company) {
            Mail::to($company->pri_contact_email)->send(new SubscriptionAlertMail());
        }


    }
}
