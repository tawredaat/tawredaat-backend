<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CityRequest;
use App\Models\City;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $MainTitle = 'Cities';
        $SubTitle = 'View';
        return view('Admin._cities.index', compact('MainTitle', 'SubTitle'));
    }
    //show cities in DT
    public function cities()
    {
        $records = City::all();
        return Datatables::of($records)->make(true);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $MainTitle = 'Cities';
        $SubTitle = 'Add';
        return view('Admin._cities.create', compact('MainTitle', 'SubTitle'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CityRequest $request)
    {
        $input = $request->all();
        DB::beginTransaction();
        try {
            City::create([
                'en' => [
                    'name' => $input['name_en'],
                ],
                'ar' => [
                    'name' => $input['name_ar'],
                ],
                'shipping_fees' => $input['shipping_fees'],
            ]);
            DB::commit();
            session()->flash('_added', 'City has been Created Succssfuly');
            return redirect()->route('cities.index');
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
        $MainTitle = 'Cities';
        $SubTitle = 'Edit';
        $city = City::findOrFail($id);
        return view('Admin._cities.edit', compact('MainTitle', 'SubTitle', 'city'));
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(CityRequest $request, $id)
    {
        $input = $request->all();
        $city = City::findOrFail($id);
        DB::beginTransaction();
        try {
            $city->translate('en')->name = $input['name_en'];
            $city->translate('ar')->name = $input['name_ar'];
            $city->shipping_fees = $input['shipping_fees'];

            $city->save();
            DB::commit();
            session()->flash('_updated', 'City data has been updated succssfuly');
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
        $city = City::findOrFail($id)->delete();
        return response()->json(['success' => 'Data is successfully deleted']);
    }

    public function deliveryCharge(Request $request)
    {
        try {
            $address = UserAddress::select('city_id')->findOrFail($request->address_id);
            $city = City::findOrFail($address->city_id);
            return $city->shipping_fees;
        } catch (\Exception $exception) {
            return 0;
        }
    }

}
