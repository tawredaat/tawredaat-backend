<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\ProductsImport;
use App\Http\Requests\Admin\MassUploadProductsRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductSpecification;
use App\Models\Specification;
use App\Models\ProductImage;
use App\Models\ProductPDF;
use App\Models\CategoryTranslation;
use App\Models\BrandTranslation;
use App\Models\SpecificationTranslation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class MassUploadProductsController extends Controller
{
    public function __invoke(MassUploadProductsRequest $request)
    {
        set_time_limit(0);
        // DB::beginTransaction();
        // try {
            $request->file('file')->storeAs('mass', 'import.csv');
            $rows = Excel::toArray(new ProductsImport(), storage_path('app' . DIRECTORY_SEPARATOR . 'mass' . DIRECTORY_SEPARATOR . 'import.csv'));
            $result = $rows[0];
            $excelHeaders = $result[0];
            for ($x = 1; $x < count($result); $x++) {
                $category = Category::where('id', CategoryTranslation::where('name', $result[$x][3])->value('category_id'))->first();
                if (!$category)
                    return back()->with('error','Category '.$result[$x][3].' Not Found');
                $brand = Brand::where('id', BrandTranslation::where('name', $result[$x][4])->value('brand_id'))->first();
                if (!$brand)
                    return back()->with('error','Brand '.$result[$x][4].' Not Found');
                // $imgName = 'products' . DIRECTORY_SEPARATOR . rand() . $result[$x][2];
                $imgName = 'products' . DIRECTORY_SEPARATOR . $result[$x][2];
                if ($result[$x][18])
                    $PdfName = 'products' . DIRECTORY_SEPARATOR . rand() . $result[$x][18];
                else
                    $PdfName = null;
                $product = Product::create([
                    'en' => [
                        'name' => $result[$x][0],
                        'title' => $result[$x][12],
                        'alt' => $result[$x][6],
                        'description' => $result[$x][14],
                        'description_meta' => $result[$x][16],
                        'keywords_meta' => $result[$x][10],
                        'keywords' => $result[$x][8],
                    ],
                    'ar' => [
                        'name' => $result[$x][1]?$result[$x][1]:$result[$x][0],
                        'title' => $result[$x][13],
                        'alt' => $result[$x][7],
                        'description' => $result[$x][15],
                        'description_meta' => $result[$x][17],
                        'keywords_meta' => $result[$x][11],
                        'keywords' => $result[$x][9],

                    ],
                    'image' => $imgName,
                    'pdf' => $PdfName,
                    'sku_code' => $result[$x][5],
                    'category_id' => $category->id ,
                    'brand_id' => $brand->id ,
                ]);
                //images path to deleted after link with products
                // $TARGET_PATH = public_path() . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'products' . DIRECTORY_SEPARATOR . basename($result[$x][2]);
                // //rename images
                // while (file_exists($TARGET_PATH)) {
                //     // rename($TARGET_PATH, public_path() . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'products' . DIRECTORY_SEPARATOR . substr($product->image, 9));
                //     ProductImage::where('image', 'products/' . $result[$x][2])->delete();
                // }
                if ($result[$x][18]) {
                    //PDFs path to rename after link with products
                    $TARGET_PATH_PDF = public_path() . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'products' . DIRECTORY_SEPARATOR . basename($result[$x][18]);
                    //rename PDF files
                    while (file_exists($TARGET_PATH_PDF)) {
                        rename($TARGET_PATH_PDF, public_path() . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'products' . DIRECTORY_SEPARATOR . substr($product->pdf, 9));
                        ProductPDF::where('pdf', 'products/' . $result[$x][18])->delete();
                    }
                }
                $count = 1;
                for ($prodAspec = 18; $prodAspec < count($excelHeaders); $prodAspec++) {
                    if ($count <= 20) {
                        if (!is_null($result[$x][$prodAspec])) {
                            $productAspec = Specification::where('id', SpecificationTranslation::where('name', $excelHeaders[$prodAspec])->value('specification_id'))->first();
                            if ($productAspec) {
                                ProductSpecification::create([
                                    'product_id' => $product->id,
                                    'specification_id' => $productAspec->id,
                                    'value' => $result[$x][$prodAspec]
                                ]);
                            }
                        }
                    }
                    $count++;
                }
            }
            DB::commit();
            session()->flash('_added', 'Products has been uploaded successfully');
            return redirect()->route('products.index');
        // } catch (\Exception $exception) {
        //     DB::rollback();
        //     abort(500);
        // }
    }
}