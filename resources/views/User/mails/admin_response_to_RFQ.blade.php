@extends('User.mails.master_template')

@section('content')
    <tr>
        <td
            style='padding:0;border-collapse:collapse;border-spacing:0px;border:0px none;vertical-align:middle;font-family:"system-ui", sans-serif, Arial, Helvetica !important;padding: 0 20px;'>
            <h2 class="title"
                style='line-height:1.2;margin:0;padding:0;font-size:18px;color:black;font-family:"system-ui", sans-serif, Arial, Helvetica;font-size:14px;text-align:right;margin-top:20px;font-family:"system-ui", sans-serif, Arial, Helvetica !important;'>
                تم الرد على طلب عرض السعر بنجاح رقم &nbsp;<span class="display-text"
                    style='font-size:15px;line-height:1.2;margin:0;padding:0;font-family:"system-ui", sans-serif, Arial, Helvetica;font-size:16px;font-weight:700;color:#03f;text-align:right;font-family:"system-ui", sans-serif, Arial, Helvetica !important;'>
                    {{ $rfq->id }}</span>&nbsp;
            </h2>

            <p class="mid-text"
                style='line-height:1.2;margin:0;padding:0;font-family:"system-ui", sans-serif, Arial, Helvetica;font-size:16px;font-weight:300;text-align:right;line-height:1.7;margin:10px 0;color:#000;font-family:"system-ui", sans-serif, Arial, Helvetica !important;'>
                تم الرد على طلبكم بنجاح.
                يمكنك متابعه حاله الطلب من خلال الضغط على
                <a href="{{ url('api/user/rfqs') }}" class="text-link tawredaat-style"
                    style='line-height:1.2;margin:0;padding:0;text-decoration:none;margin:10px 0;font-family:"system-ui", sans-serif, Arial, Helvetica;font-size:16px;font-weight:700;text-decoration:underline;color:#03f;text-align:right;font-family:"system-ui", sans-serif, Arial, Helvetica !important;'>هذا
                    الرابط</a>
            </p>
        </td>
    </tr>
    <tr>
        <td
            style='padding:0;border-collapse:collapse;border-spacing:0px;border:0px none;vertical-align:middle;font-family:"system-ui", sans-serif, Arial, Helvetica !important;padding: 0 20px;'>
            <h2
                style='line-height:1.2;margin:0;padding:0;font-size:18px;color:black;font-family:"system-ui", sans-serif, Arial, Helvetica !important;
              font-size: 16px;
              text-align: right;
              line-height: 1.63;
              margin: 20px 0;
            ;'>
                طلب عرض اسعار:
            </h2>

            <table width="100%" style="border-collapse: collapse;">
                {{-- @foreach ($rfq->attachments as $attachment)
                        <tr style="border-bottom: 3px solid #eee;">
                            <td class="column-detail">
                                <img src="{{ asset('storage/' . $attachment->attachments) }}" width="100"
                                    alt="">
                                <div style="display: inline-block; margin-top: 16px;"></div>
                            </td>
                        </tr>
                    @endforeach --}}
                <tr>
                    <td class="column-detail"
                        style="margin : 0;font-size: 17px; color : #000; text-align: right; padding : 0 10px; font-weight: 600; background-color: #dcdcdc;">
                        Description</td>
                    <td class="column-title"
                        style="margin : 0;font-size: 17px; color : #000; font-weight: 600; background-color: #dcdcdc;">
                        {{ $rfq->description }}</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td
            style='padding:0;border-collapse:collapse;border-spacing:0px;border:0px none;vertical-align:middle;font-family:"system-ui", sans-serif, Arial, Helvetica !important;padding: 10px 20px;'>
            <!-- expired time -->
            {{-- <p
                    style='line-height:1.2;margin:0;padding:0;font-family:"system-ui", sans-serif, Arial, Helvetica;font-family:"system-ui", sans-serif, Arial, Helvetica !important;
              font-size: 16px;
              font-weight: 700;
              line-height: 1.63;
              text-align: right;
              padding: 10px 0;
            ;'>
                    <img src="{{ asset('images/pdf-icon.png') }}" alt="logo this one"
                        style='line-height:1.2;margin:0;padding:0;display:block;border:0 none;outline:none;line-height:100%;outline:none;
                        text-decoration:none;vertical-align:bottom;border:0;font-family:"system-ui", 
                        sans-serif, Arial, Helvetica !important;display: inline-block; padding: 0 3px;'>

                </p> --}}
            <!-- Pay Method -->



            <p
                style='line-height:1.2;margin:0;padding:0;font-family:"system-ui", sans-serif, Arial, Helvetica;font-family:"system-ui", sans-serif, Arial, Helvetica !important;
              font-size: 16px;
              font-weight: 300;
              line-height: 1.63;
              text-align: right;
              margin: 20px 0;
            ;'>
                نرجو ان يحوز عرضنا قبولكم.
            </p>
            <!--   BUTTONS -->
            <table style="width: 100%">
                <tr>
                    <td style="width: 100%">
                        <!-- BUTTON -->
                        {{-- <p style="text-align: center; margin: 20px 0">
                                <a href="{{ route('users.showProfile') . '?view=prices_offers' }}"  class="tawredaat-style"
                                    style='line-height:1.2;margin:0;padding:0;font-family:"system-ui", sans-serif, Arial, Helvetica;text-decoration:none;font-family:"system-ui", sans-serif, Arial, Helvetica !important;
                padding: 14px 40px;
                background-color: #03f;
                color: #fff;
                font-size: 14px;
                font-weight: 700;
                text-decoration: none;
                border-radius: 5px;
              ;'>قبول
                                    العرض</a>
                            </p> --}}
                    </td>
                </tr>
            </table>

        </td>
    </tr>
@endsection
