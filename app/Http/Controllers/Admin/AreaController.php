<?php
namespace App\Http\Controllers\Admin;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\AreaRequest;
use App\Models\Area;
use Illuminate\Support\Facades\DB;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $MainTitle = 'Areas';
        $SubTitle  = 'View';
        return view('Admin._areas.index',compact('MainTitle','SubTitle'));
    }
    //show areas in DT
    public function areas()
    {
        $records = Area::all();
        return Datatables::of($records)->make(true);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $MainTitle = 'Areas';
        $SubTitle  = 'Add';
        return view('Admin._areas.create',compact('MainTitle','SubTitle'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AreaRequest $request)
    {
        $input = $request->all();
        DB::beginTransaction();
        try {
            Area::create([
                'en'=> [
                        'name' => $input['name_en'],
                        ],
               'ar' => [
                        'name' => $input['name_ar'],
                        ],
            ]);
        DB::commit();
        session()->flash('_added','Area has been Created Succssfuly');
        return redirect()->route('areas.index');
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
        $MainTitle = 'Areas';
        $SubTitle  = 'Edit';
        $area      = Area::findOrFail($id); 
        return view('Admin._areas.edit',compact('MainTitle','SubTitle','area'));
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(AreaRequest $request, $id)
    {
        $input = $request->all();
        $area  = Area::findOrFail($id);
        DB::beginTransaction();
        try {
            $area->translate('en')->name  = $input['name_en'];
            $area->translate('ar')->name  = $input['name_ar'];
            $area->save();
            DB::commit();
            session()->flash('_updated','Area data has been updated succssfuly');
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
        $area = Area::findOrFail($id)->delete();
        return response()->json(['success' => 'Data is successfully deleted']);
    }
}
