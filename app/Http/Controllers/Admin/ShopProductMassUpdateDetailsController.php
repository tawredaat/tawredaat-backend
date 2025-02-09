<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MassUploadProductsRequest;
use App\Models\ShopProduct;
use App\Imports\ProductsImport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Brand;
use App\Models\BrandTranslation;
use App\Models\Category;
use App\Models\CategoryTranslation;
use App\Models\QuantityType;
use App\Models\QuantityTypeTranslation;
use App\Models\ShopProductSpecification;
use App\Models\Specification;
use App\Models\SpecificationTranslation;
use Illuminate\Support\Str;

class ShopProductMassUpdateDetailsController extends Controller
{
    public function __invoke(MassUploadProductsRequest $request)
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');

        DB::beginTransaction();
        try {
            $errors = []; // Array to collect errors
            $extension = $request->file('file')->extension();
            $extension = 'csv';
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
                return back()->with('error', 'Error occurred, please check your file structure!');
            }

            $excelHeaders = $result[0];

            for ($x = 1; $x < count($result); $x++) {
                $productName = $result[$x][0] ?? 'Unknown Product'; // Get the product name

                $product = ShopProduct::with('translations', 'specifications', 'specifications.specification', 'specifications.specification.translations')
                    ->where('sku_code', $result[$x][5])->first();

                if (!$product) {
                    $errors[] = "Product with SKU code '{$result[$x][5]}' and name '{$productName}' not found.";
                    continue;
                }

                if (is_null($result[$x][0])) {
                    $errors[] = "Skipping row for product with SKU '{$result[$x][5]}' because the name is empty.";
                    continue;
                }

                $category = Category::where('id', CategoryTranslation::where('name', $result[$x][3])->value('category_id'))->first();
                if (!$category) {
                    $errors[] = "Category '{$result[$x][3]}' not found for product '{$productName}'.";
                    continue;
                }

                $brand = Brand::where('id', BrandTranslation::where('name', $result[$x][4])->value('brand_id'))->first();
                if (!$brand) {
                    $errors[] = "Brand '{$result[$x][4]}' not found for product '{$productName}'.";
                    continue;
                }

                $qty_type = QuantityType::where('id', QuantityTypeTranslation::where('name', $result[$x][22])->value('quantity_type_id'))->first();
                if (!$result[$x][26]) {
                    $errors[] = "Internal code is required for product '{$productName}'.";
                    continue;
                }

                if (!$result[$x][31]) {
                    $errors[] = "Seller (English) is required for product '{$productName}'.";
                    continue;
                }

                if (!$result[$x][32]) {
                    $errors[] = "Seller (Arabic) is required for product '{$productName}'.";
                    continue;
                }

                try {
                    $product->update([
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
                            'seller' => $result[$x][31],
                            'sla' => $result[$x][27],
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
                            'seller' => $result[$x][32],
                            'sla' => $result[$x][28],
                        ],
                        'image' => $result[$x][2] ? 'shop_products' . DIRECTORY_SEPARATOR . $result[$x][2] : null,
                        'image_name1' => $result[$x][23] ? 'shop_products' . DIRECTORY_SEPARATOR . $result[$x][23] : null,
                        'image_name2' => $result[$x][24] ? 'shop_products' . DIRECTORY_SEPARATOR . $result[$x][24] : null,
                        'image_name3' => $result[$x][25] ? 'shop_products' . DIRECTORY_SEPARATOR . $result[$x][25] : null,
                        'internal_code' => $result[$x][26],
                        'pdf' => $result[$x][18] ? 'shop_products' . DIRECTORY_SEPARATOR . $result[$x][18] : null,
                        'sku_code' => $result[$x][5],
                        'category_id' => $category->id,
                        'brand_id' => $brand->id,
                        'offer' => $result[$x][33],
                        'old_price' => $result[$x][19] ? $result[$x][19] : null,
                        'new_price' => $result[$x][20] ? $result[$x][20] : 0,
                        'qty' => $result[$x][21] ? $result[$x][21] : 0,
                        'quantity_type_id' => $qty_type ? $qty_type->id : null,
                    ]);

                    $specificationIndex = 34;
                    if ($specificationIndex < count($excelHeaders)) {
                        $this->updateSpecifications($product, $result[$x], $excelHeaders);
                    }
                } catch (\Exception $exception) {
                    $errors[] = "Failed to update product '{$productName}': " . $exception->getMessage();
                    continue;
                }
            }

            if (count($errors) > 0) {
                DB::rollBack();
                return back()->with('error', implode('<br>', $errors));
            }

            DB::commit();
            session()->flash('_added', 'Shop products have been updated successfully.');
            return redirect()->route('shop.products.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            session()->flash('error', 'An error occurred: ' . $exception->getMessage());
            return redirect()->route('shop.products.index');
        }
    }

    private function updateSpecifications($product, $row, $excelHeaders)
    {
        $specificationIndex = 34;

        if ($specificationIndex < count($excelHeaders)) {
            // Delete ShopProductSpecification and its translations
            ShopProductSpecification::where('shop_product_id', $product->id)->each(function ($spec) {
                $spec->translations()->delete(); // Delete translations
                $spec->delete(); // Delete the specification
            });
        }

        $count = 1;
        while ($specificationIndex < count($excelHeaders)) {
            $specValueEn = $row[$specificationIndex];
            $specValueAr = $row[$specificationIndex + 1];

            if ($count <= 20 && $specValueAr) {
                $specId = SpecificationTranslation::where('name', $excelHeaders[$specificationIndex])
                    ->orWhere('name', $excelHeaders[$specificationIndex + 1])
                    ->value('specification_id');

                if ($specId) {
                    $specification = ShopProductSpecification::create([
                        'shop_product_id' => $product->id,
                        'specification_id' => $specId,
                    ]);

                    // Add translations for the specification
                    $specification->translations()->createMany([
                        ['locale' => 'ar', 'value' => $specValueAr],
                        ['locale' => 'en', 'value' => $specValueEn],
                    ]);
                }
            }

            $count++;
            $specificationIndex += 2;
        }
    }
}
