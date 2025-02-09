@extends('User.mails.master_template_en')
@section('content')
    <tr>
        <td valign="top" class="side title"
            style="border-collapse: collapse;border: 0;margin: 0;padding: 20px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 18px;line-height: 26px;vertical-align: top;background-color: white;border-top: none; padding-top: 0;">
            <table
                style="font-weight: normal;border-collapse: collapse;border: 0;margin: 0;padding: 0;font-family: Arial, sans-serif; width : 100%">
                <tr>
                    <td class="top-padding"
                        style="    border: 1px solid gray;
                                    margin: 16px 0;
                                    display: block;
                                    padding: 0;">
                    </td>
                </tr>
                <tr>
                    <td class="text"
                        style="border-collapse: collapse;border: 0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 18px;line-height: 26px;">
                        <div class="mktEditable" id="main_text">
                            <p style="margin : 0;font-size: 15px;">New order has been placed. Check
                                admin portal for more details !</p>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td
                        style="background : #EEEEEE; font-size: 17px; font-weight : bold; padding : 6px; border-top: 3px solid  {{ config('global.used_app_color', '') }}; display :block; margin-top: 0;">
                        Order Details </td>
                </tr>
            </table>
            <table width="100%" style="border-collapse: collapse;">
                @foreach ($order->items as $item)
                    @if (!is_null($item->shopProduct))
                        <tr style="border-bottom: 3px solid #eee;">
                            <td class="column-detail">
                                <img src="{{ asset('storage/' . $item->shopProduct->image) }}" width="100"
                                    alt="">
                                <div style="display: inline-block; margin-top: 16px;">
                                    <p style="margin : 0;font-size: 17px; color : #23408D;">
                                        {{ $item->shopProduct->name }}</p>
                                    <p style="margin : 0;font-size: 17px; margin-top: 5px;">Sku Code :
                                        {{ $item->shopProduct->sku_code }} | Quantity :
                                        {{ $item->quantity }} /
                                        {{ $item->shopProduct->QuantityType->name }}
                                    </p>
                                </div>
                            </td>
                            <td width="180px" class="column-title" style="margin : 0;font-size: 17px; color : #000;">
                                {{ $item->price }}
                                EGP
                            </td>
                            <td width="180px" class="column-title" style="margin : 0;font-size: 17px; color : #000;">
                                {{ $item->amount }}
                                EGP
                            </td>
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
                            <td width="180px" class="column-title" style="margin : 0;font-size: 17px; color : #000;">
                                {{ $item->amount }}
                                EGP
                            </td>

                        </tr>
                    @endif
                @endforeach
                <tr>
                    <td class="column-detail"
                        style="margin : 0;font-size: 17px; color : #000; text-align: right; padding : 0 10px;">
                        Sub Total</td>
                    <td class="column-title" style="margin : 0;font-size: 17px; color : #000;">
                        {{ $order->subtotal }} EGP</td>
                </tr>
                <tr>
                    <td class="column-detail"
                        style="margin : 0;font-size: 17px; color : #000; text-align: right; padding : 0 10px;">
                        Shipping Fees</td>
                    <td class="column-title" style="margin : 0;font-size: 17px; color : #000;">0.00
                        EGP
                    </td>
                </tr>
                <tr>
                    <td class="column-detail"
                        style="margin : 0;font-size: 17px; color : #000; text-align: right; padding : 0 10px;">
                        Cash on Delivery (COD) Fees</td>
                    <td class="column-title" style="margin : 0;font-size: 17px; color : #000;">0.00
                        EGP
                    </td>
                </tr>
                <tr>
                    <td class="column-detail"
                        style="margin : 0;font-size: 17px; color : #000; text-align: right; padding : 0 10px;">
                        promotional code</td>
                    <td class="column-title" style="margin : 0;font-size: 17px; color : #000;">0.00
                        EGP
                    </td>
                </tr>
                <tr>
                    <td class="column-detail"
                        style="margin : 0;font-size: 17px; color : #000; text-align: right; padding : 0 10px; font-weight: 600; background-color: #dcdcdc;">
                        Grand Total</td>
                    <td class="column-title"
                        style="margin : 0;font-size: 17px; color : #000; font-weight: 600; background-color: #dcdcdc;">
                        {{ $order->total }} EGP</td>
                </tr>
            </table>

    <tr style="padding: 20px; display : block;">
        <td style="font-size: 16px; margin-bottom: 0; margin-bottom: 5px;display: block; font-weight: bold;">
            {{ $order->user->name }}</td>
        <td style="font-size: 16px; margin-bottom: 0; margin-bottom: 5px;display: block;">User Phone:
            {{ $order->user->phone }}</td>
    </tr>
    <tr style="padding: 0 20px; display : block;">
        <td class="top-padding"
            style="border: 1px solid  {{ config('global.used_app_color', '') }};
                                    margin: 20px 0;
                                    margin-top: 0;
                                    display: block;
                                    padding: 0;
                                    ">
        </td>
    </tr>

    </td>
    </tr>
@endsection
