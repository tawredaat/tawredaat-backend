<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PaymentRequest;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use App\Helpers\UploadFile;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $MainTitle = 'Payments';
        $SubTitle = 'View';
        return view('Admin._payments.index', compact('MainTitle', 'SubTitle'));
    }
    /**
     * Display a listing of the resource in DT.
     *
     * @return Json Object
     */
    public function payments()
    {
        $records = Payment::all();
        return Datatables::of($records)->make(true);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $MainTitle = 'Payments';
        $SubTitle = 'Add';
        return view('Admin._payments.create', compact('MainTitle', 'SubTitle'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PaymentRequest $request)
    {
        DB::beginTransaction();
        try {
            $image = UploadFile::UploadSinglelFile($request->file('image'), 'payments');
            Payment::create([
                'en' => [
                    'name' => $request->input('name_en'),
                    'note' => $request->input('note_en'),
                ],
                'ar' => [
                    'name' => $request->input('name_ar'),
                    'note' => $request->input('note_ar'),
                ],
                'additional_percentage' => $request->input('additional_percentage'),
                'payment_type' => $request->input('payment_type'),
                'image' => $image,
            ]);
            DB::commit();
            session()->flash('_added', 'Payment  Created Succssfuly');
            return redirect()->route('payments.index');
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
        $MainTitle = 'Payments';
        $SubTitle = 'Edit';
        $payment = Payment::findOrFail($id);
        return view('Admin._payments.edit', compact('payment', 'MainTitle', 'SubTitle'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PaymentRequest $request, $id)
    {
        Db::beginTransaction();
        try {
            $payment = Payment::findOrFail($id);
            if ($request->file('image')) {
                //Remove old file
                UploadFile::RemoveFile($payment->image);
                $payment->image = UploadFile::UploadSinglelFile($request->file('image'), 'payments');
            }
            $payment->translate('en')->name = $request->input('name_en');
            $payment->translate('ar')->name = $request->input('name_ar');
            $payment->translate('en')->note = $request->input('note_en');
            $payment->translate('ar')->note = $request->input('note_ar');
            $payment->additional_percentage = $request->input('additional_percentage');
            $payment->save();
            DB::commit();
            session()->flash('_updated', 'Payment updated succssfuly');
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
        Db::beginTransaction();
        try {
            $payment = Payment::findOrFail($id);
            $payment->delete();
            DB::commit();
            return response()->json([], 200);
        } catch (\Exception $exception) {
            DB::rollback();
            abort(500);
        }
    }
    
    public function changeStatus($id)
    {
        DB::beginTransaction();
        try {
            // Find the payment by its ID or throw an exception if not found
            $payment = Payment::findOrFail($id);
            // Toggle the status between 0 and 1
            $payment->status = $payment->status == 1 ? 0 : 1;
            
            // Save the updated status
            $payment->save();
            
            // Commit the transaction
            DB::commit();
            
            // Return success response with the updated status
            session()->flash('_updated', 'Payment updated succssfuly');
            return redirect()->back();
        } catch (\Exception $exception) {
            dd($exception);
            // Rollback the transaction in case of an error
            DB::rollback();
            
            // Return a 500 error response
            session()->flash('_error', 'An Error Record Please Try Again');
            return redirect()->back();
        }
    }
}
