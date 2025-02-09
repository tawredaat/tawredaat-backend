<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\SendResponse;
use App\Models\ProductRfq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\ProductRfqReplayFromCompany;

class ProductRfqController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $MainTitle = 'Products RFQS';
        $SubTitle = 'View';
        $product_rfqs = ProductRfq::where('company_id',auth('company')->user()->id)->get();
        return view('Company._product_rfqs.rfqs',compact('MainTitle','SubTitle','product_rfqs'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function respondrfqs(SendResponse $request,$rfq_id){

        DB::beginTransaction();
        try {
            $rfq_response = ProductRfq::find($rfq_id);
            $rfq_response->message = $request->response;
            $rfq_response->save();
            Mail::to($rfq_response->user->email)->send(new ProductRfqReplayFromCompany($rfq_response->user->name));
            DB::commit();
            session()->flash('_added','Response Sent successfully');
            return redirect()->route('company.product-rfqs');
        }catch (\Exception $exception) {
            DB::rollback();
            abort(500);
        }

    }
}
