<?php
namespace App\Services\Payment;

class ForsaPaymentStrategy implements PaymentStrategy
{
    private const IFRAME_URL = "https://accept.paymobsolutions.com/api/acceptance/iframes";

    public function pay(string $token): string
    {
        $final_iframe_url =
        self::IFRAME_URL . "/" . 883728 . "?payment_token=" . $token;

        return ($final_iframe_url);
    }
}
