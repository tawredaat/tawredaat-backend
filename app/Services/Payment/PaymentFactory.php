<?php
namespace App\Services\Payment;

/**
 * This class helps to produce a proper strategy object for handling a payment.
 */
class PaymentFactory
{
    /**
     * Get a payment strategy by its ID.
     *
     * @param $id
     * @return PaymentStrategy
     * @throws \Exception
     */
    public static function getPaymentStrategy(string $payment_id)
    {
        switch ($payment_id) {
            case config('payment_paymob.online_card.payment_id', 3):
                return new CardPaymentStrategy();
            case 1:
                return null;
            case config('payment_paymob.valu.payment_id', 2):
                return new ValuPaymentStrategy();
            case 4:
                return new ForsaPaymentStrategy();
            case 5:
                return null;

            default:
                throw new \Exception("Unknown Payment Strategy");
        }
    }
}
