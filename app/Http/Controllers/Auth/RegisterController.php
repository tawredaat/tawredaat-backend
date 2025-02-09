<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Repository\User\ProductRepo;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Cookie;
use App\Repository\User\AuthRepo;
use App\Repository\User\CartRepo;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserRegisterMail;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';
    private $authRepo;
    private $cartRepo;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(AuthRepo $authRepo, CartRepo $cartRepo)
    {
        $this->authRepo = $authRepo;
        $this->cartRepo = $cartRepo;
        $categories = \App\Models\Category::where('level','level1')->get();
        $setting    = \App\Models\Setting::first();
        \View::share('categories',$categories);
        \View::share('setting',$setting);
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6'/*, 'confirmed'*/],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  Request  $request
     * @return \App\User
     */
    protected function create(Request $request)
    {
        $this->authRepo->setReq($request);
        $result = $this->authRepo->register();
        if($result['success']){
            $user = $result['object']['user'];
            Mail::to($user->email)->send(new UserRegisterMail($user->name));
            return User::find($user->id);
        }
        return null;
    }

    /**
     * override functions to vendor.
     *
     */
    public function showRegistrationForm()
    {
        return view('User.auth.register');
    }

    public function register(Request $request)
    {

        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request)));
        if($user){
            $this->guard()->login($user);
            //store cart item if added by guest then register.
            $cart = [];
            if(Cookie::get('shopping_cart')){
                $cookie_data = stripslashes(Cookie::get('shopping_cart'));
                $cart = json_decode($cookie_data, true)?json_decode($cookie_data, true):[];
            }
            foreach($cart as $key=>$value){
                $request->merge(['shopProductId'=>$cart[$key]['item_id'],'quantity'=>$cart[$key]['item_quantity']]);
                $this->cartRepo->setReq($request);
                $this->cartRepo->store(auth('web')->user());
            }
            //store cart item if added by guest then register.
            if($request->input('company_name') !=null && $request->input('company_id') !=null){
                $com_name = $request->company_name;
                $com_id = $request->company_id;

                return $this->registered($request, $user)
                    ?: urldecode(redirect()->route('user.company',['name'=>str_replace([' ','/'], '-',$com_name),'id'=>$com_id])->with('accCreated', __('home.accCreated')));

            }
            elseif ($request->input('product_name') !=null && $request->input('product_id') !=null && $request->input('brand_name') !=null){
                $product_name = $request->input('product_name');
                $brand_name = $request->input('brand_name');
                $product_id = $request->input('product_id') ;
                    return $this->registered($request, $user)
                        ?: urldecode(redirect()->route('user.product',['name'=>urlencode(str_replace([' ','/'], '-',$product_name)),'brand'=>urldecode(str_replace([' ','/'], '-',$brand_name?$brand_name:'brand')),'id'=>$product_id])->with('accCreated', __('home.accCreated')));

            }
            elseif ($request->has('back')){
                session()->flash('accCreated',__('home.accCreated'));
                return $this->registered($request, $this->guard()->user())
                ?: back();
            }
            else {
                return $this->registered($request, $user)
                    ?: redirect($this->redirectPath())->with('accCreated', __('home.accCreated'));
            }
        }
        return back()->with('error','something went wrong')->withInput();
    }

}
