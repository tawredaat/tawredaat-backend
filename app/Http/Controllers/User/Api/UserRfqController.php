<?php

namespace App\Http\Controllers\User\Api;

use App\Http\Requests\User\Api\StoreRFQRequest;
use App\Http\Requests\User\Api\StoreUserRFQResponseRequest;
use App\Http\Resources\Collections\UserRfqsCollection;
use App\Http\Resources\UserRfqResource;
use App\Mail\RFQSentNotifcationMail;
use App\Mail\User\NewUserRFQSent;
use App\Models\Rfq;
use App\Models\UserRfqAttachment;
use Illuminate\Http\Request;use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Models\Setting;


class UserRfqController extends BaseResponse
{
    public function index()
    {
        $user = auth('api')->user();
        return $this->response(200, 'User Rfqs', 200, [], 0, [
            'rfqs' => new UserRfqsCollection($user->rfqs),
        ]);
    }

    public function store(StoreRFQRequest $request)
    {   
        DB::beginTransaction();
        try {
            $user = auth('api')->user();

            $rfq = Rfq::create([
                'user_name' => $request->input('user_name'),
                'phone' => $request->input('phone'),
                'email' => $request->input('email'),
                'sender_type' => $request->input('sender_type'),
                'company_name' => $request->input('company_name'),
                'description' => $request->input('description'),
                'rfq_type' => $request->input('rfq_type'),
                'city_id'=> $request->input('city_id'),
                'status' => 'Not Responsed',
            ]);
            if ($request->file('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $path = $file->store('rfqs', 'public');
                    UserRfqAttachment::create([
                        'rfq_id' => $rfq->id,
                        'attachment' => $path,
                    ]);
                }
            }
            $setting = Setting::first();
            $logo = $setting->site_logo;
            $order_to_send_email = $rfq;
            {{sendMail($rfq->email,$rfq->user_name,'تم استلام عرض سعر',$logo,config('global.used_app_name', 'Tawredaat'),'User.mails.storeRfq' ,$order_to_send_email);}}
            {{sendMail(config('global.used_sent_from_email', 'info@tawredaat.com'),"",' تم استلام عرض سعر',$logo,config('global.used_app_name', 'Tawredaat'),'User.mails.storeRfq' ,$order_to_send_email);}}
            //   Mail::to($rfq->email)
            //   ->send(new RFQSentNotifcationMail($rfq));

            // Mail::to(config('global.used_client_email', 'info@tawredaat.com'))
            //     ->send(new RFQSentNotifcationMail($rfq));

            DB::commit();
            return $this->response(200, __('home.yourRequestSent'), 200, [], 0, [
                'rfq' => new UserRfqResource($rfq),
            ]);
        } catch (\Exception $exception) {
            DB::rollback();
            return $this->response(500, $exception->getMessage(), 500);
        }
    }

    public function respond(StoreUserRFQResponseRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = auth('api')->user();
            $rfq = UserRfq::where('user_id', $user->id)->find($request->input('rfq_id'));
            if (!$rfq) {
                return $this->response(101, 'Validation Error', 200, ['RFQ not found.']);
            }

            if ($rfq->status !== 'Responsed') {
                return $this->response(101, 'Validation Error', 200, ['You can not respond to this RFQ at the current status.']);
            }

            $rfq->user_response = $request->input('response');
            $rfq->save();
            DB::commit();
            return $this->response(200, __('home.yourResponseSent'), 200, [], 0, [
                'rfq' => new UserRfqResource($rfq),
            ]);
        } catch (\Exception $exception) {
            DB::rollback();
            return $this->response(500, $exception->getMessage(), 500);
        }
    }
    public function show($id)
    {
        // $rfq = Rfq::where('user_id', $user->id)->find($id);
        $rfq = Rfq::find($id);
        if ($rfq) {
            return $this->response(200, 'RFQ Details', 200, [], 0, [
                'rfq' => new UserRfqResource($rfq),
            ]);
        } else {
            return $this->response(101, 'Validation Error', 200, ['RFQ not found.']);
        }

    }

}