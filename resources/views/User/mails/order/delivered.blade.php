@extends('User.mails.new_master_template', [
    'image_path' => 'images/emails-images/order-delivered.jpg',
    'image_alt' => 'delivered',
])

<?php
$delivery_status_change = App\Models\OrderStatusHistory::where(['order_id' => $order->id, 'status_id' => config('global.delivered_order_status', 4)])->first();

if (!is_null($delivery_status_change)) {
    $status_change_timedate = $delivery_status_change->created_at;
    $delivery_status_change_date = Carbon\Carbon::parse($status_change_timedate)->format('d.m.Y');
} else {
    $delivery_status_change_date = date('d.m.Y');
}
?>

@section('content')
    <div dir="rtl" style="text-align: right;">
        <p style="text-align: right;">
            يسعدنا أخبارك بأنه قد تم توصيل طلبك! تظهر سجلاتنا أنه تم تسليم الطلب في
            [{{ $delivery_status_change_date }}].
            إذا كان لديك أي شكوى أو
            ملاحظة بشأن التسليم أو المنتج
            يرجى الاتصال بفريق خدمة العملاء على [01029020807] أو [info@tawredaat.com].
        </p>

        @include('User.mails.order.details.survey-order-form', [
            'user_id' => $order->user_id,
            'order_id' => $order->id,
        ])
        <br>
    </div>
@endsection
