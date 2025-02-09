<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\CompanyNewRfqMail;

class SendRFQsToCompanyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $companies;
    public $rfq;
    public function __construct($companies, $rfq)
    {
        $this->companies;
        $this->rfq;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // foreach ($this->companies as $company)
        //     Mail::to($company->company_email)->send(new CompanyNewRfqMail($company->company_name,$this->rfq));
    }
}
