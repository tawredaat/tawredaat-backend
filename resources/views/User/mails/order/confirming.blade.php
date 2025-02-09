@extends('User.mails.new_master_template', [
    'image_path' =>
        //'images/emails-images/order-confirming-without-background.png',
        'images/emails-images/shipping-track-without-background.png',
    'image_alt' => 'confirming',
])
@section('content')
    <div dir="rtl" style="text-align: right;">
        <p style="text-align: right;">
            جاري حاليا تأكيد طلبك. ستتلقى بريدا إلكترونيا آخر بمجرد التأكيد على توفر كل البنود واستعدادها للشحن وسنرسل إليك
            بريدا إلكترونيا آخر يحتوي على تفاصيل التتبع وأي معلومات أخرى حول طلبك رقم {{ $order->id }} #</p>

        @include('User.mails.order.details.track-order-form', [
            'order_user_email' => $order->user->email,
            'order_id' => $order->id,
        ])
        <br>

        @include('User.mails.order.details.order_new_design', ['order' => $order])
    </div>
@endsection
