@extends('User.mails.new_master_template', [
    'image_path' => 'images/emails-images/order-preparing.jpg',
    'image_alt' => 'preparing',
])
@section('content')
    <div dir="rtl" style="text-align: right;">
        <p style="text-align: right;">
            يسعدنا إخباركم بأن كل البنود المطلوبة متوفرة وسيتم تحضير الطلب. ستتلقى بريداً الكترونياً آخر بمجرد استعداد الطلب
            للشحن يحتوى على تفاصيل التتبع وأى معلومات أخرى حول طلبك رقم
            {{ $order->id }}

            @include('User.mails.order.details.track-order-form', [
                'order_user_email' => $order->user->email,
                'order_id' => $order->id,
            ])
            <br>

            @include('User.mails.order.details.order_new_design', ['order' => $order])
    </div>
@endsection
