<?php
namespace App\Http\Controllers\Admin;

use App\Exports\ExportUserRFQs;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RespondUserRfqRequest;
use App\Mail\Admin\AdminResponseToRFQ;
use App\Models\UserRfq;
use App\Models\Rfq;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Setting;
use App\Helpers\UploadFile;

class SupplierController extends Controller
{

    public function index()
    {
        $MainTitle = 'User Rfqs';
        $SubTitle = 'View';
        // $records = RFQ::with(['user', 'attachments'])->select(['id', 'status', 'user_id', 'admin_response', 'created_at'])->orderBy('id', 'desc')->get();
        $records = RFQ::with(['user', 'attachments'])->select(['id', 'user_name' , 'email' , 'phone', 'status', 'created_at'])->orderBy('id', 'desc')->get();
        return view('Admin._rfqs.index', compact('MainTitle', 'SubTitle', 'records'));
    }

    public function show($id)
    {
        $MainTitle = 'User Rfqs';
        $SubTitle = 'Show';
        $rfq = Rfq::findOrFail($id);
        $supported_image = array(
            'gif',
            'jpg',
            'jpeg',
            'png',
        );
        return view('Admin._rfqs.show', compact('MainTitle', 'SubTitle', 'rfq', 'supported_image'));
    }

    public function respond(RespondUserRfqRequest $request)
    {
        $rfq = Rfq::where('status', '!=', 'Rejected')->findOrFail($request->input('rfq'));
        DB::beginTransaction();
        try {
          
          	if ($request->file('attachment'))
            {
              $responseFile =  UploadFile::UploadSinglelFile($request->file('attachment'), 'rfq_responses');
              $rfq->attachment = $responseFile;
            }
            
        	
            $rfq->admin_response = $request->input('response');
            $rfq->status = 'Responsed';
            $rfq->save();
            DB::commit();
			$setting = Setting::first();
            $logo = $setting->site_logo;

            //
          	if($rfq->email)
            {
              {{sendMail($rfq->email,$rfq->user_name,'تم الرد علي عرض سعر',$logo,config('global.used_app_name', 'Tawredaat'),'User.mails.userRfqSent' ,$rfq);}}
              //Mail::to($rfq->email)->send(new AdminResponseToRFQ($rfq));
            }
            
            session()->flash('_added', 'Your response has been sent successfully.');
            return redirect()->route('admins.rfqs.index');
        } catch (\Exception $exception) {
          dd($exception);
            DB::rollback();
            return back()->with('error', 'error occurred. Try again later')->withInput();
        }
    }

    public function reject($id)
    {
        $rfq = Rfq::where('status', '=', 'Not Responsed')->find($id);
        DB::beginTransaction();
        try {
            if (!$rfq) {
                return back()->with('error', 'You can not reject this RFQ');
            }

            $rfq->status = 'Rejected';
            $rfq->save();
            DB::commit();
            return back()->with('_added', 'The RFQ has been rejected succssfuly');
        } catch (\Exception $exception) {
            DB::rollback();
            return back()->with('error', 'error occured. Try again later')->withInput();
        }
    }
  
    public function approve($id)
    {
        $rfq = Rfq::where('status', '=', 'Not Responsed')->find($id);
        DB::beginTransaction();
        try {
            if (!$rfq) {
                return back()->with('error', 'You can not reject this RFQ');
            }

            $rfq->status = 'Responsed';
            $rfq->save();
            DB::commit();
            return back()->with('_added', 'The RFQ has Marked As Responded succssfuly');
        } catch (\Exception $exception) {
            DB::rollback();
            return back()->with('error', 'error occured. Try again later')->withInput();
        }
    }

    public function export()
    {
        try {
            $records = UserRfq::orderBy('id', 'DESC')->get();
            return Excel::download(new ExportUserRFQs($records), 'user_rfqs_data.csv');
        } catch (\Exception $ex) {
            return redirect()->back()->with('error', 'Error occurred, Please try again later.');
        }
    }
}
