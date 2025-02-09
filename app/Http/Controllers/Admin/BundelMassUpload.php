<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MassUploadProductsRequest;
use App\Imports\ProductsImport;
use App\Models\ShopProduct;
use App\Models\Bundel;
use App\Models\BundleProduct;
use App\Models\BundelShopProducts;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class BundelMassUpload extends Controller
{
    public function __invoke(MassUploadProductsRequest $request)
    {
        set_time_limit(0);

        DB::beginTransaction();
        try {
            // Determine file extension and store the uploaded file
            $extension = $request->file('file')->extension();
            $extension = 'csv';
            if ($request->file('file')->extension() == 'xlsx') {
                $extension = 'xlsx';
            }

            $file_name = 'bundles_admin';
            $request->file('file')->storeAs('mass', $file_name . '.' . $extension);
            $path = storage_path('app' . DIRECTORY_SEPARATOR . 'mass' . DIRECTORY_SEPARATOR . $file_name . '.' . $extension);

            // Read the file using Excel
            $rows = Excel::toArray(new ProductsImport(), $path);
            $result = $rows[0];

            if (count($result[0]) <= 1) {
                return back()->with('error', 'Error occurred, please check your file structure!');
            }

            $excelHeaders = $result[0];

            for ($x = 1; $x < count($result); $x++) {
                // Skip rows with missing bundle SKU or product SKU
                if (is_null($result[$x][0]) || is_null($result[$x][1])) {
                    continue;
                }

                $bundleSkuCode = $result[$x][0];
                $productSkuCode = $result[$x][1];
                $quantity = $result[$x][2] ?? 1; // Default quantity to 1 if not provided
                $locked = $result[$x][3] ?? 0;

                // Find or create the bundle by SKU
                $bundel = Bundel::where('sku_code' , $bundleSkuCode)->first();
                
                if(!$bundel)
                {
                     return back()->with('error', 'Bundel with SKU ' . $bundleSkuCode . ' not found.');
                }
                
                // Find the shop product by SKU
                $shopProduct = ShopProduct::where('sku_code', $productSkuCode)->first();

                if (!$shopProduct) {
                    return back()->with('error', 'Product with SKU ' . $productSkuCode . ' not found.');
                }

                $bundel_shop_product = BundelShopProducts::where('bundel_id' , $bundel->id)->where('shop_product_id' , $shopProduct->id)->first();
                if($bundel_shop_product)
                {
                    $bundel_shop_product->qty = $quantity;
                    $bundel_shop_product->locked = $locked;
                    $bundel_shop_product->save(); 
                }
                


                // Associate the product with the bundle
                BundelShopProducts::create([
                    'bundel_id' => $bundel->id,
                    'shop_product_id' => $shopProduct->id,
                    'qty' => $quantity,
                ]);
            }

            DB::commit();
            session()->flash('_added', 'Bundles and products have been uploaded successfully');
            return redirect()->back();
        } catch (\Exception $exception) {
            DB::rollback();
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }
}
