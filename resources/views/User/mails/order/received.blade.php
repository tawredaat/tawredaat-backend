@extends('User.mails.new_master_template', [
    'image_path' =>
        //'images/emails-images/order-received-without-background.png',
        'images/emails-images/order-received.jpg',

    'image_alt' => 'order-received',
])
@section('content')
    <div dir="rtl" style="text-align: right;">
        <p style="text-align: right;">شكرا لاختياركم توريدات. لقد استلمنا طلبك. سنقوم بإبلاغك عندما يصبح الطلب جاهزاً وينتقل
            لمرحلة التوصيل.</p>
        @include('User.mails.order.details.track-order-form', [
            'order_user_email' => $order->user->email,
            'order_id' => $order->id,
        ])
        <br>

        @include('User.mails.order.details.order_new_design', ['order' => $order])
    </div>
@endsection
