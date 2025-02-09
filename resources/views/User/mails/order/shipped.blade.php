@extends('User.mails.new_master_template', [
    'image_path' =>
        //'images/emails-images/order-delivered-without-background.png'
        'images/emails-images/shipping-track-without-background.png',
    'image_alt' => 'shipped',
])
@section('content')
    <div dir="rtl" style="text-align: right;">
        <p style="text-align: right;">
            يسعدنا إخباركم أنه تم شحن طلبك رقم التتبع الخاص بك هو
            [{{ $order->id }}].
            يمكنك تتبع الطلب الخاص بك عن طريق زيارة
            [www.tawredaat.com/track-order] وإدخال رقم التتبع الخاص بك.
        </p>

        @include('User.mails.order.details.track-order-form', [
            'order_user_email' => $order->user->email,
            'order_id' => $order->id,
        ])
        <br>

        @include('User.mails.order.details.order_new_design', ['order' => $order])
    </div>
@endsection
