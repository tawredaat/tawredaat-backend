<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ExportProductBrand;
use App\Http\Controllers\Controller;
use App\Imports\UpdateProductBrand;
use App\Models\ShopProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\Datatables\Datatables;
use App\Events\Admin\CountryBrandEvent;
use App\Events\Admin\BrandCategoryEvent;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Country;
use App\Models\CompanyProduct;
use App\Http\Requests\Admin\StoreBrandRequest;
use App\Http\Requests\Admin\UpdateBrandRequest;
use App\Helpers\UploadFile;
use Illuminate\Support\Facades\DB;

class BrandController extends Controller
{


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $MainTitle = 'Brands';
        $SubTitle = 'View';
        $brands = Brand::all();
        return view('Admin._brands.index', compact('MainTitle', 'SubTitle', 'brands'));
    }

    /**
     * Display a listing of the resource in DT.
     */
    public function brands(Request $request)
    {
        $records = Brand::when($request->input('start_date') && $request->input('end_date'), function ($query) use ($request) {
            $query->whereBetween('created_at', [Carbon::parse($request->start_date), Carbon::parse($request->end_date)]);
        })->get();
        return Datatables::of($records)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $MainTitle = 'Brands';
        $SubTitle = 'Add';
        $countries = Country::all();
        $level3Categories = Category::where('level', 'level3')->get();
        return view('Admin._brands.create', compact('MainTitle', 'SubTitle', 'level3Categories', 'countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBrandRequest $request)
    {
        $input = $request->all();
        DB::beginTransaction();
        try {
            //upload new image file
            if ($request->file('image'))
                $image = UploadFile::UploadSinglelFile($request->file('image'), 'brands');
            else
                $image = null;

            //upload new image file
            if ($request->file('mobileimg'))
                $mob_image = UploadFile::UploadSinglelFile($request->file('mobileimg'), 'brands');
            else
                $mob_image = null;

            //upload new PDF file
            if ($request->file('pdf'))
                $pdf = UploadFile::UploadSinglelFile($request->file('pdf'), 'brands');
            else
                $pdf = null;

            $brand = Brand::create([
                'image' => $image,
                'mobileimg' => $mob_image,
                'pdf' => $pdf,
                'country_id' => $input['country_id'],
                'categories' => json_encode($request->categories),
                'en' => [
                    'name' => $input['name_en'],
                    'title' => $input['title_en'],
                    'alt' => $input['alt_en'],
                    'description' => $input['description_en'],
                    'description_meta' => $input['description_meta_en'],
                    'keywords_meta' => $input['keywords_meta_en'],
                    'keywords' => $input['keywords_en'],
                    'products_title' => $input['products_title_en'],
                    'products_description' => $input['products_description_en'],
                    'products_keywords' => $input['products_keywords_en'],
                    'distributors_title' => $input['distributors_title_en'],
                    'distributors_description' => $input['distributors_description_en'],
                    'distributors_keywords' => $input['distributors_keywords_en'],
                ],
                'ar' => [
                    'name' => $input['name_ar'],
                    'title' => $input['title_ar'],
                    'alt' => $input['alt_ar'],
                    'description' => $input['description_ar'],
                    'description_meta' => $input['description_meta_ar'],
                    'keywords_meta' => $input['keywords_meta_ar'],
                    'keywords' => $input['keywords_ar'],
                    'products_title' => $input['products_title_ar'],
                    'products_description' => $input['products_description_ar'],
                    'products_keywords' => $input['products_keywords_ar'],
                    'distributors_title' => $input['distributors_title_ar'],
                    'distributors_description' => $input['distributors_description_ar'],
                    'distributors_keywords' => $input['distributors_keywords_ar'],

                ],
            ]);
            // //store  multi  countries this brand
            // event(new CountryBrandEvent($brand->id,$request->countries));

            // store  multi  countries this brand
            event(new BrandCategoryEvent($brand->id, $request->categories));

            DB::commit();
            session()->flash('_added', 'Brand Created Succssfuly');
            return redirect()->route('brands.index');
        } catch (\Exception $exception) {
            DB::rollback();
            abort(500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $MainTitle = 'Brands';
        $SubTitle = 'Edit';
        $level3Categories = Category::where('level', 'level3')->get();
        $brand = Brand::findOrFail($id);
        $myCategories = $brand->brandCategories->pluck('category_id')->toArray();
        $countries = Country::all();
        return view('Admin._brands.edit', compact('MainTitle', 'SubTitle', 'brand', 'level3Categories', 'myCategories', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(UpdateBrandRequest $request, $id)
    {
        $input = $request->all();
        $brand = Brand::findOrFail($id);
        DB::beginTransaction();
        try {
            //upload  new image file
            if ($request->file('image')) {
                //Remove old file
                UploadFile::RemoveFile($brand->image);
                $brand->image = UploadFile::UploadSinglelFile($request->file('image'), 'brands');
            }


            //upload  new image file
            if ($request->file('mobileimg')) {
                //Remove old file
                UploadFile::RemoveFile($brand->mobileimg);
                $brand->mobileimg = UploadFile::UploadSinglelFile($request->file('mobileimg'), 'brands');
            }

            //upload  new PDF file
            if ($request->file('pdf')) {
                if ($brand->pdf) {
                    //Remove old file
                    UploadFile::RemoveFile($brand->pdf);
                }
                $brand->pdf = UploadFile::UploadSinglelFile($request->file('pdf'), 'brands');
            }
            $brand->country_id = $input['country_id'];
            $brand->categories = json_encode($request->categories);
            $brand->translate('en')->name = $input['name_en'];
            $brand->translate('ar')->name = $input['name_ar'];
            $brand->translate('en')->title = $input['title_en'];
            $brand->translate('ar')->title = $input['title_ar'];
            $brand->translate('en')->alt = $input['alt_en'];
            $brand->translate('ar')->alt = $input['alt_ar'];
            $brand->translate('en')->description = $input['description_en'];
            $brand->translate('ar')->description = $input['description_ar'];
            $brand->translate('en')->description_meta = $input['description_meta_en'];
            $brand->translate('ar')->description_meta = $input['description_meta_ar'];
            $brand->translate('en')->keywords_meta = $input['keywords_meta_en'];
            $brand->translate('ar')->keywords_meta = $input['keywords_meta_ar'];
            $brand->translate('en')->keywords = $input['keywords_en'];
            $brand->translate('ar')->keywords = $input['keywords_ar'];

            $brand->translate('en')->products_title = $input['products_title_en'];
            $brand->translate('ar')->products_title = $input['products_title_ar'];
            $brand->translate('en')->products_description = $input['products_description_en'];
            $brand->translate('ar')->products_description = $input['products_description_ar'];
            $brand->translate('en')->products_keywords = $input['products_keywords_en'];
            $brand->translate('ar')->products_keywords = $input['products_keywords_ar'];
            $brand->translate('en')->distributors_title = $input['distributors_title_en'];
            $brand->translate('ar')->distributors_title = $input['distributors_title_ar'];
            $brand->translate('en')->distributors_description = $input['distributors_description_en'];
            $brand->translate('ar')->distributors_description = $input['distributors_description_ar'];
            $brand->translate('en')->distributors_keywords = $input['distributors_keywords_en'];
            $brand->translate('ar')->distributors_keywords = $input['distributors_keywords_ar'];
            $brand->save();
            // foreach ($brand->countries as $country) {
            //     $country->delete();
            // }
            //store  multi  countries this brand
            // event(new CountryBrandEvent($brand->id,$request->countries));

            foreach ($brand->brandCategories as $category) {
                $category->delete();
            }
            // store  multi  countries this brand
            event(new BrandCategoryEvent($brand->id, $request->categories));
            DB::commit();
            session()->flash('_added', 'Brand Updated Succssfuly');
            return back();
        } catch (\Exception $exception) {
            DB::rollback();
            abort(500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);
        if ($brand->image)
            UploadFile::RemoveFile($brand->image);
        if ($brand->pdf)
            UploadFile::RemoveFile($brand->pdf);
        $brand->delete();
        return response()->json([], 200);
    }

    /**
     * Mak brand featured in home page
     */
    public function makeFeatured($id)
    {
        $brand = Brand::findOrFail($id);
        DB::beginTransaction();
        try {
            if ($brand->featured) {
                $brand->featured = 0;
                $brand->save();
                DB::commit();
                return response()->json(['id' => $id, 'featured' => $brand->featured, 'success' => 'Brand has been removed from featured.']);
            } else {
                $brand->featured = 1;
                $brand->save();
                DB::commit();
                return response()->json(['id' => $id, 'featured' => $brand->featured, 'success' => 'Brand has been added as featured.']);
            }
        } catch (\Exception $exception) {
            DB::rollback();
            abort(500);
        }
    }
    /**
     * Toggle show brands in website
     */
    public function toggleShow($id)
    {
        $brand = Brand::findOrFail($id);
        DB::beginTransaction();
        try {
            if ($brand->show) {
                $brand->show = 0;
                $brand->save();
                DB::commit();
                return response()->json(['id' => $id, 'show' => $brand->show, 'success' => ' Brand has been hidden from website.']);
            } else {
                $brand->show = 1;
                $brand->save();
                DB::commit();
                return response()->json(['id' => $id, 'show' => $brand->show, 'success' => ' Brand has been shown in website.']);
            }
        } catch (\Exception $exception) {
            DB::rollback();
            abort(500);
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function CompaniesRequests()
    {

        $MainTitle = 'Brands';
        $SubTitle = 'Companies Requests';
        $brands = CompanyProduct::where('approve', '!=', 0)->groupBy('brand_id')->groupBy('company_id')->orderBy('id', 'ASC')->get();
        return view('Admin._brands.CompaniesRequests', compact('MainTitle', 'SubTitle', 'brands'));
    }

    /**
     * Approve brand company type.
     */
    public function approveBrandType(Request $request)
    {
        DB::beginTransaction();
        try {
            $selectedBrand = Brand::find($request->brand_id);
            $assignedPros = CompanyProduct::whereNotNull('product_id')->where('company_id',$request->company_id)->pluck('product_id')->toArray();
            $brandsCompanies = CompanyProduct::where('brand_id', $request->brand_id)->where('company_id', $request->company_id)->get();
            foreach ($brandsCompanies as $brand) {
                $brand->approve = 2;
                $brand->save();
            }
            //linked product of brand to company
            // if(count($selectedBrand->products)){
            //     foreach($selectedBrand->products->whereNotIn('id',$assignedPros) as $proBrand)
            //     {
            //         CompanyProduct::create([
            //             'company_id'  => $request->company_id,
            //             'product_id'  => $proBrand->id,
            //             'brand_id'    => $proBrand->brand_id,
            //             'approve'=>2,
            //         ]);
            //     }
            // }
            DB::commit();
            return response()->json(['type' => $request->type_id, 'success' => 'Brand approved successfully']);
        } catch (\Exception $exception) {
            DB::rollback();
            abort(500);
        }
    }

    /**
     * Reject brand company type.
     */
    public function rejectBrandType(Request $request)
    {
        DB::beginTransaction();
        try {
            $brandsCompanies = CompanyProduct::where('brand_id', $request->brand_id)->where('company_id', $request->company_id)->get();
            foreach ($brandsCompanies as $brand) {
                $brand->approve = -1;
                $brand->save();
            }
            DB::commit();
            return response()->json(['type' => $request->type_id, 'success' => 'Brand rejected successfully']);
        } catch (\Exception $exception) {
            DB::rollback();
            abort(500);
        }
    }

    //update rank point

    public function RankPoint(Request $request)
    {
        $brand = Brand::findOrFail($request->id);
        DB::beginTransaction();
        try {
            $brand->rank = $request->rank;
            $brand->save();
            DB::commit();
            session()->flash('_updated', 'Rank point updated successfully to ' . $brand->name);
            return back();
        } catch (\Exception $exception) {
            DB::rollback();
            abort(500);
        }
    }

    //    export product foreach brand
    public function exportProductBrand(Request $request)
    {
        try {
            $brandId = Brand::where('id', $request->id)->value('id');
            $products = ShopProduct::where('brand_id', $brandId)->get();

            // Generate the Excel file and return it as a downloadable file
            return Excel::download(new ExportProductBrand($products), $brandId.'.csv');
        } catch (\Exception $ex) {
            return response()->json([
                'error' => 'Error occurred, Please try again later.'
            ], 500);
        }
    }

//    update product brand
    public function importProductBrand(Request $request)
    {
        try {
            if ($request->hasFile('excelFile')) {
                $file = $request->file('excelFile');

                // Import the Excel file
                $import = new UpdateProductBrand();
                Excel::import($import, $file);

                return response()->json(['success' => 'Data imported successfully.']);
            } else {
                return response()->json(['error' => 'No file uploaded.']);
            }
        } catch (\Exception $ex) {
            dd( $ex);
            return response()->json(['error' => 'Error occurred while importing data.'], 500);
        }
    }
}
