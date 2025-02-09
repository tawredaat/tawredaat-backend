<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RefundAndReturnsPolicyRequest;
use App\Models\RefundAndReturnsPolicy;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RefundAndReturnsPolicyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $MainTitle = 'Refund and Returns Policy';
        $SubTitle = 'Save';
        $refund_and_returns_policy = RefundAndReturnsPolicy::first();
        return view('Admin._refund_and_returns_policy.index', compact('MainTitle', 'SubTitle', 'refund_and_returns_policy'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function save(RefundAndReturnsPolicyRequest $request)
    {
        $input = $request->all();
        $refund_and_returns_policy = RefundAndReturnsPolicy::first();
        DB::beginTransaction();
        try {
            if ($refund_and_returns_policy) {
                $refund_and_returns_policy->translate('en')->content = $input['content_en'];
                $refund_and_returns_policy->translate('ar')->content = $input['content_ar'];
                $refund_and_returns_policy->save();
            } else {
                RefundAndReturnsPolicy::create([
                    'en' => [
                        'content' => $input['content_en'],
                    ],
                    'ar' => [
                        'content' => $input['content_ar'],
                    ],
                ]);
            }
            DB::commit();
            session()->flash('_updated', 'Refund and Returns Policy data has been updated successfully');
            return back();
        } catch (\Exception $exception) {
            DB::rollback();
            return abort(500);
        }

    }

}