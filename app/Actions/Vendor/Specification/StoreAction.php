<?php

namespace App\Actions\Vendor\Specification;

use App\Models\VendorSpecification;
use Illuminate\Http\Request;

class StoreAction
{
    public function execute(Request $request)
    {
        $vendor_specification = VendorSpecification::create([
            'vendor_id' => Auth('vendor')->user()->id,

            'en' => [
                'name' => $request->name_en,
            ],
            'ar' => [
                'name' => $request->name_ar,
            ],
        ]);

        return $vendor_specification;
    }
}
