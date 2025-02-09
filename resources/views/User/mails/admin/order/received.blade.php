@extends('User.mails.admin.new_master_template', [
    'image_path' =>
        //'images/emails-images/order-received-without-background.png',
        'images/emails-images/order-received.jpg',

    'image_alt' => 'order-received',
])
@section('content')
    <div dir="rtl" style="text-align: right;">
        <p style="text-align: right;">
            تم استلام طلب جديد
        </p>
        @include('User.mails.order.details.order_new_design', ['order' => $order])
    </div>
@endsection
