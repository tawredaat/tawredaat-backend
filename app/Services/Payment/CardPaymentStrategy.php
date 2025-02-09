<?php
namespace App\Services\Payment;

class CardPaymentStrategy implements PaymentStrategy
{
    private const IFRAME_URL = "https://accept.paymobsolutions.com/api/acceptance/iframes";

    public function pay(string $token): string
    {
        $final_iframe_url =
        self::IFRAME_URL . "/" . config('payment_paymob.online_card.iframe_id') . "?payment_token=" . $token;

        return ($final_iframe_url);
    }
}
