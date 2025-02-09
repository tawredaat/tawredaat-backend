<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\VendorShopProduct\ApproveAction;
use App\Actions\Admin\VendorShopProduct\DataAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\VendorShopProduct\ApproveRequest;
use App\Http\Requests\Admin\VendorShopProduct\MultiApproveRequest;
use App\Models\Vendor;
use App\Models\VendorShopProduct;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VendorShopProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $vendor_id = $request->vendor_id;

        try {
            $vendor = Vendor::findOrFail($vendor_id);
        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'Vendor does not exist');

            return redirect()->route('vendors.index');
        }

        $main_title = 'Shop Products For ' . $vendor->company_name;

        $sub_title = 'View';

        $shop_count = VendorShopProduct::vendorShopProducts($vendor_id)->count('id');

        return view('Admin._vendor_shop_products.index',
            compact('main_title', 'sub_title', 'shop_count', 'vendor_id')
        );
    }

    //get assigned products data from DB, then return data in html table
    public function data(Request $request, DataAction $data_action)
    {
        $data = $data_action->execute($request);

        return response()->json(['result' => $data['result'],
            'links' => $data['products']->links()->render()], 200);
    }

    /**
     * Approve vendor
     */
    public function approve(ApproveRequest $request, ApproveAction $approve_action)
    {

        DB::beginTransaction();

        try {
            $is_approved = $approve_action->execute($request->id);

            DB::commit();

            if ($is_approved) {
                $message = "Product is approved";
            } else {
                $message = "Product is disapproved";
            }

            return response()->json([
                'id' => $request->id,
                'is_approved' => $is_approved,
                'success' => $message], 200);

        } catch (\Exception$exception) {
            DB::rollback();

            return response()->json(['error'], 101);
        }
    }

    // approving
    public function approveSelected(MultiApproveRequest $request, ApproveAction $approve_action)
    {
        $vendor_id = $request->vendor_id;

        DB::beginTransaction();

        try {
            $products = VendorShopProduct::vendorShopProducts($vendor_id)
                ->whereIn('id', $request->input('products', []))
                ->get();

            foreach ($products as $product) {
                try {
                    VendorShopProduct::vendorShopProducts($vendor_id)->findOrFail($product->id);
                } catch (ModelNotFoundException $e) {
                    DB::rollback();

                    session()->flash('error', 'Product does not exist');

                    return redirect()->route('vendor.shop-products.index');
                }

                $approve_action->execute($product->id);
            }

            DB::commit();

            $product_count = count($request->input('products', []));

            session()->flash('_added', 'Products have been approved successfully ' .

                $product_count);

            return back();
        } catch (\Exception$exception) {
            DB::rollback();

            return response();
        }
    }

    public function approveAll(MultiApproveRequest $request, ApproveAction $approve_action)
    {
        DB::beginTransaction();

        $vendor_id = $request->vendor_id;

        try {

            $products = VendorShopProduct::vendorShopProducts($vendor_id)->get();

            foreach ($products as $product) {

                try {
                    VendorShopProduct::vendorShopProducts($vendor_id)->findOrFail($product->id);
                } catch (ModelNotFoundException $e) {
                    DB::rollback();

                    session()->flash('error', 'Product does not exist');

                    return redirect()->route('vendor.shop-products.index');
                }

                $approve_action->execute($product->id);
            }

            DB::commit();

            session()->flash('_added', 'Products have been approved successfully');

            return back();
        } catch (\Exception$exception) {
            DB::rollback();

            return response();
        }
    }

}