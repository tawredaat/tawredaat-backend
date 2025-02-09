<?php
namespace App\Imports;

use App\Models\ShopProduct;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UpdateProductBrand implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {

        $product = ShopProduct::where('id', $row['product_id'])->first();
        if ($product) {
            $product->qty = $row['quantity'];
            $product->old_price = $row['old_price'];
            $product->new_price = $row['new_price'];
            $product->save();
        }

        return null;
    }
}
