<?php

namespace App\Actions\User\GuestUser;

use App\Models\GuestUser;

class StoreAction
{
    public function execute($request)
    {
        $guest_user = GuestUser::findOrFail($request->id);
        return $guest_user->update(
            [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'company_name' => $request->company_name,
                'country_or_region' => $request->country_or_region,
                'street_address_first_line' => $request->street_address_first_line,
                'street_address_second_line' => $request->street_address_second_line,
                'town_or_city' => $request->town_or_city,
                'state_or_country_id' => $request->state_or_country_id,

            ]
        );
    }
}
