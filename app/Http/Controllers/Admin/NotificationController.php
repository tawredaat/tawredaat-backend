<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\User\Api\Notifications\SendPushNotificationController;
use App\Http\Requests\Admin\StoreNotification;
use App\Models\Notification;
use App\User;
class NotificationController extends Controller
{
    public function index()
    {
        $MainTitle = 'Notifications';
        $SubTitle = 'View';
        $notifications = Notification::select(['id','message','users'])->get();
        return view('Admin._notifications.index', compact('MainTitle', 'SubTitle', 'notifications'));
    }

    public function create()
    {
        $MainTitle = 'Notifications';
        $SubTitle = 'Create';
        $users = User::whereNotNull('firebase_token')->select(['id','name','phone'])->get();
        return view('Admin._notifications.create', compact('MainTitle', 'SubTitle', 'users'));
    }

    public function send(StoreNotification $request)
    {
        DB::beginTransaction();
        try {
            Notification::create([
                'message' => $request->input('message'),
                'users' => $request->input('users') ? json_encode($request->input('users')) : null,
            ]);

            $sendNotify = new SendPushNotificationController();
            User::where('device_type', '!=', 'IOS')->whereNotNull('firebase_token')->when($request->input('users'), function ($query) use ($request) {
                return $query->whereIn('id', $request->input('users'));
            })->chunk(500, function ($users) use ($request, $sendNotify) {
                $sendNotify->sendAndroidNotification('souqkahraba.com', $request->input('message'), $users->pluck('firebase_token')->toArray(), 0, 2);
            });

            User::where('device_type', 'IOS')->whereNotNull('firebase_token')->when($request->input('users'), function ($query) use ($request) {
                return $query->whereIn('id', $request->input('users'));
            })->chunk(500, function ($users) use ($request, $sendNotify) {
                $sendNotify->sendIosNotification(1, 'souqkahraba.com', $request->input('message'), $users->pluck('firebase_token')->toArray());
            });

            session()->flash('_added', 'Notifications has been sent successfully');
            DB::commit();
            return redirect()->route('notifications.view');
        } catch (\Exception $exception) {
            DB::rollback();
            return redirect()->back()->with('error', 'Something went wrong, please try again')->withInput();
        }
    }
}
