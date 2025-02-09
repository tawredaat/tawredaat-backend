<?php

namespace App\Http\Controllers\Vendor;

use App\Actions\Vendor\ShopProductOffer\DataAction;
use App\Actions\Vendor\ShopProductOffer\RemoveFromOfferAction;
use App\Http\Controllers\Controller;
use App\Models\VendorShopProduct;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopProductOfferController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $main_title = 'Shop Offers Products';

        $sub_title = 'View';

        return view('Vendor.shop_product_offers.index', compact('main_title', 'sub_title'));
    }

    //get offers
    public function data(Request $request, DataAction $data_action)
    {
        ini_set('memory_limit', '1024M'); // or you could use 1G

        $data = $data_action->execute($request);

        return response()->json(['result' => $data['result'],
            'links' => $data['products']->links()->render()], 200);
    }

    public function removeFromOffer($id, RemoveFromOfferAction $remove_action)
    {
        DB::beginTransaction();

        try {
            VendorShopProduct::vendorShopProducts()->findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['error' => 'Product not found!'], 101);
        }

        try {

            $remove_action->execute($id);

            DB::commit();

            return response()->json(['id' => $id], 200);

        } catch (\Exception $exception) {
            DB::rollback();
            return response();
        }
    }

}