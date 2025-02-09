<?php

namespace App\Listeners\User;

use App\Models\UserShopProductsView;

class SaveShopProductView
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
        $user = auth('api')->user();

        if ($user) {
            // product was not inserted before

            $user_product_view = UserShopProductsView::where('user_id', $user->id)
                ->whereDate('created_at', '>',
                    config('global.recently_viewed_products_after_timestamp',
                        date('Y-m-d', strtotime("-1 days"))))
                ->select('id')->first();

            if (is_null($user_product_view)) {
                UserShopProductsView::create([
                    'user_id' => $user->id,
                    'shop_product_id' => $event->shop_product_id,
                ]);
            }

        } else {
            $user_product_view = UserShopProductsView::where('ip', request()->ip())
                ->whereDate('created_at', '>',
                    config('global.recently_viewed_products_after_timestamp',
                        date('Y-m-d', strtotime("-1 days"))))
                ->select('id')->first();

            if (is_null($user_product_view)) {
                UserShopProductsView::create([
                    'ip' => request()->ip(),
                    'shop_product_id' => $event->shop_product_id,
                ]);
            }

        }
    }
}
