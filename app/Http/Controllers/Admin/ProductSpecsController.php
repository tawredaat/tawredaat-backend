<?php

namespace App\Http\Controllers\Admin;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Specification;
use App\Http\Requests\Admin\ProductSpecsRequest;
use Illuminate\Support\Facades\DB;
class ProductSpecsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $MainTitle = 'Products Specifications';
        $SubTitle  = 'View';

        return view('Admin._product_specs.index',compact('MainTitle','SubTitle'));
    }
    /**
     * Display a listing of the resource in DT.
     */
    public function products()
    {
        $records = Specification::all();
        return Datatables::of($records)->make(true);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $MainTitle = 'Products Specifications';
        $SubTitle  = 'Add';
        return view('Admin._product_specs.create',compact('MainTitle','SubTitle'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductSpecsRequest $request)
    {
        $input = $request->all();
        DB::beginTransaction();
        try {
        Specification::create([
            'en'   => [
                        'name'=> $input['name_en'],
                    ],
            'ar'   => [
                        'name' => $input['name_ar'],
                    ],
            'weight'=>$input['weight']
        ]);
        DB::commit();
        session()->flash('_added','product specs has beend created succssfuly');
        return redirect()->route('productSpecs.index');
        }catch (\Exception $exception) {
            DB::rollback();
            abort(500);
        }
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $MainTitle = 'Products Specifications';
        $SubTitle  = 'Edit';
        $product  = Specification::findOrFail($id);
        return view('Admin._product_specs.edit',compact('MainTitle','SubTitle','product'));
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(ProductSpecsRequest $request, $id)
    {

        $specification= Specification::findOrFail($id);
        $input = $request->all();

        DB::beginTransaction();
        try {
            $specification->translate('en')->name  = $input['name_en'];
            $specification->translate('ar')->name  = $input['name_ar'];
            $specification->weight=$input['weight'];
//            dd($input);
            $specification->save();
//            dd($input);
        DB::commit();
        session()->flash('_updated','product specs data has been updated succssfuly');
            return back();
        }catch (\Exception $exception) {
            DB::rollback();
            abort(500);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Specification::findOrFail($id)->delete();
        return response()->json(['success' => 'Data is successfully deleted']);
    }
}
