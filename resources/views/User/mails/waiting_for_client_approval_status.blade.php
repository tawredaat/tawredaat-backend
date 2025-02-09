@extends('User.mails.master_template')
@section('content')
    <tr>
        <td
            style='padding:0;border-collapse:collapse;border-spacing:0px;border:0px none;vertical-align:middle;font-family:"system-ui", sans-serif, Arial, Helvetica !important;padding: 0 20px;'>
            <h2 class="title"
                style='line-height:1.2;margin:0;padding:0;font-size:18px;color:black;font-family:"system-ui", sans-serif, Arial, Helvetica;font-size:14px;text-align:right;margin-top:20px;font-family:"system-ui", sans-serif, Arial, Helvetica !important;'>
                نحن بانتظار موافقتك على الطلب رقم <span class="display-text"
                    style='font-size:15px;line-height:1.2;margin:0;padding:0;font-family:"system-ui", sans-serif, Arial, Helvetica;font-size:16px;font-weight:700;color:#03f;text-align:right;font-family:"system-ui", sans-serif, Arial, Helvetica !important;'>
                    {{ $order->id }}</span>&nbsp;
            </h2>

            <p class="mid-text"
                style='line-height:1.2;margin:0;padding:0;font-family:"system-ui", sans-serif, Arial, Helvetica;font-size:16px;font-weight:300;text-align:right;line-height:1.7;margin:10px 0;color:#000;font-family:"system-ui", sans-serif, Arial, Helvetica !important;'>
                تفاصيل المنتجات في الطلب
            </p>
        </td>
    </tr>
    <tr>
        <td valign="top" class="side title"
            style="border-collapse: collapse;border: 0;margin: 0;padding: 20px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 18px;line-height: 26px;vertical-align: top;background-color: white;border-top: none; padding-top: 0;">

            <table width="100%" style="border-collapse: collapse;">
                @foreach ($order->items as $item)
                    @if (!is_null($item->shopProduct))
                        <tr style="border-bottom: 3px solid #eee;">

                            <td class="column-detail">
                                <img src="{{ asset('storage/' . $item->shopProduct->image) }}" width="100"
                                    alt="">
                                <div style="display: inline-block; margin-top: 16px;">
                                    <p style="margin : 0;font-size: 17px; color : #23408D;">{{ $item->shopProduct->name }}
                                    </p>
                                    <p style="margin : 0;font-size: 17px; margin-top: 5px;">Sku Code :
                                        {{ $item->shopProduct->sku_code }} | Quantity Type :
                                        {{ $item->shopProduct->QuantityType->name }}</p>
                                </div>
                            </td>
                            <td width="180px" class="column-title" style="margin : 0;font-size: 17px; color : #000;">
                                {{ $item->shopProduct->new_price }} EGP</td>

                        </tr>
                    @elseif (!is_null($item->manual_product_name))
                        <tr style="border-bottom: 3px solid #eee;">

                            <td class="column-detail">
                                <img src="" width="100" alt="">
                                <div style="display: inline-block; margin-top: 16px;">
                                    <p style="margin : 0;font-size: 17px; color : #23408D;">
                                        {{ $item->manual_product_name }}
                                    </p>

                                </div>
                            </td>
                            <td width="180px" class="column-title" style="margin : 0;font-size: 17px; color : #000;">
                                {{ $item->price }} EGP</td>

                        </tr>
                    @endif
                @endforeach
                <tr>
                    <td class="column-detail"
                        style="margin : 0;font-size: 17px; color : #000; text-align: right; padding : 0 10px;">الاجمالي
                        الفرعي
                    </td>
                    <td class="column-title" style="margin : 0;font-size: 17px; color : #000;">{{ $order->subtotal }} EGP
                    </td>
                </tr>
                <tr>
                    <td class="column-detail"
                        style="margin : 0;font-size: 17px; color : #000; text-align: right; padding : 0 10px;">
                        مصاريف الشحن
                    </td>
                    <td class="column-title" style="margin : 0;font-size: 17px; color : #000;">{{ $order->delivery_charge }}
                        EGP
                    </td>
                </tr>
                <tr>
                    <td class="column-detail"
                        style="margin : 0;font-size: 17px; color : #000; text-align: right; padding : 0 10px;">
                        مصاريف الدفع عند الاستلام</td>
                    <td class="column-title" style="margin : 0;font-size: 17px; color : #000;">0.00 EGP</td>
                </tr>
                <tr>
                    <td class="column-detail"
                        style="margin : 0;font-size: 17px; color : #000; text-align: right; padding : 0 10px;">الكود
                        الترويجي</td>
                    <td class="column-title" style="margin : 0;font-size: 17px; color : #000;">{{ $order->discount }} EGP
                    </td>
                </tr>
                <tr>
                    <td class="column-detail"
                        style="margin : 0;font-size: 17px; color : #000; text-align: right; padding : 0 10px; font-weight: 600; background-color: #dcdcdc;">
                        الاجمالي</td>
                    <td class="column-title"
                        style="margin : 0;font-size: 17px; color : #000; font-weight: 600; background-color: #dcdcdc;">
                        {{ $order->total }} EGP</td>
                </tr>
            </table>
        </td>
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

    <tr>
        <td>
            <p dir="rtl" style="text-align: center;">اذا كنت توافق على الطلب برجاء الضغط على الزر

            </p>
            <form action="{{ route('client-approved-order', $order->id) }}" target="_blank" method="post">
                @csrf
                <input type="hidden" name="order_id" value="{{ $order->id }}">
                <button
                    style="background-color: {{ config('global.used_app_color', '') }};color:#FFF;
                                   border-radius: 0.8rem;padding: 1rem;
                    type="submit">اوافق</button>
            </form>
        </td>
    </tr>
@endsection
