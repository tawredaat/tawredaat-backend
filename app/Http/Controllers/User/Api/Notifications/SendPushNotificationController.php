<?php

namespace App\Http\Controllers\User\Api\Notifications;

use App\Http\Controllers\User\Api\BaseResponse;

class SendPushNotificationController extends BaseResponse
{
    public function sendAndroidNotification($title,$message, $userTokens,$id = 0, $type)
    {
        $newFirebaseInstance = new NewFirebaseController();
        $json = $newFirebaseInstance->fillAndroidJson($title,$message,$type,$id);
        return $newFirebaseInstance->sendAndroidNotification($userTokens,$json);
    }

    public function sendIosNotification($type, $title,$message, $userTokens)
    {
        $newFirebaseInstance = new NewFirebaseController();
        $json = $newFirebaseInstance->fillIOSJson($title,$message);
        return $newFirebaseInstance->sendIOSNotification($userTokens,$json,$type,0);
    }
}
