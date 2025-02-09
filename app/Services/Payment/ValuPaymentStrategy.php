<?php
namespace App\Services\Payment;

class ValuPaymentStrategy implements PaymentStrategy
{
    private const IFRAME_URL = "https://accept.paymobsolutions.com/api/acceptance/iframes";

    public function pay(string $token): string
    {
        $final_iframe_url =
        self::IFRAME_URL . "/" . config('payment_paymob.valu.iframe_id') . "?payment_token=" . $token;

        return ($final_iframe_url);
    }
}
