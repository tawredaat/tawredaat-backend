<?php
namespace App\Actions\User\UserAddress;

use App\Models\UserAddress;

class SetDefaultAction
{
    public function execute($id)
    {
        $record = UserAddress::findOrFail($id);
        $record->is_default = 1;
        $record->save();
        // change all contacts to be non-default
        UserAddress::where('user_id', auth()->user()->id)
            ->where('id', '!=', $id)
            ->update(['is_default' => 0]);
        return $record->id;
    }
}
