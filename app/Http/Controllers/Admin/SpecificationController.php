<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateSpecificationValue;
use App\Models\ShopProduct;
use App\Models\ShopProductSpecification;
use Illuminate\Support\Facades\DB;

class SpecificationController extends Controller
{
    function edit($product_id, $specification_id)
    {
        $MainTitle = 'Specification Values';
        $SubTitle = 'Edit';
        $product = ShopProduct::with('specifications')->find($product_id);
        $shopProductSpecification = $product->specifications()->with('translation')->find($specification_id);
        // dd($specification->id);
        $productId = $product_id;
        return view('Admin._specifications.edit', compact('MainTitle', 'SubTitle', 'shopProductSpecification' ,'productId'));
    }

    function update(UpdateSpecificationValue $request)
    {
        DB::beginTransaction();
        try {
            $shopProductSpecification = ShopProductSpecification::find($request->shopProductSpecification_id);
            $shopProductSpecification->update([
                'ar' => [
                    'value' => $request->value_ar,
                ],
                'en' => [
                    'value' => $request->value_en,
                ],
            ]);

            DB::table('shop_product_specifications')
                ->where('id', $shopProductSpecification->id)
                ->update(['value' => $request->value_en]);
            DB::commit();
            session()->flash('_added', 'Specification value has been updated succssfuly');
            return back();
        } catch (\Exception $exception) {
            DB::rollback();
            abort(500);
        }
    }
}
