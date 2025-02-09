<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\UserAddress;
use App\Services\Payment\PaymentFactory;
use Exception;

class PaymentService
{
    private const AUTH_URL = "https://accept.paymob.com/api/auth/tokens";
    private const Order_Registration_URL = "https://accept.paymob.com/api/ecommerce/orders";
    private const Payment_Key_Request = "https://accept.paymob.com/api/acceptance/payment_keys";

    public function pay(int $cart_id)
    {
        try {
            // check if the payment method is supported
            $cart = Cart::findOrFail($cart_id);
            $payment_id = $cart->payment_id;

            // get integration id
            $integration_id = $this->getIntegrationId($payment_id);
	
            if ($integration_id == "") {
                return ['status' => 'error',
                    'message' => 'failed-unable to get the integration id',
                    'error_code' => 500];
            }

            $payment_strategy = PaymentFactory::getPaymentStrategy($payment_id);
            if (is_null($payment_strategy)) {
                return [
                    'status' => 'success',
                    'message' => __('validation.no_further_payment_steps'),
                    'url' => null];
            }

            // 1. initializePayment
            $result = $this->initializePayment($cart_id, $integration_id);
          
            $token = $result['token'];
            if ($token == "") {
                return ['status' => 'error',
                    'message' => 'failed-unable to get the token, ' . $result['message'],
                    'error_code' => $result['error_code']];
            }

            // 2. pay
            $payment_url = $payment_strategy->pay($token);

            return ['status' => 'success', 'url' => $payment_url,
                'message' => __('validation.payment_url_generated')];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => 'failed ' . $e->getMessage(),
                'error_code' => $e->getCode()];
        }
    }

    public function initializePayment(int $cart_id, string $integration_id): array
    {
        $token = "";

        try {
            // 1. Authentication Request
            $result = $this->authenticationRequest();
          
            $token = $result['token'];
            if ($token == "") {
                return ['status' => 'error', 'token' => "", 'message' => $result['message'],
                    'error_code' => $result['error_code']];
            }

            // 2. Order Registration API
            $total_in_cents = $this->totalInCents($cart_id);
            $result = $this->orderRegistration($token, $total_in_cents, $cart_id);
            $accept_db_id = $result['id'];
            if ($accept_db_id == "") {
                return ['status' => 'error', 'token' => "", 'message' => $result['message'],
                    'error_code' => $result['error_code']];
            }

            // 3. Payment Key Request
            $result = $this->paymentKeyRequest($accept_db_id, $token, $cart_id, $integration_id);
          
            if ($result['pay_api_token'] == "") {
                return ['status' => 'error', 'token' => "", 'message' => $result['message'],
                    'error_code' => $result['error_code']];
            }

            return ['status' => 'success', 'token' => $result['pay_api_token'],
                'message' => ""];
        } catch (\Exception $e) {
            return ['status' => 'error', 'token' => "", 'message' => $e->getMessage(),
                'error_code' => $e->getCode()];
        }
    }

    public function getIntegrationId(int $payment_id): string
    {
        try {
            switch ($payment_id) {
                case config('payment_paymob.online_card.payment_id', 3):
                    return config('payment_paymob.online_card.integration_id');
                case 1:
                    return "";
                case config('payment_paymob.valu.payment_id', 2):
                    return config('payment_paymob.valu.integration_id');
                case 4 :
                    return 4615491;
                default:
                    return "";
            }
        } catch (Exception $e) {
            return "";
        }
    }

    // returns auth token
    private function authenticationRequest(): array
    {
        $token = "";

        $client = new \GuzzleHttp\Client();
        $form_params['api_key'] = config('payment_paymob.api_key');

        try {
            $response = $client->post(self::AUTH_URL,
                [
                    'headers' => [
                        'content-type' => 'application/json',
                    ],
                    'body' => json_encode(['api_key' => config('payment_paymob.api_key')]),
                ]
            );

            $token = json_decode($response->getBody())->token;
            return ['status' => 'success', 'token' => $token, 'message' => ""];
        } catch (\Exception $e) {
            return ['status' => 'error', 'token' => "", 'message' => $e->getMessage(),
                'error_code' => $e->getCode()];
        }
    }

    // returns id in the accept database
    private function orderRegistration(string $token, float $total_in_cents, $cart_id): array
    {
        $id = -1;
        $client = new \GuzzleHttp\Client();
        $body_data = [
            "auth_token" => $token,
            "delivery_needed" => "false",
            "amount_cents" => (int) $total_in_cents,
            "currency" => "EGP",
            "items" => [],
            'merchant_order_id' => $cart_id,
        ];
        try {
            $response = $client->post(self::Order_Registration_URL,
                [
                    'headers' => [
                        'content-type' => 'application/json',
                    ],
                    'body' => json_encode($body_data),
                ]
            );

            $id = json_decode($response->getBody())->id;
            return ['status' => 'success', 'id' => $id, 'message' => ""];
        } catch (\Exception $e) {
            return ['status' => 'error', 'id' => "", 'message' => $e->getMessage(),
                'error_code' => $e->getCode()];
        }
    }

    private function totalInCents(int $cart_id): float
    {
        $cart = Cart::findOrFail($cart_id);
        return $cart->totalItemsAndBundels() * 100;
    }

    // return pay_api_token
    private function paymentKeyRequest(int $accept_db_id, string $token,
        int $cart_id, string $integration_id): array
    {
        $pay_api_token = "";
        $client = new \GuzzleHttp\Client();
        // get order data
        $cart = Cart::findOrFail($cart_id);
        $user = $cart->user;
        $user_address = $cart->userAddress;
        $total_in_cents = $this->totalInCents($cart_id);

        $body_data = [
            "auth_token" => $token,
            "amount_cents" =>  (int) $total_in_cents,
            "expiration" => 3600,
            "order_id" => $accept_db_id,
            "billing_data" => [
                "first_name" => $user->name ?? "NA",
                "last_name" => $user->last_name ?? "NA",
                "email" => $user->email,
                "phone_number" => $user->phone,
                "country" => $user_address->country ? $user_address->country->name : "NA",
                "city" => $user_address->city ? $user_address->city->name : "NA",
                "apartment" => "NA",
                "floor" => "NA",
                "street" => "NA",
                "building" => "NA",
                "shipping_method" => "NA",
                "postal_code" => "NA",
                "state" => "NA",
            ],
            "currency" => "EGP",
            "integration_id" => $integration_id,
        ];

        try {
            $response = $client->post(self::Payment_Key_Request,
                [
                    'headers' => [
                        'content-type' => 'application/json',
                    ],
                    'body' => json_encode($body_data),
                ]
            );
            $pay_api_token = json_decode($response->getBody())->token;
            return ['status' => 'success', 'pay_api_token' => $pay_api_token, 'message' => ""];
        } catch (\Exception $e) {
            return ['status' => 'error', 'pay_api_token' => "", 'message' => $e->getMessage(),
                'error_code' => $e->getCode()];
        }
    }
}
