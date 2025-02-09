@extends('User.mails.master_template')
@section('content')
    <tr>
        <td
            style='padding:0;border-collapse:collapse;border-spacing:0px;border:0px none;vertical-align:middle;font-family:"system-ui", sans-serif, Arial, Helvetica !important;padding: 0 20px;'>
            <h2 class="title"
                style='line-height:1.2;margin:0;padding:0;font-size:18px;color:black;font-family:"system-ui", sans-serif, Arial, Helvetica;font-size:14px;text-align:right;margin-top:20px;font-family:"system-ui", sans-serif, Arial, Helvetica !important;'>
                تم تغير حالة طلبكم رقم <span class="display-text"
                    style='font-size:15px;line-height:1.2;margin:0;padding:0;font-family:"system-ui", sans-serif, Arial, Helvetica;font-size:16px;font-weight:700;color:#03f;text-align:right;font-family:"system-ui", sans-serif, Arial, Helvetica !important;'>
                    {{ $order->id }}</span>&nbsp;
            </h2>

            <p class="mid-text"
                style='line-height:1.2;margin:0;padding:0;font-family:"system-ui", sans-serif, Arial, Helvetica;font-size:16px;font-weight:300;text-align:right;line-height:1.7;margin:10px 0;color:#000;font-family:"system-ui", sans-serif, Arial, Helvetica !important;'>
                تم تغير حالة طلبكم الى {{ $order->status->translate('ar')->name }}
            </p>
        </td>
    </tr>
@endsection
