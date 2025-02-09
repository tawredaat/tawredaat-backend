<?php

namespace App\Actions\Vendor\Specification;

use App\Models\VendorSpecification;

class DestroyAction
{
    public function execute($id)
    {
        VendorSpecification::findOrFail($id)->delete();
    }
}
