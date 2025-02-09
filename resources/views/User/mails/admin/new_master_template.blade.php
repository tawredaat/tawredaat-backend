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
    style='-webkit-text-size-adjust:none;-ms-text-size-adjust:none;
    border:0;outline:0;background:#fff;min-height:1000px;
    color:#000;font-family:"system-ui", sans-serif, Arial, Helvetica;
    font-size:14px;line-height:1.2;margin:0;padding:0;
    background-color:#f6f9fc;direction:rtl;'>

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
    $footer_color = 'grey';
    //config('global.used_app_color', '');
    ?>
    <p
        style='line-height:1.2;margin:0;padding:0;font-family:"system-ui", sans-serif, Arial, Helvetica;font-family:"system-ui", sans-serif, Arial, Helvetica !important;' />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=system-ui:wght@300;400;500;700;800&display=swap"
        rel="stylesheet">
    </p>
    <title>{{ $company_name }}</title>
    <table class="outer" align="center"
        style='border-spacing:0;padding:0;margin:0 auto;width:100%;
        max-width:800px;
        font-family:"system-ui", sans-serif, Arial, Helvetica;background-color:#fff;text-align:center;'>


        <tr>
            <td class="banner"
                style="
                padding:0;border-collapse:collapse;border-spacing:0px;
                border:0px none;vertical-align:middle;
                height:100px;font-family:"system-ui",
                sans-serif, Arial, Helvetica !important;">
                <a href="{{ url(config('global.live_home_page', 'https://tawredaat.com/')) }}" class="tawredaat-style"
                    style='line-height:1.2;margin:0;padding:0;font-family:"system-ui", sans-serif, Arial, Helvetica;text-decoration:none;font-family:"system-ui", sans-serif, Arial, Helvetica !important;'>
                    <img src="{{ asset('storage/' . $site_logo) }}" alt="{{ $logo_alt }}"
                        style='float:right;width:250px;line-height:1.2;margin:0;padding:0;display:block;
                                    outline:none;line-height:100%;outline:none;text-decoration:none;vertical-align:bottom;border:0;border:0 none;max-width:100%;max-height:100%;object-fit:contain;font-family:"system-ui", sans-serif, Arial, Helvetica !important;display: inline-block;
                                     margin: 20px;'></a>
            </td>
            <td></td>
        </tr>

        <!-- MAIL CONTENT -->
        <tr>
            <td
                style='padding:0;border-collapse:collapse;border-spacing:0px;border:0px none;vertical-align:middle;font-family:"system-ui", sans-serif, Arial, Helvetica !important;padding: 0 20px;'>
                @if (@isset($image_path))
                    <div style="float:left;background-color: white;">
                        <img style="width: 190px;margin-top:5px;padding-bottom:30px;" src="{{ asset($image_path) }}"
                            alt="{{ $image_alt ?? '' }}">
                    </div>
                @endif
                <h1 class="title"
                    style='color: {{ config('global.used_app_color', '') }};
                    line-height:1.1;margin:0;padding:0;font-size:18px;color:black;
                    font-family:"system-ui", sans-serif, Arial, Helvetica;font-size:14px;
                    text-align:right;margin-top:20px;
                    font-family:"system-ui", sans-serif, Arial, Helvetica !important;'>
                    <p
                        style='color: {{ config('global.used_app_color', '') }};
                    font-size:20px;text-align:right;font-weight:bold;'>
                        {{ $subject ?? '' }}
                    </p>
                </h1>

                <p class="hellow-text"
                    style='line-height:1.2;margin:0;padding:0;font-family:"system-ui", sans-serif, Arial, Helvetica;font-size:14px;font-weight:500;text-align:right;margin:20px 0 10px;color:#000;font-family:"system-ui", sans-serif, Arial, Helvetica !important;'>
                    مرحبا {!! $user_name ?? '' !!}،
                </p>
                @yield('content')
            </td>
        </tr>
        <!-- FOOTER -->
    </table>
</body>

</html>
