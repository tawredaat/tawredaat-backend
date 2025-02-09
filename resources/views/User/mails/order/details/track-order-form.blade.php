<div {{-- method="POST" action="{{ url('api/track-order') }}" --}}
    style="
            padding:2px;
            border-radius: 11px;
            width:110px;
            background-color: rgba(128, 128, 128, 0.342);">
    <input type="hidden" name="billing_email" value={{ $order_user_email }}>
    <input type="hidden" name="order_id" value={{ $order_id }}>
    <div class="row" style="display: flex;">
        <div class="column" style="text-align: center;">
            <img src="{{ asset('images/emails-images/button-icon-without-background.png') }}" style="width:30px;">
        </div>
        <div class="column" style="padding: 1px;text-align: center;">
            <a type="submit" href="{{ url('https://tawredaat.com/track-order') }}"
                style="flex: 33.33%;padding: 3px;padding-top: 5.8px;text-align: center;
                        background: none !important;display:inline-block;
                border: none;cursor: pointer;font-weight:bold;
                color:{{ config('global.used_app_color', '') }};">
                تتبع الطلب</a>
        </div>
    </div>
</div>
