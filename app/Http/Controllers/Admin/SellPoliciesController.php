<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\SellPoliciesRequest;
use Illuminate\Support\Facades\DB;
use App\Models\SellPolicy;
class SellPoliciesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    { 
        $MainTitle = 'Sell Policies';
        $SubTitle  = 'Save';
        $sell = SellPolicy::first();
        return view("Admin._sellPolicies.index",compact('MainTitle','SubTitle','sell'));
    }

    /**
     * Update the specified resource in storage.
     */

    /**
     * Update the specified resource in storage.
     */
    public function save(SellPoliciesRequest $request)
    {
        $input = $request->all();
        $sell = SellPolicy::first();
        DB::beginTransaction();
        try {
            if($sell){
                $sell->translate('en')->content  = $input['content_en'];
                $sell->translate('ar')->content  = $input['content_ar'];  
                $sell->save();
            }else{
                SellPolicy::create([
                    'en'    => [
                              'content'    => $input['content_en'],
                          ],
                   'ar'     => [
                               'content'  =>  $input['content_ar'],
                          ],
                ]);
            }
            DB::commit();
            session()->flash('_updated','Sell policies data has been updated succssfuly');
            return back();
        }catch (\Exception $exception) {
            DB::rollback();
            return abort(500);
        }

    }

}
