<?php

namespace App\Actions\Vendor\Specification;

use App\Models\VendorSpecification;
use Illuminate\Http\Request;

class UpdateAction
{
    public function execute(Request $request, $id)
    {
        $specification = VendorSpecification::findOrFail($id);

        $specification->translate('en')->name = $request->name_en;

        $specification->translate('ar')->name = $request->name_ar;

        $specification->save();
    }
}
