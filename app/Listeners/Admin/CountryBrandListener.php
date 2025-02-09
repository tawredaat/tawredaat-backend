<?php

namespace App\Listeners\Admin;

use App\Events\Admin\CountryBrandEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\BrandCountry;
class CountryBrandListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  CountryBrandEvent  $event
     * @return void
     */
    public function handle(CountryBrandEvent $event)
    {
        foreach ($event->countries as $country) {
            BrandCountry::create(['country_id'=>$country,'brand_id'=>$event->brand]);          
        }
    }
}
