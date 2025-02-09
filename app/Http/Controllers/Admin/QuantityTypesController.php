<?php

namespace App\Http\Controllers\Admin;
use App\Models\QuantityType;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Specification;
use App\Http\Requests\Admin\ProductSpecsRequest;
use Illuminate\Support\Facades\DB;
class QuantityTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $MainTitle = 'Quantity Types';
        $SubTitle  = 'View';
        return view('Admin._quantity_types.index',compact('MainTitle','SubTitle'));
    }
    /**
     * Display a listing of the resource in DT.
     */
    public function quantities()
    {
        $records = QuantityType::all();
        return Datatables::of($records)->make(true);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $MainTitle = 'Quantity Types';
        $SubTitle  = 'Add';
        return view('Admin._quantity_types.create',compact('MainTitle','SubTitle'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductSpecsRequest $request)
    {
        $input = $request->all();
        DB::beginTransaction();
        try {
            QuantityType::create([
                'en'   => [
                    'name'=> $input['name_en'],
                ],
                'ar'   => [
                    'name' => $input['name_ar'],
                ],
            ]);
            DB::commit();
            session()->flash('_added','quantity type has beend created succssfully');
            return redirect()->route('quantityTypes.index');
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
        $MainTitle = 'Quantity Types';
        $SubTitle  = 'Edit';
        $quantity  = QuantityType::findOrFail($id);
        return view('Admin._quantity_types.edit',compact('MainTitle','SubTitle','quantity'));
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(ProductSpecsRequest $request, $id)
    {
        $quantity= QuantityType::findOrFail($id);
        $input = $request->all();
        DB::beginTransaction();
        try {
            $quantity->translate('en')->name  = $input['name_en'];
            $quantity->translate('ar')->name  = $input['name_ar'];
            $quantity->save();
            DB::commit();
            session()->flash('_updated','Quantity type data has been updated succssfully');
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
        $quantity = QuantityType::findOrFail($id)->delete();
        return response()->json(['success' => 'Data is successfully deleted']);
    }
}
