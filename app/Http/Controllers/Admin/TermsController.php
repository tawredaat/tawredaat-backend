<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\TermsRequest;
use Illuminate\Support\Facades\DB;
use App\Models\Term;
class TermsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    { 
        $MainTitle = 'Terms & Conditions';
        $SubTitle  = 'Save';
        $terms  = Term::first();
        return view('Admin._terms.index', compact('MainTitle', 'SubTitle','terms'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function save(TermsRequest $request)
    {
        $input = $request->all();
        $terms = Term::first();
        DB::beginTransaction();
        try {
            if($terms){
                $terms->translate('en')->content  = $input['content_en'];
                $terms->translate('ar')->content  = $input['content_ar'];  
                $terms->save();
            }else{
                Term::create([
                    'en'    => [
                              'content'    => $input['content_en'],
                          ],
                   'ar'     => [
                               'content'  =>  $input['content_ar'],
                          ],
                ]);
            }
            DB::commit();
            session()->flash('_updated','Terms & Conditions data has been updated succssfuly');
            return back();
        }catch (\Exception $exception) {
            DB::rollback();
            return abort(500);
        }

    }

}
