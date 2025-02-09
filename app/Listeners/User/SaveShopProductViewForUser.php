<?php

namespace App\Listeners\User;

use App\Models\UserShopProductsView;

class SaveShopProductViewForUser
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
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $user_product_views = UserShopProductsView::
            where('ip', request()->ip());

        $user_product_views->update([
            'ip' => null,
            'user_id' => $event->user->id,
        ]);

    }
}
