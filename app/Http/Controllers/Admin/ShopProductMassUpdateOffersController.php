<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MassUploadProductsRequest;
use App\Models\ShopProduct;
use App\Imports\ProductsImport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Exception;

class ShopProductMassUpdateOffersController extends Controller
{
    public function __invoke(MassUploadProductsRequest $request)
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');

        DB::beginTransaction();

        try {
            $extension = $request->file('file')->extension();
            $extension = 'csv'; // Default to CSV
            // Supporting xlsx
            if ($request->file('file')->extension() == 'xlsx') {
                $extension = 'xlsx';
            }

            $file_name = 'products_admin';
            $request->file('file')->storeAs('mass', $file_name . '.' . $extension);
            $path = storage_path('app' . DIRECTORY_SEPARATOR . 'mass' . DIRECTORY_SEPARATOR . $file_name . '.' . $extension);

            $rows = Excel::toArray(new ProductsImport(), $path);
            $result = $rows[0]; // Assuming the first sheet is the relevant data
            
            // Check if the structure of the file is valid
            if (count($result[0]) <= 1) {
                return back()->with('error', 'Error occurred, please check your file structure!');
            }

            $excelHeaders = $result[0]; // Read the headers if necessary

            for ($x = 1; $x < count($result); $x++) {
                // Locate the product by SKU code
                $product = ShopProduct::where('sku_code', $result[$x][0])->first();

                if (!$product) {
                    return back()->with('error', 'Product not found with SKU code: ' . $result[$x][0]);
                }
				
                try {
                    // Update the product offer
                    $product->update([
                        'offer' => $result[$x][1],
                    ]);
                } catch (Exception $exception) {
                    return back()->with('error', 'Something went wrong while updating the offer.');
                }
            }

            DB::commit();
            session()->flash('_added', 'Offers have been updated successfully.');
            return redirect()->route('shop.products.index');
        } catch (Exception $exception) {
            // Rollback and return the error message
            DB::rollback();
            session()->flash('error', 'Cannot upload the file.');
            return redirect()->route('shop.products.index');
        }
    }
}