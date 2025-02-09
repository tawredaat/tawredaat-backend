@extends('User.mails.master_template_en')
@section('content')

    <tr style='text-align:left;' dir=ltr>
        <td
            style='text-align:left;padding:0;border-collapse:collapse;border-spacing:0px;border:0px none;vertical-align:middle;font-family:"system-ui", sans-serif, Arial, Helvetica !important;padding: 0 20px;'>
            <h2 class="title"
                style='text-align:left;line-height:1.2;margin:0;padding:0;font-size:18px;color:black;font-family:"system-ui", sans-serif, Arial, Helvetica;font-size:14px;text-align:left;margin-top:20px;font-family:"system-ui", sans-serif, Arial, Helvetica !important;'>
                Your new password
            </h2>

            <p class="mid-text"
                style='text-align:left;line-height:1.2;margin:0;padding:0;font-family:"system-ui", sans-serif, Arial, Helvetica;font-size:16px;font-weight:300;text-align:left;line-height:1.7;margin:10px 0;color:#000;font-family:"system-ui", sans-serif, Arial, Helvetica !important;'>
               {{ $order }}
            </p>
        </td>
    </tr>
@endsection
