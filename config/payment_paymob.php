<?php

return
    [
    //'paymob_api_key' => env('PAYMOB_API_KEY'),
    'api_key' => env('PAYMOB_API_KEY'),
    //'paymob_integration_id' => env('PAYMOB_ONLINE_CARD_INTEGRATION_ID'),

    //  'paymob_hmac_secret' => env('PAYMOB_HMAC_SECRET'),
    'hmac_secret' => env('PAYMOB_HMAC_SECRET'),

    //'online_payment_id' => 3,
    // 'paymob_iframe_id' => env('PAYMOB_IFRAME_ID'),

    'online_card' => [
        'payment_id' => 3,
        'iframe_id' => env('PAYMOB_ONLINE_CARD_IFRAME_ID'),
        'integration_id' => env('PAYMOB_ONLINE_CARD_INTEGRATION_ID'),
    ],
    'valu' => [
        'payment_id' => 2,
        'iframe_id' => env('PAYMOB_VALU_IFRAME_ID'),
        'integration_id' => env('PAYMOB_VALU_INTEGRATION_ID'),
    ],

];
