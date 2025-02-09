<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\CallbackRequest;
use App\Models\GeneralRfq;
use App\Models\PdfDownload;
use App\Models\ProductRfq;
use App\Models\ViewInformation;
use App\Models\MoreInfo;
use App\Models\WhatsappCall;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource more info btn.
     */
    public function moreInfo(Request $request)
    {
        $MoreInfo = MoreInfo::with(['user'])->when($request->input('start_date') && $request->input('end_date'), function ($query) use ($request) {
            $query->whereBetween('created_at', [Carbon::parse($request->start_date), Carbon::parse($request->end_date)]);
        })->where('company_id', auth('company')->user()->id)->orderBy('created_at', 'desc')->get();
        return view('Company._reports.MoreInfo', compact('MoreInfo'));
    }

    /**
     * Display a listing of the resource Profile Views.
     */
    public function viewInformation(Request $request)
    {
        $informations = ViewInformation::with(['user'])->when($request->input('start_date') && $request->input('end_date'), function ($query) use ($request) {
            $query->whereBetween('created_at', [Carbon::parse($request->start_date), Carbon::parse($request->end_date)]);
        })->where('company_id', auth('company')->user()->id)->orderBy('created_at', 'desc')->get();
        return view('Company._reports.information', compact('informations'));
    }

    /**
     * Display a listing of the resource Call Now Requests.
     */
    public function callbacks(Request $request)
    {
        $callbacks = CallbackRequest::with(['user'])->when($request->input('start_date') && $request->input('end_date'), function ($query) use ($request) {
            $query->whereBetween('created_at', [Carbon::parse($request->start_date), Carbon::parse($request->end_date)]);
        })->where('company_id', auth('company')->user()->id)->orderBy('created_at', 'desc')->get();
        return view('Company._reports.callbacks', compact('callbacks'));
    }

    public function whatsCallbacks(Request $request){
        $callbacks = WhatsappCall::with(['user'])->when($request->input('start_date') && $request->input('end_date'), function ($query) use ($request) {
            $query->whereBetween('created_at', [Carbon::parse($request->start_date), Carbon::parse($request->end_date)]);
        })->where('company_id', auth('company')->user()->id)->orderBy('created_at', 'desc')->get();
        return view('Company._reports.whatscallbacks', compact('callbacks'));

    }

    /**
     * Display a listing of the resource PDF Downloads.
     */
    public function pdfs(Request $request)
    {
        $pdfs = PdfDownload::with(['user'])->when($request->input('start_date') && $request->input('end_date'), function ($query) use ($request) {
            $query->whereBetween('created_at', [Carbon::parse($request->start_date), Carbon::parse($request->end_date)]);
        })->where('company_id', auth('company')->user()->id)->orderBy('created_at', 'desc')->get();
        return view('Company._reports.pdfs', compact('pdfs'));
    }

    /**
     * Display a listing of the resource General RFQs.
     */
    public function generalRfqs(Request $request)
    {
        $general_rfqs = GeneralRfq::with(['user'])->when($request->input('start_date') && $request->input('end_date'), function ($query) use ($request) {
            $query->whereBetween('created_at', [Carbon::parse($request->start_date), Carbon::parse($request->end_date)]);
        })->where('company_id', auth('company')->user()->id)->orderBy('created_at', 'desc')->get();
        return view('Company._reports.general_rfqs', compact('general_rfqs'));
    }

    /**
     * Display a listing of the resource General RFQs Details.
     */
    public function generalRfqDetails($id)
    {
        $generalRfq = GeneralRfq::findOrFail($id);

        $generalRfqMessage = $generalRfq->message;

        return view('Company._reports.general_rfq_details')->with('companyProducts', $generalRfq->products)->with('generalRfqMessage', $generalRfqMessage);
    }

    /**
     * Display a listing of the resource Product RFQs.
     */
    public function productRfqs(Request $request)
    {
        $productRfqs = ProductRfq::with(['user'])->when($request->input('start_date') && $request->input('end_date'), function ($query) use ($request) {
            $query->whereBetween('created_at', [Carbon::parse($request->start_date), Carbon::parse($request->end_date)]);
        })->where('company_id', auth('company')->user()->id)->orderBy('created_at', 'desc')->get();
        return view('Company._reports.product_rfqs')->with('productRfqs', $productRfqs);
    }

    /**
     * Display a listing of the resource Product RFQs Details.
     */
    public function productRfqDetails($id)
    {
        $productRfq = ProductRfq::findOrFail($id);

        $productRfqMessage = $productRfq->message;

        return view('Company._reports.product_rfq_details')->with('companyProduct', $productRfq->companyProduct)->with('productRfqMessage', $productRfqMessage);
    }
}
