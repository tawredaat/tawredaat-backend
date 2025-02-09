<?php

namespace App\Listeners\Admin;

use App\Events\Admin\BrandCategoryEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\BrandCategory;

class BrandCategoryListener
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
     * @param  BrandCategoryEvent  $event
     * @return void
     */
    public function handle(BrandCategoryEvent $event)
    {
        //
        foreach ($event->categories as $category) {
            BrandCategory::create(['category_id'=>$category,'brand_id'=>$event->brand]);          
        }
    }
}
