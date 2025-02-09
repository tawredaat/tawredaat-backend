<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FAQ\FAQRequest;
use App\Models\FAQ;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FAQController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $MainTitle = 'FAQs';
        $SubTitle = 'Save';
        $faq = FAQ::first();
        return view("Admin._faqs.index", compact('MainTitle', 'SubTitle', 'faq'));
    }

    /**
     * Update the specified resource in storage.
     */

    /**
     * Update the specified resource in storage.
     */
    public function save(FAQRequest $request)
    {
        $input = $request->all();
        $faq = FAQ::first();
        DB::beginTransaction();
        try {
            if ($faq) {
                $faq->translate('en')->content = $input['content_en'];
                $faq->translate('ar')->content = $input['content_ar'];
                $faq->save();
            } else {
                FAQ::create([
                    'en' => [
                        'content' => $input['content_en'],
                    ],
                    'ar' => [
                        'content' => $input['content_ar'],
                    ],
                ]);
            }
            DB::commit();
            session()->flash('_updated', 'FAQs data has been updated successfully');
            return back();
        } catch (\Exception $exception) {
            DB::rollback();
            session()->flash('error', 'Error cannot save!');
        }

    }

}
