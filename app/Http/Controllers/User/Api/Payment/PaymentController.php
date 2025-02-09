<?php

namespace App\Http\Controllers\User\Api\Payment;

use Illuminate\Support\Facades\Http;
use App\Http\Controllers\User\Api\BaseResponse;
use App\Repository\User\CheckoutRepo;
use App\User;
use App\Models\OnlineTransaction;
class PaymentController extends BaseResponse
{
    CONST PROFILE_ID      = 78292;
    CONST SERVER_KEY      = 'S9JNWRWLD6-J2GTTTRBNN-9692L999T9';
    CONST PAYMENT_URL     = 'https://secure-egypt.paytabs.com/payment/request';
    CONST TRANSACTION_URL = 'https://secure-egypt.paytabs.com/payment/query';

    protected $checkoutRepo;

    public function __construct(CheckoutRepo $checkoutRepo)
    {
        $this->checkoutRepo = $checkoutRepo;
    }

    private function headers() 
    {
        return ['headers' => ["content-type" => "application/json", 'authorization'=> self::SERVER_KEY]];
    }

    private function validateCart($user)
    {
        if(!$user->cart)
            return $this->response( 101, "This user has no items in the cart.", 200);
        if(!$user->cart->user_address_id)
            return $this->response( 101, "You must select your address.", 200);
        if($user->cart->payment_id != 2)
            return $this->response( 101, "You must select online payment method.", 200);
        else 
            return 0;
    }

    private function validateOnlineTransaction($user, $paid=1, $message='Sucess')
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

            $data['profile_id']       = self::PROFILE_ID ;
            $data['tran_type']        = "sale" ;
            $data['tran_class']       = "ecom" ;
            $data['cart_id']          = "$cart->id" ;
            $data['cart_description'] = "ummy Order 35925502061445345" ;
            $data['cart_currency']    = "EGP" ;
            $data['cart_amount']      = $amount ;
            $data['callback']         = route('paytabs.failed', $user->id) ;
            $data['return']           = route('paytabs.sucess', $user->id) ;

            $data['customer_details'] = [
                "name"      => $user->name,
                "email"     => $user->email,
                "street1"   => $address,
                "city"      => $cart->address ? ($cart->userAddress->city ? $cart->userAddress->city->name: NULL) : NULL,
                "country"   => "EGYPT",
                "ip"        => "94.204.129.89"
            ];

            $data['shipping_details'] =  [
                "name"      => $user->name,
                "email"     => $user->email,
                "phone"     => $user->phone,
                "street1"   => $address,
                "city"      => $cart->address ? ($cart->userAddress->city ? $cart->userAddress->city->name: NULL) : NULL,
                "state"     => "Cairo",
                "country"   => "Egypt",
                "zip"       => "54321",
                "ip"        => "2.2.2.2"
            ];

            $client   = new \GuzzleHttp\Client($this->headers());
        
            $response = $client->request('post', self::PAYMENT_URL,
            [ 
                'body' => json_encode($data) 
            ]);
            $results = json_decode($response->getBody()->getContents());
            OnlineTransaction::create([
                'user_id'          => $user->id,
                'cart_id'          => $results->cart_id,
                'transaction_id'   => $results->tran_ref,
                'transaction_type' => $results->tran_type,
                'amount'           => $results->cart_amount,
                'service_id'       => $results->serviceId,
                'trace'            => $results->trace,
            ]);
            return $response;
            // return $this->response(200, 'Payment Accessed', 200, [], 0, $results);
            
        }catch (\Exception $e) {
            return $this->response(500, 'internal server error', 500);
        }
    }

    public function sucess($id)
    {
        $user = User::find($id);
        if(!$user)
            return $this->response(500, "error occured, please contact with the site owner", 500);
        \Auth::login($user);
        
        if($this->validateCart($user))
            return $this->validateCart($user);
        
        if(!$this->validateOnlineTransaction($user))
            return $this->response(101, "Validation Error", 200, 'You must try  pay online first :) ');
        $transaction = $this->validateOnlineTransaction($user);

        $result = $this->checkoutRepo->checkout($user);
        
        if($result['success'])
        {
            $order = $result['object']['order'];
            $order->transaction_id = $transaction->transaction_id;
            $order->save();
            return redirect('https://souqkahraba.com/orders-checkout')->with('order', $order);
        }
        elseif($result['validator'])
           return $this->response( 101,"Validation Error",200,$result['validator']);
        elseif ($result['errors'])
            return $this->response(500,$result['errors'],500);
        else
            return $this->response(500,"Error",500);
    }

    public function failed()
    {
        $user = auth('api')->user;
        if(!$this->validateOnlineTransaction($user, 0, 'failed'))
            return $this->response(101, "Validation Error", 200, 'You must try  pay online first :) ');
        return $this->response(101, "Failed Payment", 200);
    }
    
    public function checkTransaction($tran_ref)
    {
        $data['profile_id'] = self::PROFILE_ID;
        $data['tran_ref']   = $tran_ref;

        $client   = new \GuzzleHttp\Client($this->headers());
      
        $response = $client->request('post', self::TRANSACTION_URL,
        [ 
            'body' => json_encode($data) 
        ]);
        return $response;
        // return $this->response(200, $tran_ref.' Transaction', 200, [], 0, $response);
    }
}
