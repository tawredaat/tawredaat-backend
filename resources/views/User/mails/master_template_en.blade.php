<!DOCTYPE html>
<html lang="en" style="margin:0;padding:0;border:0;outline:0;line-height:1.2;">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <style>
        a:link {
            font-family: "system-ui", sans-serif, Arial, Helvetica;
            color: #0033ff;
            text-decoration: none
        }
    </style>
    <style type="text/css">
        /****** EMAIL CLIENT BUG FIXES - BEST NOT TO CHANGE THESE ********/
        .ExternalClass {
            width: 100%;
        }

        /* Forces Outlook.com to display emails at full width */
        .ExternalClass,
        .ExternalClass p,
        .ExternalClass span,
        .ExternalClass font,
        .ExternalClass td,
        .ExternalClass div {
            line-height: 100%;
        }

        /* Prevents Webkit and Windows Mobile platforms from changing default font sizes. */
        /* Resets all body margins and padding to 0 for good measure */
        /*This resolves the Outlook 07, 10, and Gmail td padding issue. Heres more info: http://www.ianhoar.com/2008/04/29/outlook-2007-borders-and-1px-padding-on-table-cells http://www.campaignmonitor.com/blog/post/3392/1px-borders-padding-on-table-cells-in-outlook-07 */
        /****** END BUG FIXES ********/
        /****** RESETTING DEFAULTS, IT IS BEST TO OVERWRITE THESE STYLES INLINE ********/
        /*The "body" is defined here for Yahoo Beta because it does not support your body tag. Instead, it will create a wrapper div around your email and that div will inherit your embedded body styles. The "#body_style" is defined for AOL because it does not support your embedded body definition nor your body tag, we will use this class in our wrapper div. The "min-height" attribute is used for AOL so that your background does not get cut off if your email is short. We are using universal styles for Outlook 2007, including them in the wrapper will not effect nested tables*/
        /* ...and seriously, never use p tags - outlook.com will drive you insane with its insistence on adding a 1.35em bottom margin (thanks Microsoft!) Use span to mark text areas, br's for spacing, and the line-height on html, body to set the height of those br's */
        /* A more sensible default for H1s */
        /* blue links */
        a[x-apple-data-detectors] {
            color: inherit !important;
            text-decoration: none !important;
            font-size: inherit !important;
            font-family: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
        }

        /* Products table */
        @media screen and (max-width: 600px) {
            .list-item {
                font-size: 14px;
                margin: 0 8px;
            }
        }

        @media screen and (max-width: 400px) {}
    </style>
</head>

<body
    style='-webkit-text-size-adjust:none;-ms-text-size-adjust:none;border:0;outline:0;background:#fff;min-height:1000px;color:#000;font-family:"system-ui", sans-serif, Arial, Helvetica;font-size:14px;line-height:1.2;margin:0;padding:0;background-color:#f6f9fc;direction:ltr;'>

    <?php
    
    $setting = App\Models\Setting::first();
    $logo_alt = $setting->logo_alt;
    $site_logo = $setting->site_logo;
    $facebook_link = $setting->facebook;
    $instagram_link = $setting->insta;
    $linkedin_link = $setting->linkedin;
    $company_name = config('global.used_app_name');
    $used_phone_number = config('global.used_phone_number');
    $used_email = config('global.used_sent_from_email');
    ?>
    <p
        style='line-height:1.2;margin:0;padding:0;font-family:"system-ui", sans-serif, Arial, Helvetica;font-family:"system-ui", sans-serif, Arial, Helvetica !important;' />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=system-ui:wght@300;400;500;700;800&display=swap"
        rel="stylesheet">
    </p>
    <title>{{ $company_name }}</title>
    <table class="outer" align="center"
        style='text-align:left;border-spacing:0;padding:0;margin:0 auto;width:100%;max-width:600px;font-family:"system-ui", sans-serif, Arial, Helvetica;background-color:#fff;text-align:center;'>
        <tr>
            <td
                style='padding:0;border-collapse:collapse;border-spacing:0px;border:0px none;vertical-align:middle;font-family:"system-ui", sans-serif, Arial, Helvetica !important;'>
                <table width="100%" style="border-spacing:0;padding:0;width:100%;">
                    <!-- HEADER -->
                    <tr>
                        <td>
                            <img src="{{ asset('images/solid-color-tawredaat.png') }}" />
                        </td>
                    </tr>
                    <tr>
                        <td class="banner"
                            style='padding:0;border-collapse:collapse;border-spacing:0px;border:0px none;vertical-align:middle;height:100px;font-family:"system-ui", sans-serif, Arial, Helvetica !important;'>
                            <a href="{{ url('api/home') }}" class="tawredaat-style"
                                style='line-height:1.2;margin:0;padding:0;font-family:"system-ui", sans-serif, Arial, Helvetica;text-decoration:none;font-family:"system-ui", sans-serif, Arial, Helvetica !important;'>
                                <img src="{{ asset('storage/' . $site_logo) }}" alt="{{ $logo_alt }}"
                                    style='line-height:1.2;margin:0;padding:0;display:block;
                                    outline:none;line-height:100%;outline:none;text-decoration:none;vertical-align:bottom;border:0;border:0 none;max-width:100%;max-height:100%;object-fit:contain;font-family:"system-ui", sans-serif, Arial, Helvetica !important;display: inline-block;
                                     margin: 20px;'></a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td
                style='padding:0;border-collapse:collapse;border-spacing:0px;border:0px none;vertical-align:middle;font-family:"system-ui", sans-serif, Arial, Helvetica !important;'>
                <table style="border-spacing:0;padding:0;width:100%;margin-bottom: 30px;">
                    <tr>
                        <td colspan="4"
                            style='padding:0;border-collapse:collapse;border-spacing:0px;border:0px none;vertical-align:middle;font-family:"system-ui", sans-serif, Arial, Helvetica !important;'>
                            <hr size="1" color="#e5e5e5"
                                style='line-height:1.2;margin:0;padding:0;margin:7px 0;font-family:"system-ui", sans-serif, Arial, Helvetica !important;'>
                        </td>
                    </tr>
                    <tr>

                    </tr>
                    <tr>
                        <td colspan="4"
                            style='padding:0;border-collapse:collapse;border-spacing:0px;border:0px none;vertical-align:middle;font-family:"system-ui", sans-serif, Arial, Helvetica !important;'>
                            <hr size="1" color="#e5e5e5"
                                style='line-height:1.2;margin:0;padding:0;margin:7px 0;font-family:"system-ui", sans-serif, Arial, Helvetica !important;'>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <!-- MAIL CONTENT -->
        <tr style="text-align:left;">
            <td
                style='text-align:left;
                padding:0;border-collapse:collapse;
                border-spacing:0px;border:0px none;
                vertical-align:middle;font-family:"system-ui",
                 sans-serif, Arial, Helvetica !important;padding: 0 20px;'>
                <h2 class="title"
                    style='line-height:1.2;margin:0;padding:0;font-size:18px;color:black;
                    font-family:"system-ui", sans-serif, Arial, Helvetica;font-size:14px;
                    text-align:left;margin-top:20px;
                    font-family:"system-ui", sans-serif, Arial, Helvetica !important;
                    text-align:left;'>
                    {{ $subject ?? '' }}
                </h2>
                <p class="hellow-text"
                    style='line-height:1.2;margin:0;padding:0;font-family:"system-ui", sans-serif, Arial, Helvetica;font-size:14px;font-weight:500;text-align:left;margin:20px 0 10px;color:#000;font-family:"system-ui", sans-serif, Arial, Helvetica !important;'>
                    Hello {!! $user_name ?? '' !!},
                </p>
                <div style="text-align:left;">
                    @yield('content')
                </div>
            </td>
        </tr>

        <tr>
            <td
                style='padding:0;border-collapse:collapse;border-spacing:0px;border:0px none;vertical-align:middle;font-family:"system-ui", sans-serif, Arial, Helvetica !important;text-align: left; padding: 40px 20px;'>
                <p class="sml-text"
                    style='line-height:1.2;margin:0;padding:0;font-family:"system-ui", sans-serif, Arial, Helvetica;font-size:12px;font-weight:300;text-align:left;line-height:1.63;margin-bottom:10px;color:#5c5c5c;font-family:"system-ui", sans-serif, Arial, Helvetica !important;'>
                    Best Regards, </p>
                <img style='line-height:1.2;margin:0;padding:0;display:block;border:0 none;outline:none;line-height:100%;outline:none;text-decoration:none;vertical-align:bottom;border:0;font-family:"system-ui", sans-serif, Arial, Helvetica !important;width: 100px;'
                    src="{{ asset('storage/' . $site_logo) }}" alt="{{ $logo_alt }}">
            </td>
        </tr>
        <!-- FOOTER -->
        <tr>
            <td class="tawredaat-style"
                style='padding:0;border-collapse:collapse;border-spacing:0px;
                border:0px none;vertical-align:middle;
                font-family:"system-ui", sans-serif, Arial, Helvetica !important;
                      margin: 20px 0; background-color: {{ config('global.used_app_color', '') }};
            padding: 20px;color: #fff;
            text-align: left;
                    ;'>
                <p
                    style='line-height:1.2;margin:0;padding:0;font-family:"system-ui", sans-serif, Arial, Helvetica;font-family:"system-ui", sans-serif, Arial, Helvetica !important;
              font-size: 12px;
              font-weight: 300;
              text-align: left;
              line-height: 1.63;
              color: #fff;
              margin-bottom: 12px;
              text-align:left;'>
                    If you have any questions, do not hesitate to contact us at out customer service number
                    <a href="tel:{{ $used_phone_number }}" class="tawredaat-style"
                        style='line-height:1.2;margin:0;padding:0;font-family:"system-ui", sans-serif, Arial, Helvetica;text-decoration:none;font-family:"system-ui", sans-serif, Arial, Helvetica !important;font-weight: 500; color: #fff;'>
                        {{ $used_phone_number }}</a>
                </p>
                <p
                    style='line-height:1.2;margin:0;padding:0;font-family:"system-ui", sans-serif, Arial, Helvetica;font-family:"system-ui", sans-serif, Arial, Helvetica !important;
              font-size: 12px;
              font-weight: 300;
              text-align: left;
              line-height: 1.63;
              color: #fff;
              margin-bottom: 12px;'>
                    Or email us at
                    <a href="mailto:{{ $used_email }}" class="tawredaat-style"
                        style='line-height:1.2;margin:0;padding:0;font-family:"system-ui", sans-serif, Arial, Helvetica;text-decoration:none;font-family:"system-ui", sans-serif, Arial, Helvetica !important;font-weight: 500; color: #fff;'>
                        {{ $used_email }}</a>
                </p>
                <!-- COPYRIGHT -->
                <table style="border-spacing:0;padding:0;width:100%;border-spacing: 0px 0px;">
                    <tr>
                        <td
                            style='padding:0;border-collapse:collapse;border-spacing:0px;border:0px none;vertical-align:middle;font-family:"system-ui", sans-serif, Arial, Helvetica !important;'>
                            <!-- COL 1 -->
                            <table
                                style="border-spacing:0;padding:0;width:100%;
                    display: inline-block;
                    width: 220px;
                    vertical-align: middle;
                    margin-top: 10px;
                  ;">
                                <tr class="tawredaat-style">
                                    <td
                                        style='padding:0;border-collapse:collapse;border-spacing:0px;
                                        border:0px none;vertical-align:middle;
                                        font-family:"system-ui", sans-serif, Arial, Helvetica !important;font-size: 12px;
                                         '>
                                        All rights reserved © Company {{ $company_name }}
                                    </td>
                                </tr>
                            </table>
                            <!-- COL 2 -->
                            <table class="tawredaat-style"
                                style="border-spacing:0;padding:0;width:100%;
                    display: inline-block;
                    width: 220px;
                    vertical-align: middle;
                    margin-top: 10px;
                  ;">
                                <tr class="tawredaat-style">
                                    <td
                                        style='padding:0;border-collapse:collapse;border-spacing:0px;border:0px none;vertical-align:middle;font-family:"system-ui", sans-serif, Arial, Helvetica !important;font-size: 12px; color: #FFF;'>
                                        Follow us on &nbsp;
                                    </td>
                                    <td
                                        style='padding:0;border-collapse:collapse;border-spacing:0px;border:0px none;vertical-align:middle;font-family:"system-ui", sans-serif, Arial, Helvetica !important;'>
                                        <a href="{{ $facebook_link }}" target="_blank" class="tawredaat-style"
                                            style='line-height:1.2;margin:0;padding:0;font-family:"system-ui", sans-serif, Arial, Helvetica;text-decoration:none;font-family:"system-ui", sans-serif, Arial, Helvetica !important;display: inline-block; margin-right: 5px;'><img
                                                src="{{ asset('images/facebook.png') }}" alt="facebook logo"
                                                style='line-height:1.2;margin:0;padding:0;display:block;outline:none;line-height:100%;outline:none;text-decoration:none;vertical-align:bottom;border:0;border:0 none;font-family:"system-ui", sans-serif, Arial, Helvetica !important;width: 23px;'></a>
                                        <a href="{{ $instagram_link }}" target="_blank" class="tawredaat-style"
                                            style='line-height:1.2;margin:0;padding:0;font-family:"system-ui", sans-serif, Arial, Helvetica;text-decoration:none;font-family:"system-ui", sans-serif, Arial, Helvetica !important;display: inline-block; margin-right: 5px;'><img
                                                src="{{ asset('images/instagram.png') }}" alt="instagram logo"
                                                style='line-height:1.2;margin:0;padding:0;display:block;outline:none;line-height:100%;outline:none;text-decoration:none;vertical-align:bottom;border:0;border:0 none;font-family:"system-ui", sans-serif, Arial, Helvetica !important;width: 23px;'></a>
                                        <a href="{{ $linkedin_link }}" target="_blank" class="tawredaat-style"
                                            style='line-height:1.2;margin:0;padding:0;font-family:"system-ui", sans-serif, Arial, Helvetica;text-decoration:none;font-family:"system-ui", sans-serif, Arial, Helvetica !important;display: inline-block; margin-right: 5px;'><img
                                                src="{{ asset('images/linkedin.png') }}" alt="linkedin logo"
                                                style='line-height:1.2;margin:0;padding:0;display:block;outline:none;line-height:100%;outline:none;text-decoration:none;vertical-align:bottom;border:0;border:0 none;font-family:"system-ui", sans-serif, Arial, Helvetica !important;width: 23px;'></a>
                                    </td>
                                </tr>
                            </table>
                            <!-- COL 3 -->
                            <table
                                style="border-spacing:0;padding:0;width:100%;
                    display: inline-block;width: 110px;vertical-align: middle;
                    margin-top: 10px;">
                                <tr>
                                    <td
                                        style='padding:0;border-collapse:collapse;border-spacing:0px;border:0px none;vertical-align:middle;font-family:"system-ui", sans-serif, Arial, Helvetica !important;'>
                                        {{-- <a href="{{ route('users.privacyPolicy') }}"
                                            style='line-height:1.2;margin:0;padding:0;color:#0033ff;font-family:"system-ui", sans-serif, Arial, Helvetica;text-decoration:none;font-family:"system-ui", sans-serif, Arial, Helvetica !important;
                          font-size: 12px;
                          text-decoration: underline;
                          color: #fff;
                        ;'>سياسة
                                            الخصوصية</a> --}}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
