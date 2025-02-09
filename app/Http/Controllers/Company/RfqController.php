<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\SendResponse;
use App\Mail\RfqReplayFromCompany;
use App\Mail\RfqReplaySent;
use App\Models\BrandCategory;
use App\Models\Category;
use App\Models\CompanyProduct;
use App\Models\Rfq;
use App\Models\RfqCategory;
use App\Models\RfqResponse;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;
class RfqController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $MainTitle = 'RFQS';
        $SubTitle = 'View';

        return view('Company._rfqs.rfqs',compact('MainTitle','SubTitle'));
    }


    public function respondedIndex(){
        $MainTitle = 'Responded RFQS';
        $SubTitle = 'View';

        return view('Company._rfqs.responded_rfqs',compact('MainTitle','SubTitle'));
    }
    /**
     * Display a listing of the resource in DT.
     */
    public function rfqs()
    {
        $categories = Category::where('level','level3')->whereIn('id',BrandCategory::WhereIn('brand_id',CompanyProduct::where('company_id',auth('company')->user()->id)->pluck('brand_id'))->pluck('category_id'))->get();
        $rfq_categories = RfqCategory::whereIn('category_id',$categories)->pluck('rfq_id');
        $rfq_responses = RfqResponse::where('company_id',auth('company')->user()->id)->pluck('rfq_id');
        $records = Rfq::whereIn('id',$rfq_categories)->whereNotIn('id',$rfq_responses)->with('user')->get();
        return Datatables::of($records)->make(true);
    }



    public function respondedRfqs(){
        $categories = Category::where('level','level3')->whereIn('id',BrandCategory::WhereIn('brand_id',CompanyProduct::where('company_id',auth('company')->user()->id)->pluck('brand_id'))->pluck('category_id'))->get();
        $rfq_categories = RfqCategory::whereIn('category_id',$categories)->pluck('rfq_id');
        $rfq_responses = RfqResponse::where('company_id',auth('company')->user()->id)->pluck('rfq_id');
        $records = Rfq::whereIn('id',$rfq_categories)->whereIn('id',$rfq_responses)->with(['user'])->get();

        return Datatables::of($records)->make(true);


    }
    /**
     * Show the form for creating a new resource.
     */

    public function rfqDetails($id){

        $rfq = Rfq::find($id);
        $MainTitle = 'RFQ Details';
        $SubTitle = 'View';
        $categories = Category::where('level','level3')->whereIn('id',BrandCategory::WhereIn('brand_id',CompanyProduct::where('company_id',auth('company')->user()->id)->pluck('brand_id'))->pluck('category_id'))->get();
        $rfq_categories = RfqCategory::with('rfq.user')->where('rfq_id',$id)->whereIn('category_id',$categories)->get();
        return view('Company._rfqs.rfq_details',compact('MainTitle','SubTitle','rfq_categories','id'));

    }

    public function response(SendResponse $request,$rfq_id){

        DB::beginTransaction();
        try {
            $rfq_response = new RfqResponse();
            $rfq_response->rfq_id = $rfq_id;
            $rfq_response->company_id =auth('company')->user()->id ;
            $rfq_response->responseDescription = $request->response;
            $rfq_response->save();
            // change status of rfq

            $rfq = Rfq::find($rfq_id);
            $rfq->status = 1 ;
            $rfq->save();
            DB::commit();

            $user = User::find($rfq->user_id);

            Mail::to($user->email)->send(new RfqReplayFromCompany($user->name));
             Mail::to(auth('company')->user()->company_email)->send(new RfqReplaySent($user->name,auth('company')->user()->company_name));

            session()->flash('_added','Response Sent successfully');
            return redirect()->route('company.rfqs');
        }catch (\Exception $exception) {
            DB::rollback();
            abort(500);
        }


    }
}
