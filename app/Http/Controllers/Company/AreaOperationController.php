<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AreaOperation;
use App\Models\Area;
use Yajra\Datatables\Datatables;
use App\Http\Requests\Company\StoreAreaOfOperationRequest;
use App\Http\Requests\Company\UpdateAreaOfOperationRequest;
use Illuminate\Support\Facades\DB;
class AreaOperationController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $MainTitle = 'Area of operations';
        $SubTitle = 'View';
        return view('Company._areas_perations.index',compact('MainTitle','SubTitle'));
    }
    /**
     * Display a listing of the resource in DT.
     */
    public function areas()
    {
        $records = auth('company')->user()->areas()->get();
        return Datatables::of($records)->make(true);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $MainTitle = 'Area of operations';
        $SubTitle  = 'Add';
        $myareas   = auth('company')->user()->areas->pluck('id');
        $areas     = Area::whereNotIn('id',$myareas)->get();        
        return view('Company._areas_perations.create',compact('MainTitle','SubTitle','areas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAreaOfOperationRequest $request)
    {
        $input = $request->all();
        DB::beginTransaction();
        try {
        auth('company')->user()->areas()->attach($request->areas);
        DB::commit();
        session()->flash('_added','Area of operations has been createed succssfuly');
        return redirect()->route('company.areasOperations.index');
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
        
        // $title  ='Edit area of operation';
        // $area   = AreaOperation::findOrFail($id); 
        // if(CompanyID()==$area->company_id) {
        // return view('Company._areas_perations.edit',compact('title','area'));
        // }
        // abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(UpdateAreaOfOperationRequest $request, $id)
    {
        // $input = $request->all();
        // DB::beginTransaction();
        // try {
        // AreaOperation::where('id',$id)->update([
        //     'name_en'  => $input['name_en'],
        //     'name_ar'  => $input['name_ar'],
        // ]);
        // DB::commit();
        // session()->flash('_updated','Branch data has been updated succssfuly');
        // return back();
        // }catch (\Exception $exception) {
        //     DB::rollback();
        //     abort(500);
        // }   
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $area  = Area::findOrFail($id);
        auth('company')->user()->areas()->detach($id);
        return response()->json(['success' => 'Data is successfully deleted']);
    }
}
