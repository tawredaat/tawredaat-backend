

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html charset=UTF-8" />
    <style>
        /* PUT ALL CSS IN THE EMAIL <HEAD>

These styles are meant for clients that recognize CSS in the <head>; the email WILL STILL WORK for those that don't. */
        .column-title{background:#eee;text-transform:uppercase;padding:15px 5px 15px 15px;font-size:11px}
        /* .column-detail{border-top:1px solid #eee;border-bottom:1px solid #eee;} */
        #outlook a{padding:0;}
        body{
            /* direction: rtl; */
            width:100% !important; background-color:#a9a9a9;-webkit-text-size-adjust:none; -ms-text-size-adjust:none;margin:0 !important; padding:0 !important;}
        .ReadMsgBody{width:100%;}
        .ExternalClass{width:100%;}
        ol li {margin-bottom:15px;}

        img{height:auto; line-height:100%; outline:none; text-decoration:none;}
        #backgroundTable{height:100% !important; margin:0; padding:0; width:100% !important;}

        p {margin: 1em 0;}

        h1, h2, h3, h4, h5, h6 {color:#222222 !important; font-family:Arial, Helvetica, sans-serif; line-height: 100% !important;}

        table td {border-collapse:collapse;}

        .yshortcuts, .yshortcuts a, .yshortcuts a:link,.yshortcuts a:visited, .yshortcuts a:hover, .yshortcuts a span { color: black; text-decoration: none !important; border-bottom: none !important; background: none !important;}

        .im {color:black;}
        div[id="tablewrap"] {
            width:100%;
            max-width:1000px!important;
        }
        table[class="fulltable"], td[class="fulltd"] {
            max-width:100% !important;
            width:100% !important;
            height:auto !important;
        }

        @media screen and (max-device-width: 430px), screen and (max-width: 430px) {
            .column-title{
                display: block;
                width: 100% !important;
            }
            .column-detail{
                display: block;
                width: 100% !important;
            }
            td[class=emailcolsplit]{
                width:100%!important;
                float:left!important;
                padding-left:0!important;
                max-width:430px !important;
            }
            td[class=emailcolsplit] img {
                margin-bottom:20px !important;
            }
            .contenttable{
                width: 90% !important;
            }
        }
    </style>
</head>
<body link="#2e3f73" vlink="#2e3f73" alink="#2e3f73">
<table class=" main contenttable" align="center" style="font-weight: normal;border-collapse: collapse;border: 0;margin-left: auto;margin-right: auto;padding: 0;font-family: Arial, sans-serif;color: #555559;background-color: white;font-size: 18px;line-height: 26px;width: 1000px;">
    <tr>
        <td class="border" style="border-collapse: collapse;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 18px;line-height: 26px;">
            <table style="font-weight: normal;border-collapse: collapse;border: 0;margin: 0;padding: 0;font-family: Arial, sans-serif;     width: 100%;">
                <tr>
                    <td colspan="4" valign="top" class="image-section"
                        style="border-collapse: collapse;border: 0;margin: 0;padding: 18px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 18px;line-height: 26px;background-color: #F7CB14; text-align: center;">
                        <a href="https://souqkahraba.com/"><img class="top-image" src="{{ asset('storage/'.$site_logo) }}" style="line-height: 1;width: 200px;" alt="{{ config('global.used_app_name', 'Tawredaat') }}"></a>
                    </td>
                </tr>
                <tr>
                    <td valign="top" class="side title" style="border-collapse: collapse;border: 0;margin: 0;padding: 20px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 18px;line-height: 26px;vertical-align: top;background-color: white;border-top: none; padding-top: 0;">
                        <table style="font-weight: normal;border-collapse: collapse;border: 0;margin: 0;padding: 0;font-family: Arial, sans-serif; width : 100%">
                            <tr>
                                <td class="top-padding" style="    border: 1px solid gray;
                                    margin: 16px 0;
                                    display: block;
                                    padding: 0;"></td>
                            </tr>
                            <tr>
                                <td class="text" style="border-collapse: collapse;border: 0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 18px;line-height: 26px;">
                                    <div class="mktEditable" id="main_text">
                                        <p style="color : #23408d; font-size: 30px; font-weight: bold; margin-bottom: 20px; margin-top: 5px;">Your Order has been shipped</p>
                                        <p style="color : #000; font-size: 20px; font-weight: bold; margin-bottom: 0; margin-top: 0;">Hello [{{$order->user->name}}],</p>
                                        <p style="margin : 0;     font-size: 15px; margin-bottom : 30px;">Thank you for shopping on SouqKahraba.com! We are glad to inform you that the following items you purchased have been shipped and will be delivered soon .</p>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="background : #EEEEEE; font-size: 17px; font-weight : bold; padding : 6px; border-top: 3px solid #F7CB14; display :block; margin-top: 0;">Items Shipped Today - Order ID : {{$order->id}}</td>
                            </tr>
                        </table>
                        <table width="100%" style="border-collapse: collapse;">
                            @foreach($order->items as $item)
                            <tr style="border-bottom: 3px solid #eee;">
                                <td class="column-detail">
                                    <img src="{{ asset('storage/'.$item->shopProduct->image) }}" width="100" alt="">
                                    <div style="display: inline-block; margin-top: 16px;">
                                        <p style="margin : 0;font-size: 17px; color : #23408D;">{{$item->shopProduct?$item->shopProduct->name:""}}</p>
                                        <p style="margin : 0;font-size: 17px; margin-top: 5px;">Sku Code : {{$item->shopProduct->sku_code}} | Quantity Type : {{$item->shopProduct->QuantityType?$item->shopProduct->QuantityType->name:'--'}}</p>
                                    </div>
                                </td>
                                <td width="180px" class="column-title" style="margin : 0;font-size: 17px; color : #000;">{{$item->shopProduct->new_price}} EGP</td>
                            </tr>
                            @endforeach
                                <tr>
                                    <td class="column-detail" style="margin : 0;font-size: 17px; color : #000; text-align: right; padding : 0 10px;">Sub Total</td>
                                    <td class="column-title" style="margin : 0;font-size: 17px; color : #000;">{{$order->subtotal}} EGP</td>
                                </tr>
                            <tr>
                                <td class="column-detail" style="margin : 0;font-size: 17px; color : #000; text-align: right; padding : 0 10px;">Shipping Fees</td>
                                <td class="column-title" style="margin : 0;font-size: 17px; color : #000;">0.00 EGP</td>
                            </tr>
                            <tr>
                                <td class="column-detail" style="margin : 0;font-size: 17px; color : #000; text-align: right; padding : 0 10px;">Cash on Delivery (COD) Fees</td>
                                <td class="column-title" style="margin : 0;font-size: 17px; color : #000;">0.00 EGP</td>
                            </tr>
                            <tr>
                                <td class="column-detail" style="margin : 0;font-size: 17px; color : #000; text-align: right; padding : 0 10px;">promotional code</td>
                                <td class="column-title" style="margin : 0;font-size: 17px; color : #000;">0.00 EGP</td>
                            </tr>
                            <tr>
                                <td class="column-detail" style="margin : 0;font-size: 17px; color : #000; text-align: right; padding : 0 10px; font-weight: 600; background-color: #dcdcdc;">Grand Total</td>
                                <td class="column-title" style="margin : 0;font-size: 17px; color : #000; font-weight: 600; background-color: #dcdcdc;">{{$order->total}} EGP</td>
                            </tr>
                            <tr style="padding-top: 10px; display : block;">
                                <td>Important Note: Please be ready to pay a total of <span style="font-weight: bold;">{{$order->total}} EGP</span> to the shipping courier when you receive the shipment</td>
                            </tr>
                        </table>
                <tr style="padding: 0 20px; display : block;">
                    <td style="background : #EEEEEE; font-size: 17px; font-weight : bold; padding : 6px; border-top: 3px solid #F7CB14; display :block; margin-top: 0;">Your Order Details </td>
                </tr>
                <tr style="padding: 20px; display : block;">
                    <td style="font-size: 16px; margin-bottom: 0; margin-bottom: 5px;display: block;">{{$order->address}}</td>
                    <td style="font-size: 16px; margin-bottom: 0; margin-bottom: 5px;display: block; font-weight: bold;">{{$order->user->name}}</td>
                    <td style="font-size: 16px; margin-bottom: 0; margin-bottom: 5px;display: block;">{{$order->user->selectedAddress->area}}, {{$order->user->selectedAddress->country?$order->user->selectedAddress->country->name:'--'}}     </td>
                    <td style="font-size: 16px; margin-bottom: 0; margin-bottom: 5px;display: block;">Street: {{$order->user->selectedAddress->street}}</td>
                    <td style="font-size: 16px; margin-bottom: 0; margin-bottom: 5px;display: block;">Building No: {{$order->user->selectedAddress->building}}</td>

                    <td style="font-size: 16px; margin-bottom: 0; margin-bottom: 5px;display: block;">phone: {{$order->user->phone}}</td>
                </tr>
                <tr style="padding: 0 20px; display : block;">
                    <td style="background : #EEEEEE; font-size: 17px; font-weight : bold; padding : 6px; border-top: 3px solid #F7CB14; display :block; margin-top: 0;">Whats's next?</td>
                </tr>
                <tr style="padding: 20px; display : block;">
                    <td>
                        <ul>
                            <li style="font-size: 18px; margin-bottom: 5px;">Answer your phone as the courier may call to confirm the Delivery time and address</li>
                            <li style="font-size: 18px; margin-bottom: 5px;">make sure you are available at athe address above to receive your order</li>
                            <li style="font-size: 18px; margin-bottom: 5px;">when you receive this shipment, leave feedback so we know how things went</li>
                        </ul>
                    </td>
                </tr>
                <tr style="padding: 0 20px; display : block;">
                    <td class="top-padding" style="border: 1px solid #F7CB14;
                                    margin: 20px 0;
                                    margin-top: 0;
                                    display: block;
                                    padding: 0;
                                    "></td>
                </tr>
                <tr style="padding: 20px; display : block;">
                    <td style="color : #23408d; font-size: 30px; font-weight: bold; margin-bottom: 0; margin-top: 5px;display: block;">Best Regards,</td>
                    <td style="color : #23408d; font-size: 30px; font-weight: bold; margin-bottom: 20px; margin-top: 5px; display: block;">{{ config('global.used_app_name', 'Tawredaat') }} Team</td>
                    <td style="display: block;" colspan="4" valign="top" class="image-section"
                        style="border-collapse: collapse;border: 0;margin: 0;padding: 18px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 18px;line-height: 26px;background-color: #F7CB14; text-align: center;">
                        <a href="https://souqkahraba.com/"><img class="top-image" src="{{ asset('storage/'.$site_logo) }}" style="line-height: 1;width: 300px;" alt="{{ config('global.used_app_name', 'Tawredaat') }}"></a>
                    </td>
                </tr>
                </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
