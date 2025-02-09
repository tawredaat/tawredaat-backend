<?php

namespace App\Http\Controllers\Admin;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\UnitRequest;
use App\Models\Unit;
use Illuminate\Support\Facades\DB;
class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $MainTitle = 'Units';
        $SubTitle  = 'View';
        return view('Admin._units.index',compact('MainTitle','SubTitle'));
    }

    //show units in DT
    public function units()
    {
        $records = Unit::all();
        return Datatables::of($records)->make(true);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $MainTitle = 'Units';
        $SubTitle  = 'Add';
        return view('Admin._units.create',compact('MainTitle','SubTitle'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UnitRequest $request)
    {

        $input = $request->all();
        DB::beginTransaction();
        try {
        Unit::create([
            'en'=> [
                    'name' => $input['name_en'],
                    ],
           'ar' => [
                    'name' => $input['name_ar'],
                    ],
        ]);
        DB::commit();
        session()->flash('_added','Unit has been created succssfuly');
        return redirect()->route('units.index');
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
        $MainTitle = 'Units';
        $SubTitle  = 'Edit';
        $unit      = Unit::findOrFail($id); 
        return view('Admin._units.edit',compact('SubTitle','MainTitle','unit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UnitRequest $request, $id)
    {
        $unit = Unit::findOrFail($id);
        $input = $request->all();
        DB::beginTransaction();
        try {
            $unit->translate('en')->name  = $input['name_en'];
            $unit->translate('ar')->name  = $input['name_ar'];
            $unit->save();
            DB::commit();
            session()->flash('_updated','Unit data has been updated succssfuly');
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
        $unit = Unit::findOrFail($id)->delete();
        return response()->json(['success' => 'Data is successfully deleted']);
    }
}
