<?php

namespace App\Actions\Admin\Vendor;

use App\Models\Vendor;
use Illuminate\Http\Request;

class ApproveAction
{
    public function execute(Request $request)
    {
        $vendor = Vendor::findOrFail($request->id);

        if ($vendor->is_approved == 1) {
            $vendor->is_approved = 0;
        } else {
            $vendor->is_approved = 1;
        }

        $vendor->save();
    }
}
