<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>ED تم التوصيل</title>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
            href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@100;200;300;400;500;600;700;800;900&display=swap"
            rel="stylesheet"
    />
</head>

<body
        style="font-family: 'Noto Kufi Arabic', sans-serif; background-color: white"
>
<center>
    <table class="main" width="100%" style="background-color: white">
        <tr class="top-section" style="width: 100%">
            <td>
                <img
                        class="character-image"
                        style="width: 270px; padding-left: 10px"
                        src="https://i.ibb.co/THQdQ7T/delivered.png"
                />
            </td>
            <td
                    class="subject"
                    style="padding-right: 10px"
                    align="right"
                    width="100%"
            >
                <img
                        class="logo"
                        style="width: 250px"
                        src="https://i.ibb.co/7JZz4kJ/logo.png"
                />
                <h2 class="title" style="color: #f25a57; font-size: 1.7rem">
                    تم التوصيل
                </h2>
                <p class="name" style="margin-top: -20px; font-size: 1.5rem">
                    مرحبا ({{$order->user->name}})
                </p>
            </td>
        </tr>

        <tr>
            <td class="paragraph" style="padding-right: 10px" colspan="2">
                <p
                        style="font-size: 1.3rem; text-decoration: none; color: black"
                        dir="rtl"
                        lang="ar"
                >
              <span>
                يسعدنا اخبارك بأنه قد تم توصيل طلبك! تظهر سجلاتنا أنه تم تسليم
                الطلب في
              </span>
                    <b>[<?php echo date('Y-m-d H:i:s'); ?>].</b>

                    <br />

                    <span>
                إذا كانت لديك أي شكوى أو ملاحظة بشأن التسليم أو المنتج،
              </span>
                    <br />
                    <span>يرجى الإتصال على</span>
                    <b dir="ltr" lang="en">[0 102 902 0807]</b> <span>أو</span>
                    <b
                            dir="rtl"
                            lang="en"
                            style="text-decoration: none; color: black"
                    >
                        [info@tawredaat.com].
                    </b>
                </p>
            </td>
        </tr>

        <tr class="footer">
            <td align="center" colspan="2">
                <p
                        class="footer-text"
                        style="
                font-size: 1.3rem;
                background-color: rgb(110, 110, 110);
                color: white;
                display: inline-block;
                padding: 10px 40px;
                margin-top: 50px;
                font-weight: bold;
                border-radius: 15px;
                text-decoration: none;
              "
                >
                    إذا كانت لديك اسئلة حول طلبك، فيرجى الاتصال بفريق خدمة العملة على
                    <span dir="ltr" lang="en">[0 102 902 0807]</span> أو
                    <span
                            dir="ltr"
                            lang="en"
                            style="text-decoration: none; color: white"
                    >[info@tawredaat.com]</span
                    >٠
                </p>
            </td>
        </tr>

        <tr>
            <td class="bottom-buttons" align="center" colspan="2">
                <a
                        class="bottom-buttons-link"
                        style="
                margin-left: 40px;
                color: #f25a57;
                width: 130px;
                text-decoration: none;
                font-family: 'Noto Kufi Arabic', sans-serif;
              "
                        href="https://tawredaat.com/"
                >الشروط و الاحكام</a
                >

                <a
                        class="bottom-buttons-link"
                        style="
                color: #f25a57;
                width: 80px;
                text-decoration: none;
                font-family: 'Noto Kufi Arabic', sans-serif;
              "
                        href="https://tawredaat.com/"
                >الأسئلة الشائعة</a
                >
            </td>
        </tr>
    </table>
</center>
</body>
</html>
