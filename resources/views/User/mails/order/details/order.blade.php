<p style="color:black;font-weight: bold;padding:5px;width:100%;text-align:right;">
    تفاصيل الطلب
</p>
<table style="width:100%">
    <thead>
        <th style=" background-color:rgba(220,221,222,255);
              padding:5px;width:50%">
            رقم
            الطلب
            # {{ $order->id }}
        </th>
        <th></th>
        <th style="background-color:rgba(220,221,222,255);
                padding:5px;width:50%">
            تاريخ
            الطلب
            {{ $order->created_at->format('d.m.Y') }}
        </th>
    </thead>
</table>

<p
    style="color:black;margin-top:25px;font-weight: bold;background-color: rgba(220,221,222,255);
              padding:5px;width:100%;text-align:right;">
    المنتجات المطلوبة:
</p>
<div style=" margin-right: 10px;">
    <table style="width:100%">
        <tbody style="width:100%">
            <?php
            $items = $order->items;
            $count = count($items); ?>
            @if ($count == 1)
                <tr>
                    <td colspan="3" style="width:45%;background-color:rgba(230, 224, 224, 0.744);">
                        @include('User.mails.order.details.product', ['item' => $items[0]])
                    </td>
                </tr>
            @else
                @for ($i = 0; $i < $count; $i++)
                    <tr>
                        <td style="width:45%;background-color:rgba(230, 224, 224, 0.744);">
                            @include('User.mails.order.details.product', ['item' => $items[$i]])
                        </td>
                        {{-- <td style="width:5%;"></td>
                    <td style="width:5%;"></td>
                    @if ($i != $count - 1)
                        <td style="width:45%;background-color:rgba(230, 224, 224, 0.744);">
                            @include('User.mails.order.details.product', ['item' => $items[$i + 1]])
                        @else
                        <td style="width:45%;"></td>
                    @endif
                    </td> --}}
                    </tr>
                @endfor
            @endif
            <tr>
                <td colspan=2>
                    <br>
                    <p style="color:black;text-align:right;font-weight:bold;">
                        الاجمالي:
                        {{ $order->subtotal }}
                        جنية مصري
                    </p>
                </td>
            </tr>
        </tbody>
    </table>

    <table style="width:100%">
        <tbody style="width:100%">
            <tr>
                <td>
                    <p
                        style="color:black;margin-top:5px;padding:5px;text-align:right;font-weight:bold;background-color:rgba(220,221,222,255);">
                        معلومات الشحن:
                    </p>
                </td>
            </tr>
            <tr>
                <td>
                    <span style="text-align:right;font-weight:bold;">الاسم:
                    </span>
                    <span>{{ $order->user->name }} </span>
                </td>
            </tr>
            <tr>
                <td>
                    <span style="text-align:right;font-weight:bold;">العنوان:
                    </span>
                    <span>{{ $order->address }} </span>
                </td>
            </tr>
            <tr>
                <td>
                    <span style="text-align:right;font-weight:bold;">معلومات الدفع:
                    </span>
                    <span>{{ $order->payment->translate('ar')->name }} </span>
                </td>
            </tr>
            <tr>
                <td>
                    <span style="text-align:right;font-weight:bold;"> سعر التوصيل:
                    </span>
                    <span>{{ $order->delivery_charge }} جنية مصري </span>
                </td>
            </tr>
            <tr>
                <td>
                    <span style="text-align:right;font-weight:bold;"> إجمالي المطلوب دفعه:
                    </span>
                    <span>{{ $order->total }} جنية مصري </span>
                </td>
            </tr>
            <tr>
                <td>
                    <p
                        style="color:black;margin-top:5px;padding:5px;text-align:right;font-weight:bold;background-color:rgba(220,221,222,255);">
                        حالة الطلب:
                    </p>
                </td>
            </tr>
            <tr>
                <td>
                    <p style="text-align:right;">

                        جاري حاليا تأكيد طلبك. ستتلقى بريدا إلكترونيا آخر بمجرد التأكيد على توفر كل البنود واستعداده
                        للشحن
                        وسنرسل إليك بريدا إلكترونيا آخر يحتوي على تفاصيل التتبع وأي معلومات أخرى حول طلبك رقم
                        {{ $order->id }}
                    </p>
                </td>
            </tr>
        </tbody>
    </table>
</div>
