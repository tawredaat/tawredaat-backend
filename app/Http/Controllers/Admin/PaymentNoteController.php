<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PaymentNoteRequest;
use App\Models\PaymentNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use App\Helpers\UploadFile;

class PaymentNoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $MainTitle = 'Payment Notes';
        $SubTitle = 'View';
        return view('Admin._payment_notes.index', compact('MainTitle', 'SubTitle'));
    }
    /**
     * Display a listing of the resource in DT.
     *
     * @return Json Object
     */
    public function notes()
    {
        $records = PaymentNote::all();
        return Datatables::of($records)->make(true);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $MainTitle = 'Payment Note Add';
        $SubTitle = 'Add';
        return view('Admin._payment_notes.create', compact('MainTitle', 'SubTitle'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PaymentNoteRequest $request)
    {
        DB::beginTransaction();
        try {
            PaymentNote::create([
                'en' => [
                    'note' => $request->input('note_en'),
                ],
                'ar' => [
                    'note' => $request->input('note_ar'),
                ],
            ]);
            DB::commit();
            session()->flash('_added', 'Payment Note Created Succssfuly');
            return redirect()->route('payment_notes.index');
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
        $MainTitle = 'Payment Note Edit';
        $SubTitle = 'Edit';
        $payment_note = PaymentNote::findOrFail($id);
        return view('Admin._payment_notes.edit', compact('payment_note', 'MainTitle', 'SubTitle'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PaymentNoteRequest $request, $id)
    {
        Db::beginTransaction();
        try {
            $payment_note = PaymentNote::findOrFail($id);
            $payment_note->translate('en')->note = $request->input('note_en');
            $payment_note->translate('ar')->note = $request->input('note_ar');
            $payment_note->save();
            DB::commit();
            session()->flash('_updated', 'Payment Note updated succssfuly');
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
            $payment_note = PaymentNote::findOrFail($id);
            $payment_note->delete();
            DB::commit();
            return response()->json([], 200);
        } catch (\Exception $exception) {
            DB::rollback();
            abort(500);
        }
    }
}
