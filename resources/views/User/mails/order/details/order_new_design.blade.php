<table style="width:100%">
    <thead>
        <th
            style=" color:white;background-color:{{ config('global.used_app_color', '') }};
              padding:5px;width:50%">
            رقم
            الطلب
            # {{ $order->id }}
        </th>
        <th></th>
        <th
            style="color:white;background-color:{{ config('global.used_app_color', '') }};
                padding:5px;width:50%">
            تاريخ
            الطلب
            {{ $order->created_at->format('d.m.Y') }}
        </th>
    </thead>
</table>

<br>

<table style="width:100%">
    <thead>
        <th
            style=" color:white;background-color:{{ config('global.used_app_color', '') }};
              padding:5px;width:50%">
            معلومات الشحن
        </th>
    </thead>
    <tbody>
        <td>
            <p style="text-align: right;font-weight:bold;">الاسم : {{ $order->user->full_name }}</p>
            <p style="text-align: right;font-weight:bold;">العنوان : {{ $order->address }}</p>
            <p style="text-align: right;font-weight:bold;">الهاتف : {{ $order->user->phone }}</p>
        </td>
        
    </tbody>
</table>
<table style="width:100%">
    <thead>
        
        <th
            style="color:white;background-color:{{ config('global.used_app_color', '') }};
                padding:5px;width:50%">
            طريقة الدفع
        </th> 
    </thead>
    <tbody>
       
        <td>
            <p style="text-align: right;font-weight:bold;">الدفع عن طريق:
                {{ $order->payment->translate('ar')->name }}
            </p>
        </td> 
    </tbody>
</table>

<p
    style=" color:#FFF;background-color:{{ config('global.used_app_color', '') }};
              padding:5px;width:98%;text-align:right;margin-right: .5%;">
    تفاصيل الطلب:
</p>
<div style=" margin-right: 10px;">
    <table style="width:100%">
        <tbody style="width:100%">
            <?php
            $items = $order->allItems;
            $count = count($items); ?>
            @for ($i = 0; $i < $count; $i++)
                <tr>
                    <td style="width:100%;background-color:rgba(230, 224, 224, 0.744);">
                        @include('User.mails.order.details.product', ['item' => $items[$i]])
                    </td>
                    
                </tr>
            @endfor

        </tbody>
        <tfoot>
            <tr>

                <td style="width:100%;background-color:{{ config('global.used_app_color', '') }};">
              <!--      <p-->
              <!--          style="color:white;-->
              <!--      background-color:{{ config('global.used_app_color', '') }};-->
              <!--text-align:right;font-weight:bold;">-->
              <!--          الاجمالي للمنتجات -->
              <!--          جنية مصري {{ $order->total }}-->
              <!--      </p>-->
              <!--      <p-->
              <!--          style="color:white;-->
              <!--      background-color:{{ config('global.used_app_color', '') }};-->
              <!--text-align:right;font-weight:bold;">-->
              <!--          الاجمالي للباقات-->
              <!--          جنية مصري {{ $order->bundelsTotal() }}-->
              <!--      </p>-->
              <!--      <p-->
              <!--          style=" color:white;background-color:{{ config('global.used_app_color', '') }};-->
              <!--text-align:right;font-weight:bold;">-->
              <!--          سعر التوصيل:-->
              <!--          جنية مصري {{ $order->delivery_charge }}-->
              <!--      </p>-->
                    <p
                        style=" color:white;background-color:{{ config('global.used_app_color', '') }};
              text-align:right;font-weight:bold;">
                        الاجمالي المنتجات والشحن:
                        جنية مصري {{ $order->total }}
                    </p>
                </td>
            </tr>
        </tfoot>
    </table>
</div>
