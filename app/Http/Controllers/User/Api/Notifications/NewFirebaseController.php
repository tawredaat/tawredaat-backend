<?php
namespace App\Http\Controllers\User\Api\Notifications;
use App\Http\Controllers\Controller;

class NewFirebaseController extends Controller
{
    public function sendIOSNotification($tokens,$json,$type,$id)
    {
        if (is_array($tokens))
            $tokenIds = $tokens;
        else
            $tokenIds = [$tokens];

        $url = "https://fcm.googleapis.com/fcm/send";
        $serverKey = 'AAAAkqt_arY:APA91bFWMpAdPqOXHCDmS4su2-Y3PGSkodxizRcjIErUMTePueGMsNcIPp4F68OoCuvk1QnaEioNo_LfO-TEGHo9OmN_NpdKOndPQ54ZGJl-BOAsh71y44NP4WFiPTCk_57ApuA6eQBc';
        $data['order'] = intval($id);
        $data['type'] = intval($type);
        $arrayToSend = array('content_available' => true, 'registration_ids' => $tokenIds,'data' => $data,'notification' => $json,'priority'=>'high');
        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: key='. $serverKey;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($arrayToSend));
        curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //Send the request
        $result = curl_exec($ch);
        if ($result === FALSE)
        {
            die('FCM Send Error: ' . curl_error($ch));
        }
        $result = json_decode($result,true);
        //Close request
        curl_close($ch);
        $response['firebase'] = $result;
        $response['json'] = $arrayToSend;
        return $response;
        //return $result;
    }

    public function sendAndroidNotification($tokens,$json)
    {
        if (is_array($tokens))
            $tokenIds = $tokens;
        else
            $tokenIds = [$tokens];

        define('SERVER_KEY', 'AAAAkqt_arY:APA91bFWMpAdPqOXHCDmS4su2-Y3PGSkodxizRcjIErUMTePueGMsNcIPp4F68OoCuvk1QnaEioNo_LfO-TEGHo9OmN_NpdKOndPQ54ZGJl-BOAsh71y44NP4WFiPTCk_57ApuA6eQBc' );
        /*$msg = array
        (
            'body'  => $body,
            'title' => $title,
         );*/

        /*$data = array
        (   'type' => $type,
            'id' => $id,
            'body'  => $body,
            'title' => $title,
        );*/

        $fields = array
        (
            'registration_ids'  => $tokenIds,
            //'notification'  => $msg,
            'data' => $json
            //'notification' => $msg
        );

        //$fields = (object) ['registration_ids' => $tokens, 'data' => $data];

        $headers = array
        (
            'Authorization: key=' . SERVER_KEY,
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch,CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch,CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch );

        if ($result === FALSE)
        {
            die('FCM Send Error: ' . curl_error($ch));
        }

        $result = json_decode($result,true);
        curl_close( $ch );

        $response['firebase'] = $result;
        $response['json'] = $fields;
        return $response;
    }

    public function fillAndroidJson($title,$body,$type,$id)
    {
        $json =  array();
        $json['title'] = $title;
        $json['body'] = $body;
        $json['type'] = intval($type);
        $json['id'] = intval($id);
        return $json;
    }

    public function fillIOSJson($title,$body)
    {
        $json['title'] = $title;
        $json['body'] = $body;
        //$json['content_available'] = true;
        $json['sound'] = 'default';
        /*$aps['alert']['title'] = "dddd";
        $aps['alert']['body'] = "fdfdf";
        $json =  array();
        $json['aps'] = $aps;
        $json['aps']['content-available'] = 1;
        $json['aps']['sound'] = "default";
        $json['aps']['mutable-content'] = 1;
        $json['type'] = "memo";*/
        return $json;
    }
}
