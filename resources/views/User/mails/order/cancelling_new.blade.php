<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>تأكيد الطلب</title>

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
                        src="https://i.ibb.co/7KL0GX9/confirmation.png"
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
                    تاكيد الطلب
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
                جاري حالياً تأكيد طلبك. ستتلقى بريداً إلكترونياً أخر بمجرد
                التأكيد على توفر كل البنود و استعدادها للشحن.
              </span>
                    <br />
                    <span>
                و سنرسل إليك بريداً إلكترونياً أخر يحتوي على تفاصيل التتبع و أي
                معلومات أخرى حول طلبك رقم
              </span>
                    <b>[{{$order->id}}#].</b>
                </p>
            </td>
        </tr>

        <tr>
            <td align="right" colspan="2" style="padding-right: 10px">
                <a href="https://tawredaat.com/">
                    <button
                            style="
                  padding: 5px 22px;
                  border: none;
                  border-radius: 15px;
                  background-color: #ebebeb;
                "
                    >
                <span
                        style="
                    font-size: 1.3rem;
                    font-family: 'Noto Kufi Arabic', sans-serif;
                    color: #f25a57;
                    font-weight: bold;
                  "
                >
                  تتبع الطلب
                </span>
                        <img
                                class="location"
                                style="width: 25px; vertical-align: middle"
                                src="https://i.ibb.co/0nQ65yw/location.png"
                        />
                    </button>
                </a>
            </td>
        </tr>

        <tr align="center">
            <td colspan="2">
                <table width="100%" style="border-spacing: 10px 25px">
                    <tr align="right">
                        <td
                                style="
                    background-color: #f25a57;
                    color: white;
                    font-weight: bold;
                    padding: 10px 10px;
                  "
                        >
                            تاريخ الطلب: <span><?php echo date('Y-m-d H:i:s'); ?></span>
                        </td>
                        <td
                                style="
                    background-color: #f25a57;
                    color: white;
                    font-weight: bold;
                    padding: 10px 10px;
                  "
                        >
                            رقم الطلب: <span>{{$order->id}}</span>
                        </td>
                    </tr>

                    <tr align="right">
                        <td
                                style="
                    background-color: #f25a57;
                    color: white;
                    font-weight: bold;
                    padding: 10px 10px;
                  "
                        >
                            <span dir="ltr" lang="ar">{{$order->payment->name}}  :</span>طريقة الدفع
                        </td>
                        <td
                                style="
                    background-color: #f25a57;
                    color: white;
                    font-weight: bold;
                    padding: 10px 10px;
                  "
                        >
                            :معلومات الشحن
                        </td>
                    </tr>

                    <tr align="right">
                        <td></td>
                        <td style="font-weight: bold">الاسم: {{$order->user->name}}</td>
                    </tr>

                    <tr align="right">
                        <td></td>
                        <td style="font-weight: bold">
                            العنوان: {{ $order->userAddress->apartment . ' شقة' }}, {{ $order->userAddress->floor . ' الدور' }}, {{ $order->userAddress->street }}, {{ $order->userAddress->area }}
                        </td>
                    </tr>

                    <tr style="height: 20px">
                        <td></td>
                        <td></td>
                    </tr>

                    <tr align="right">
                        <td
                                colspan="2"
                                style="
                    background-color: #f25a57;
                    color: white;
                    font-weight: bold;
                    padding: 10px 10px;
                  "
                        >
                            :تفاصيل الطلب
                        </td>
                    </tr>
                    @foreach($order->items as $item)
                        <tr align="right" style="background-color: #f9f9f9">
                            <td>
                                <table>

                                    <tr>
                                        <td align="right">
                                            <p style="margin: 0; padding-right: 15px">
                                                {{$item->shopProduct->name}}                        </p>
                                            <p style="margin: 0; padding-right: 15px">
                          <span style="color: #f25a57; font-weight: bold">
                            <span dir="rtl" lang="ar">جنيه</span>
                            <span dir="ltr" lang="en">{{$item->shopProduct->new_price}}</span>
                          </span>
                                                <span
                                                        style="
                              text-decoration: line-through;
                              color: #969696;
                            "
                                                >
                            <span dir="rtl" lang="ar">جنيه</span>
                            <span dir="ltr" lang="en">{{$item->shopProduct->new_price}}</span>
                          </span>
                                            </p>
                                            <p style="margin: 0; padding-right: 15px">
                          <span style="color: #5d5d5d; font-size: large">
                            <span dir="ltr" lang="en">{{$item->quantity}}</span>
                            <span dir="rtl" lang="ar">الكمية:</span>
                          </span>
                                            </p>
                                            <p style="margin: 0; padding-right: 15px">
                          <span style="color: #5d5d5d; font-size: large">
                            <span dir="rtl" lang="ar">جنيه</span>
                            <span dir="ltr" lang="en">{{$order->subtotal}}</span>
                            <span dir="rtl" lang="ar">الاجمالي:</span>
                          </span>
                                            </p>
                                        </td>
                                        <td align="right" style="width: 25%">
                                            <img
                                                    src="https://i.ibb.co/j6S4c5R/prod1.png"
                                                    width="100%"
                                            />
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr align="right">
                            <td
                                    colspan="2"
                                    style="
                    background-color: #f25a57;
                    color: white;
                    font-weight: bold;
                    padding-right: 30px;
                    width: 50%;
                  "
                            >
                                <p>الاجمالي: {{$order->subtotal}} جنيه مصري</p>
                                <p>سعر التوصيل: {{$order->delivery_charge}} جنيه مصري</p>
                                <p style="font-size: larger">
                                    الاجمالي بالشحن: {{$order->total}} جنيه مصري
                                </p>
                            </td>
                        </tr>
                    @endforeach
                </table>
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
                >
                    الشروط و الاحكام
                </a>

                <a
                        class="bottom-buttons-link"
                        style="
                color: #f25a57;
                width: 80px;
                text-decoration: none;
                font-family: 'Noto Kufi Arabic', sans-serif;
              "
                        href="https://tawredaat.com/"
                >
                    الأسئلة الشائعة
                </a>
            </td>
        </tr>
    </table>
</center>
</body>
</html>
