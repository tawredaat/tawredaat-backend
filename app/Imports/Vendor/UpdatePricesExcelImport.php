<?php

namespace App\Imports\Vendor;

use App\Models\VendorShopProduct;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Row;

class UpdatePricesExcelImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return Model|null
     */
    public function model(array $row)
    {
        $id = $row[0];

        $product = VendorShopProduct::vendorShopProducts()->findOrFail($id);

        $product->old_price = $row[2] > $row[1] ? null : $row[1];

        $product->new_price = $row[2];

        $product->is_approved = 0;

        $product->save();

        return $product;
    }
}
