<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\PrivacyPolicyRequest;
use Illuminate\Support\Facades\DB;
use App\Models\PrivacyPolicy;
class PrivacyPolicyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $MainTitle = 'Privacy & Policy';
        $SubTitle  = 'Save';
        $privacy = PrivacyPolicy::first();
        return view("Admin._privacyPolicies.index",compact('MainTitle','SubTitle','privacy'));
    }

    /**
     * Update the specified resource in storage.
     */

    /**
     * Update the specified resource in storage.
     */
    public function save(PrivacyPolicyRequest $request)
    {
        $input = $request->all();
        $privacy = PrivacyPolicy::first();
        DB::beginTransaction();
        try {
            if($privacy){
                $privacy->translate('en')->content  = $input['content_en'];
                $privacy->translate('ar')->content  = $input['content_ar'];
                $privacy->save();
            }else{
                PrivacyPolicy::create([
                    'en'    => [
                              'content'    => $input['content_en'],
                          ],
                   'ar'     => [
                               'content'  =>  $input['content_ar'],
                          ],
                ]);
            }
            DB::commit();
            session()->flash('_updated','Privacy and policy data has been updated succssfuly');
            return back();
        }catch (\Exception $exception) {
            DB::rollback();
            return abort(500);
        }

    }

}
