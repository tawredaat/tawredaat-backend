<?php

namespace App\Actions\User\GuestUser;

use App\Models\GuestUser;

class StoreIdAction
{
    public function execute()
    {
        return GuestUser::create();
    }
}
