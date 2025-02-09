@extends('User.mails.master_template_en')
@section('content')
    <tr>
        <td valign="top" class="side title"
            style="border-collapse: collapse;border: 0;margin: 0;padding: 20px;-webkit-text-size-adjust: none;
            color: black;font-family: Arial, sans-serif;
            font-size: 18px;line-height: 26px;vertical-align: top;
            background-color: white;border-top: none; padding-top: 0;">
            <table
                style="font-weight: normal;border-collapse: collapse;border: 0;margin: 0;padding: 0;font-family: Arial, sans-serif; width : 100%">
                <tr>
                    <td class="top-padding"
                        style="    border: 1px solid black;
                                    margin: 16px 0;
                                    display: block;
                                    padding: 0;">
                    </td>
                </tr>
                <tr>
                    <td class="text"
                        style="border-collapse: collapse;border: 0;margin: 0;padding: 0;-webkit-text-size-adjust: none;
                        color: black;font-family: Arial, sans-serif;font-size: 18px;line-height: 26px;">
                        <div class="mktEditable" id="main_text">
                            <p dir="ltr" style="margin : 0;font-size: 15px;">
                                New RFQ has been sent. Check admin
                                portal for more details !
                            </p>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td
                        style="background : #EEEEEE; font-size: 17px; font-weight : bold; padding : 6px;
                         border-top: 3px solid {{ config('global.used_app_color', '') }}; display :block; margin-top: 0;">
                        RFQ Details </td>
                </tr>
            </table>
            <table width="100%" style="border-collapse: collapse;">
                @foreach ($rfq->attachments as $attachment)
                    <tr style="border-bottom: 3px solid #eee;">
                        <td class="column-detail">
                            <img src="{{ asset('storage/' . $attachment->attachments) }}" width="100" alt="">
                            <div style="display: inline-block; margin-top: 16px;"></div>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td class="column-detail"
                        style="margin : 0;font-size: 17px; color : #000; text-align: right; padding : 0 10px; font-weight: 600; background-color: #dcdcdc;">
                        Description</td>
                    <td class="column-title"
                        style="margin : 0;font-size: 17px; color : #000; font-weight: 600; background-color: #dcdcdc;">
                        {{ $rfq->description }}</td>
                </tr>
            </table>
    <tr style="padding: 20px; display : block;">
        <td style="font-size: 16px; margin-bottom: 0; margin-bottom: 5px;display: block; font-weight: bold;">
            {{ $rfq->user_name }}</td>
        <td style="font-size: 16px; margin-bottom: 0; margin-bottom: 5px;display: block;">
            User Phone:
            {{ $rfq->phone }}</td>
    </tr>
    <tr style="padding: 0 20px; display : block;">
        <td class="top-padding"
            style="border: 1px solid {{ config('global.used_app_color', '') }};
                                    margin: 20px 0;
                                    margin-top: 0;
                                    display: block;
                                    padding: 0;
                                    ">
        </td>
    </tr>
@endsection
