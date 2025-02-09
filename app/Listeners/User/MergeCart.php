<?php

namespace App\Listeners\User;

use App\User;
use App\Events\User\UserLoggedIn;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use App\Models\Cart;

class MergeCart
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
     * @param UserLoggedIn $event
     * @return void
     */
    public function handle(UserLoggedIn $event)
    {
        if (request()->hasHeader('deviceId')) {
            $deviceId = request()->header('deviceId');
            $oldUser = User::where('device_id', $deviceId)->first();
            if ($oldUser) {
                $newUser = auth()->user();
                if ($newUser)
                {
                    $newCart = $newUser->cart;
                    if (!$newCart)
                        $newCart = Cart::create(['user_id' => $newUser->id]);

                    $oldCart = Cart::with('items')->where('user_id', $oldUser->id)->first();
                    if ($oldCart) {
                        foreach ($oldCart->items as $oldItem) {
                            $newItem = $newCart->items()->where('shop_product_id', $oldItem->shop_product_id)->first();
                            if ($newItem) {
                                $newItem->qtyy += $oldItem->qty;
                                $newItem->save();
                            } else {
                                $oldItem->cart_id = $newCart->id;
                                $oldItem->save();
                            }
                        }
                    }
                    $oldUser->delete();
                }
            }
        }
    }
}
