<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PromoCodeRequest;
use App\Http\Requests\Admin\UpdatePromoCodeRequest;
use App\Models\Promocode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use App\Models\Brand;

class PromocodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $MainTitle = 'Promocodes';
        $SubTitle = 'View';
        return view('Admin._promocodes.index', compact('MainTitle', 'SubTitle'));
    }
    /**
     * Display a listing of the resource in DT.
     *
     * @return Json Object
     */
    public function promocodes()
    {
        $records = Promocode::all();
        return Datatables::of($records)->make(true);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $MainTitle = 'Promocodes';
        $SubTitle = 'Add';
        $brands = Brand::with(['translation' => function ($query) {
            $query->select('brand_id', 'name');
        }])->get(['id']);
      return view('Admin._promocodes.create', compact('MainTitle', 'SubTitle' , 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PromoCodeRequest $request)
    {

        $input = $request->all();
      	if($input['brand_id'])
        {
          $brands = json_encode($input['brand_id']);
        }
        DB::beginTransaction();
        try {
            Promocode::create([
                'code' => $input['code'],
                'discount' => $input['discount'],
              	'min_amount' => $input['min_amount'],
              	'max_amount' => $input['max_amount'],
                'discount_type' => $input['discount_type'],
                'valid_from' => $input['valid_from'],
                'valid_to' => $input['valid_to'],
                'uses' => $input['uses'],
              	'brands' => $brands,
                'en' => [
                    'name' => $input['name_en'],
                ],
                'ar' => [
                    'name' => $input['name_ar'],
                ],
            ]);
            DB::commit();
            session()->flash('_added', 'Promocode  Created Succssfuly');
            return redirect()->route('promocodes.index');
        } catch (\Exception $exception) {
            DB::rollback();
            abort(500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $MainTitle = 'Promocodes';
        $SubTitle = 'Edit';
        $promocode = Promocode::findOrFail($id);
        $brands = Brand::with(['translation' => function ($query) {
              $query->select('brand_id', 'name');
          }])->get(['id']);
        $selectedBrands = json_decode($promocode->brands, true); // Decode JSON to array
        return view('Admin._promocodes.edit', compact('promocode', 'MainTitle', 'SubTitle' , 'selectedBrands' , 'brands'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePromoCodeRequest $request, $id)
    {
      	if($request['brand_id'])
        {
          $brands = json_encode($request['brand_id']);
        }

        Db::beginTransaction();
        try {
            $promocode = Promocode::findOrFail($id);
            $promocode->translate('en')->name = $request->input('name_en');
            $promocode->translate('ar')->name = $request->input('name_ar');
            $promocode->code = $request->input('code');
            $promocode->discount = $request->input('discount');
          	$promocode->max_amount = $request->input('max_amount');
            $promocode->min_amount = $request->input('min_amount');
            $promocode->discount_type = $request->input('discount_type');
            $promocode->valid_from =  $request->input('valid_from');
            $promocode->valid_to =  $request->input('valid_to');
            $promocode->uses =  $request->input('uses');
          	$promocode->brands = $request->input('brand_id');
            $promocode->save();
            DB::commit();
            session()->flash('_updated', 'Promocode updated successfuly');
            return back();
        } catch (\Exception $exception) {
            DB::rollback();
            abort(500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $promocode = Promocode::findOrFail($id);
        $promocode->delete();
        return response()->json([], 200);
    }
}
