<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MassUploadProductsRequest;
use App\Imports\ProductsImport;
use App\Models\Brand;
use App\Models\BrandTranslation;
use App\Models\Category;
use App\Models\CategoryTranslation;
use App\Models\QuantityType;
use App\Models\QuantityTypeTranslation;
use App\Models\ShopProduct;
use App\Models\ShopProductSpecification;
use App\Models\Specification;
use App\Models\SpecificationTranslation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class ShopProductMassUpload extends Controller
{
    public function __invoke(MassUploadProductsRequest $request)
    {
        set_time_limit(0);

        DB::beginTransaction();
        try {
            $extension = $request->file('file')->extension();
            $extension = 'csv';
            // supporting xlsx
            if ($request->file('file')->extension() == 'xlsx') {
                $extension = 'xlsx';
            }

            $file_name = 'products_admin';
            $request->file('file')->storeAs('mass', $file_name . '.' . $extension);
            $path = storage_path('app' . DIRECTORY_SEPARATOR . 'mass' .
                DIRECTORY_SEPARATOR . $file_name . '.' . $extension);

            $rows = Excel::toArray(new ProductsImport(), $path);
            $result = $rows[0];

            if (count($result[0]) <= 1) {
                return back()->with('error', 'error occurred, please check your file structure!');
            }

            $excelHeaders = $result[0];

            for ($x = 1; $x < count($result); $x++) {
                // skip rows with empty products names
                if (is_null($result[$x][0])) {
                    continue;
                }
                $category = Category::where('id',
                    CategoryTranslation::where('name', $result[$x][3])
                        ->value('category_id'))->first();

                if (!$category) {
                    return back()->with('error', 'Category ' . $result[$x][3] . ' Not Found');
                }

                $brand = Brand::where('id', BrandTranslation::where('name', $result[$x][4])->value('brand_id'))->first();
                if (!$brand) {
                    return back()->with('error', 'Brand ' . $result[$x][4] . ' Not Found');
                }

                $qty_type = QuantityType::where('id', QuantityTypeTranslation::where('name', $result[$x][22])->value('quantity_type_id'))->first();
                $imgName = $result[$x][2] ? 'shop_products' . DIRECTORY_SEPARATOR . $result[$x][2] : null;
                $PdfName = $result[$x][18] ? 'shop_products' . DIRECTORY_SEPARATOR . $result[$x][18] : null;
                $img_one = $result[$x][23] ? 'shop_products' . DIRECTORY_SEPARATOR . $result[$x][23] : null;
                $img_two = $result[$x][24] ? 'shop_products' . DIRECTORY_SEPARATOR . $result[$x][24] : null;
                $img_three = $result[$x][25] ? 'shop_products' . DIRECTORY_SEPARATOR . $result[$x][25] : null;
                $internal_code =  $result[$x][26] ;
                $seller_en =  $result[$x][31];
                $seller_ar =  $result[$x][32];
                $note_en =  $result[$x][29] ?$result[$x][29] : null;
                $note_ar =  $result[$x][30] ?$result[$x][30] : null;

                if(!$internal_code)
                {
                    return back()->with('error', 'Interna Code is Required');
                }

                if(!$seller_en)
                {
                    return back()->with('error', 'Seller En is Required');
                }

                if(!$seller_ar)
                {
                    return back()->with('error', 'Seller Ar is Required');
                }

                $product = ShopProduct::create([
                    'en' => [
                        'name' => $result[$x][0],
                        'slug' => Str::slug($result[$x][0]),
                        'title' => $result[$x][12],
                        'alt' => $result[$x][6],
                        'description' => $result[$x][14],
                        'description_meta' => $result[$x][16],
                        'keywords_meta' => $result[$x][10],
                        'keywords' => $result[$x][8],
                        'note' => $result[$x][29],
                      	'sla' => $result[$x][27],
                        'seller' => $result[$x][31],
                    ],
                    'ar' => [
                        'name' => $result[$x][1] ? $result[$x][1] : $result[$x][0],
                        'slug' => $result[$x][1] ? slugInArabic($result[$x][1]) : Str::slug($result[$x][0]),
                        'title' => $result[$x][13],
                        'alt' => $result[$x][7],
                        'description' => $result[$x][15],
                        'description_meta' => $result[$x][17],
                        'keywords_meta' => $result[$x][11],
                        'keywords' => $result[$x][9],
                        'note' => $result[$x][30],
                        'sla' => $result[$x][28],
                        'seller' => $result[$x][32],
                    ],
                    'image' => $imgName,
                    'image_name1' => $img_one,
                    'image_name2' => $img_two,
                    'image_name3' => $img_three, 
                    'internal_code' =>$internal_code,
                    'pdf' => $PdfName,
                    'sku_code' => $result[$x][5],
                    'category_id' => $category->id,
                    'brand_id' => $brand->id,
                    'old_price' => $result[$x][19] ? $result[$x][19] : 0,
                    'new_price' => $result[$x][20] ? $result[$x][20] : 0,
                    'qty' => $result[$x][21] ? $result[$x][21] : 0,
                    'quantity_type_id' => $qty_type ? $qty_type->id : null,
                  	'offer' => $result[$x][33],
                ]);
                
                $count = 1;
                $specification_index = 34;
                // dd(count($excelHeaders));
                while ($specification_index + 1 < count($result[$x])) {
                    $specification_value_en_name = $result[$x][$specification_index];
                    $specification_value_ar_name = $result[$x][$specification_index + 1];

                    if ($count <= 20) {
                        if (!is_null($result[$x][$specification_index])) {
                            $specification_id = null;
                            $specification = null;
                            $specification_id = SpecificationTranslation::where('name',
                                $excelHeaders[$specification_index])
                                ->orWhere('name', $excelHeaders[$specification_index + 1])
                                ->value('specification_id');

                            if (!is_null($specification_id)) {
                                $specification = Specification::where('id', $specification_id)->first();
                            }

                            if (!is_null($specification)) {
                              $shopProductSpecification = ShopProductSpecification::create([
                                    'shop_product_id' => $product->id,
                                    'specification_id' => $specification->id,
                                    'ar' => [
                                        'value' => $specification_value_ar_name,
                                    ],
                                    'en' => [
                                        'value' => $specification_value_en_name,
                                    ],
                                ]);

                                DB::table('shop_product_specifications')
                                ->where('id', $shopProductSpecification->id)
                                ->update(['value' => $specification_value_en_name]);
                            }
                        }
                    }
                    $count++;
                    $specification_index += 2;
                }
            }
            DB::commit();
            session()->flash('_added', 'Shop products has been uploaded successfully');
            return redirect()->route('shop.products.index');
        } catch (\Exception $exception) {
            DB::rollback();
          //dd($exception , $product , $result[$x][2] , $x , $result[$x]);
            return redirect()->back()->with('error', $exception->getMessage());
            return redirect()->route('shop.products.index');
        }
    }

}
