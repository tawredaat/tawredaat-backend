<?php

namespace App\Http\Controllers\User\Api\Payment;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Http\Controllers\User\Api\BaseResponse;
use App\Repository\User\CheckoutRepo;
use App\User;
use App\Models\OnlineTransaction;
class GeideaPaymentController extends BaseResponse
{
    CONST SERVER_KEY      = 'c86f1b4e-b08a-4e0d-8702-c7c832b3f3d6';

    protected $checkoutRepo;

    public function __construct(CheckoutRepo $checkoutRepo)
    {
        $this->checkoutRepo = $checkoutRepo;
    }

    private function validateCart($user)
    {
        if(!$user->cart)
            return $this->response( 101, "This user has no items in the cart.", 200);
        if(!$user->cart->user_address_id)
            return $this->response( 101, "You must select your address.", 200);
        if($user->cart->payment_id != 3)
            return $this->response( 101, "You must select online payment method.", 200);
        else 
            return 0;
    }

    private function validateOnlineTransaction($user, $paid = 1, $message='Sucess')
    {
        $onlineTransaction = OnlineTransaction::where('user_id', $user->id)->where('cart_id', $user->cart->id)->first();
        if($onlineTransaction)
        {
            $onlineTransaction->paid = $paid;
            $onlineTransaction->message = $message;
            $onlineTransaction->save();
        }
        return $onlineTransaction;
    }

    public function pay()
    {
        try {
            $user = auth('api')->user();
            if($this->validateCart($user))
                return $this->validateCart($user);
            $cart      = $user->cart;
            $cart_data = $cart->cartCalculation();;
            $amount    = $cart_data['total'];
            $address   = $cart_data['address'];

            $data['SERVER_KEY']       = self::SERVER_KEY ;
            $data['user_email']       = $user->email ;
            $data['cart_id']          = "$cart->id" ;
            $data['cart_currency']    = "EGP" ;
            $data['cart_amount']      = round($amount, 2) ;
            $data['callback']         = route('geidea.sucess', $user->id) ;
            $onlineTransactions = OnlineTransaction::where('user_id', $user->id)->where('cart_id', $cart->id)->get();
            foreach($onlineTransactions as $transaction)
                $transaction->delete();
            OnlineTransaction::create([
                'user_id'          => $user->id,
                'cart_id'          => $cart->id,
                'amount'           => $amount,
            ]);
            return $this->response(200, 'Payment Accessed', 200, [], 0, $data);

        }catch (\Exception $e) {
            return $this->response(500, 'internal server error', 500);
        }
    }

  public function sucess(Request $request)
    {
        $user = auth('api')->user();
        if(!$user)
            return $this->response(500, "error occured, please contact with the site owner", 500);

        if($this->validateCart($user))
            return $this->validateCart($user);
        
        if(!$this->validateOnlineTransaction($user))
            return $this->response(101, "Validation Error", 200, 'You must try  pay online first :) ');
        
        $transaction = $this->validateOnlineTransaction($user);
        $transaction->transaction_id = $request->input('transactionId');
        $transaction->transaction_type = 'GEIDEA';
        $transaction->message = $request->input('responseMessage');
        $transaction->save();
        
        $result = $this->checkoutRepo->checkout($user);
        
        if($result['success'])
        {
            $order = $result['object']['order'];
            $order->transaction_id       = $request->input('transactionId');
            $order->save();
            return $this->response(200,$result['success'],200,[],0,$result['object']);
        }
        elseif($result['validator'])
           return $this->response( 101,"Validation Error",200,$result['validator']);
        elseif ($result['errors'])
            return $this->response(500,$result['errors'],500);
        else
            return $this->response(500,"Error",500);
    }
}
