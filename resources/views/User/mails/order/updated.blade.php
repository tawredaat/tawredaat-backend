@extends('User.mails.new_master_template', [
    'image_path' => 'images/emails-images/order-updated.jpg',
    'image_alt' => 'updated',
])
@section('content')
    <div dir="rtl" style="text-align: right;">
        <p style="text-align: right;">
            لقد تلقينا بعض التغييرات على طلبك رقم
            {{ $order->id }}.
            لقد قمنا بتحديث تفاصيل طلبك وأردنا تأكيد التغييرات التي تم إجراؤها.
        </p>

        @include('User.mails.order.details.track-order-form', [
            'order_user_email' => $order->user->email,
            'order_id' => $order->id,
        ])
        <br>

        @include('User.mails.order.details.order_new_design', ['order' => $order])
    </div>
@endsection
