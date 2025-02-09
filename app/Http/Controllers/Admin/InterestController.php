<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use App\Models\Interest;
use App\Http\Requests\Admin\InterestRequest;
use Illuminate\Support\Facades\DB;

class InterestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $MainTitle = 'Interests';
        $SubTitle  = 'View';
        return view('Admin._interests.index',compact('MainTitle','SubTitle'));
    }
    /**
     * Display a listing of the resource in DT.
     *
     * @return Json Object
     */
    public function interests()
    {
        $records = Interest::all();
        return Datatables::of($records)->make(true);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $MainTitle = 'Interests';
        $SubTitle  = 'Add';
        return view('Admin._interests.create',compact('MainTitle','SubTitle'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InterestRequest $request)
    {
        DB::beginTransaction();
        try{
            Interest::create([
            'en'=> [
                    'name'  => $request->input('name_en'),
                    ],
           'ar' => [
                    'name'  => $request->input('name_ar'),
                    ],
            ]);
            DB::commit();
            session()->flash('_added','Interest data  Created Succssfuly');
            return redirect()->route('interests.index');
        }catch (\Exception $exception) {
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
       $MainTitle = 'Interests';
       $SubTitle  = 'Edit';
       $interest = Interest::findOrFail($id);
       return view('Admin._interests.edit',compact('interest','MainTitle','SubTitle'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(InterestRequest $request, $id)
    {
        Db::beginTransaction();
        try{
            $interest=Interest::findOrFail($id);
            $interest->translate('en')->name  = $request->input('name_en');
            $interest->translate('ar')->name  = $request->input('name_ar');
            $interest->save();
            DB::commit();
            session()->flash('_updated','Interest updated succssfuly');
            return back();
        }catch (\Exception $exception) {
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
        Db::beginTransaction();
        try{
            $interest= Interest::findOrFail($id);
            $interest->delete();
            DB::commit();
            return response()->json([],200);
        }catch (\Exception $exception) {
            DB::rollback();
            abort(500);
        }
    }
}
