<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MassUploadProductsRequest;
use App\Imports\ProductsImport;
use App\Models\Brand;
use App\Models\BrandTranslation;
use App\Models\Category;
use App\Models\CategoryTranslation;
use App\Models\QuantityType;
use App\Models\QuantityTypeTranslation;
use App\Models\Specification;
use App\Models\SpecificationTranslation;
use App\Models\VendorShopProduct;
use App\Models\VendorShopProductSpecification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class ShopProductMassUpload extends Controller
{
    public function __invoke(MassUploadProductsRequest $request)
    {
        // set_time_limit(0);

        DB::beginTransaction();

        try {
            $extension = $request->file('file')->extension();
            $extension = 'csv';
            // supporting xlsx
            if ($request->file('file')->extension() == 'xlsx') {
                $extension = 'xlsx';
            }
            $file_name = 'products_vendor';
            $request->file('file')->storeAs('mass', $file_name . '.' . $extension);
            $path = storage_path('app' . DIRECTORY_SEPARATOR . 'mass' .
                DIRECTORY_SEPARATOR . $file_name . '.' . $extension);

            $rows = Excel::toArray(new ProductsImport(), $path);
            $result = $rows[0];

            if (count($result[0]) <= 1) {
                return back()->with('error',
                    'Error occurred, please check your file structure!');
            }

            $excelHeaders = $result[0];

            for ($row = 1; $row < count($result); $row++) {

                $category = Category::where('id',
                    CategoryTranslation::where('name',
                        $result[$row][3])->value('category_id'))
                    ->first();

                if (!$category) {
                    return back()->with('error', 'Category ' .
                        $result[$row][3] . ' Not Found');
                }

                $brand = Brand::where('id',
                    BrandTranslation::where('name', $result[$row][4])->value('brand_id'))
                    ->first();

                if (!$brand) {
                    return back()->with('error', 'Brand ' . $result[$row][4] . ' Not Found');
                }

                $qty_type = QuantityType::where('id',
                    QuantityTypeTranslation::where('name', $result[$row][22])
                        ->value('quantity_type_id'))->first();

                $img_name = $result[$row][2] ?
                'vendor_shop_products' . DIRECTORY_SEPARATOR . $result[$row][2] : 'null';

                $pdf_name = $result[$row][18] ?
                'vendor_shop_products' . DIRECTORY_SEPARATOR . $result[$row][18] : null;

                $product = VendorShopProduct::create([
                    'en' => [
                        'name' => $result[$row][0],
                        'slug' => Str::slug($result[$row][0]),
                        'title' => $result[$row][12],
                        'alt' => $result[$row][6],
                        'description' => $result[$row][14],
                        'description_meta' => $result[$row][16],
                        'keywords_meta' => $result[$row][10],
                        'keywords' => $result[$row][8],
                    ],
                    'ar' => [
                        'name' => $result[$row][1] ? $result[$row][1] : $result[$row][0],
                        'slug' => $result[$row][1] ? slugInArabic($result[$row][1]) : Str::slug($result[$row][0]),
                        'title' => $result[$row][13],
                        'alt' => $result[$row][7],
                        'description' => $result[$row][15],
                        'description_meta' => $result[$row][17],
                        'keywords_meta' => $result[$row][11],
                        'keywords' => $result[$row][9],

                    ],
                    'image' => $img_name,
                    'pdf' => $pdf_name,
                    'sku_code' => $result[$row][5],
                    'category_id' => $category->id,
                    'brand_id' => $brand->id,
                    'old_price' => $result[$row][19] ? $result[$row][19] : 0,
                    'new_price' => $result[$row][20] ? $result[$row][20] : 0,
                    'qty' => $result[$row][21] ? $result[$row][21] : 0,
                    'quantity_type_id' => $qty_type ? $qty_type->id : null,
                    'vendor_id' => Auth('vendor')->user()->id,
                ]);

                $count = 1;
                $product_specification = 23;
                while ($product_specification < count($excelHeaders)) {
                    $specification_value_ar_name = $result[$row][$product_specification];
                    $specification_value_en_name = $result[$row][$product_specification + 1];

                    if ($count <= 20) {
                        if (!is_null($result[$row][$product_specification])) {
                            $specification_id = null;
                            $specification = null;
                            $specification_id = SpecificationTranslation::where('name',
                                $excelHeaders[$product_specification])
                                ->orWhere('name', $excelHeaders[$product_specification + 1])
                                ->value('specification_id');

                            if (!is_null($specification_id)) {
                                $specification = Specification::where('id', $specification_id)->first();
                            }
                            if ($specification) {
                                VendorShopProductSpecification::create([
                                    'vendor_shop_product_id' => $product->id,
                                    'specification_id' => $specification->id,
                                    'ar' => [
                                        'value' => $specification_value_ar_name,
                                    ],
                                    'en' => [
                                        'value' => $specification_value_en_name,
                                    ],
                                ]);
                            }
                        }
                    }
                    $count++;
                    $product_specification += 2;
                }
            }

            DB::commit();
            session()->flash('_added', 'Shop products has been uploaded successfully');
            return redirect()->route('vendor.shop-products.index');
        } catch (\Exception $exception) {

            DB::rollback();

            session()->flash('error', 'Cannot upload');

            return redirect()->route('vendor.shop-products.index');
        }
    }

}
