<div
    style="padding:8px;border-radius: 11px;width:110px;margin:5px;
            background-color: {{ config('global.used_app_color', '') }};">
    <div class="row">
        <div class="column"
            style="background-color: {{ config('global.used_app_color', '') }};
                        text-align: center;">
            <a type="submit"
                href="{{ url('https://tawredaat.com/track-order') . '?order_id=' . $order_id . '&user_id=' . $user_id }}"
                style="font-size: 17px;
                padding:auto;margin:auto;
                text-align: center;background: none !important;display:inline-block;
                border: none;cursor: pointer;font-weight:bold;color:white;">
                أبدء التقييم الآن
            </a>
        </div>
    </div>
</div>
