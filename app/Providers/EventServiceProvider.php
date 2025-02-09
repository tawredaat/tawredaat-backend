<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        'App\Events\Admin\CountryBrandEvent' => ['App\Listeners\Admin\CountryBrandListener'],
        'App\Events\Admin\BrandCategoryEvent' => ['App\Listeners\Admin\BrandCategoryListener'],
        'App\Events\User\UserLoggedIn' => [
            'App\Listeners\User\SaveUserLogin',
            'App\Listeners\User\MergeCart',
            'App\Listeners\User\SaveShopProductViewForUser',
        ],
        ShopProductViewedEvent::class => [
            SaveShopProductView::class,
        ],

        'App\Events\User\ShopProductViewed' =>
        ['App\Listeners\User\SaveShopProductView'],

    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
