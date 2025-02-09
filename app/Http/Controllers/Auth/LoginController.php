<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Repository\User\CartRepo;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
     */
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';
    private $cartRepo;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CartRepo $cartRepo)
    {
        $categories = \App\Models\Category::where('level', 'level1')->get();
        $setting = \App\Models\Setting::first();
        \View::share('categories', $categories);
        \View::share('setting', $setting);
        $this->middleware('guest')->except('logout');
        $this->cartRepo = $cartRepo;
    }

    /**
     * override functions from vendor.
     *
     */
    public function showLoginForm()
    {
        return view('User.auth.login');
    }

    protected function credentials(Request $request)
    {
        if (is_numeric($request->get('email'))) {
            return ['phone' => $request->get('email'), 'password' => $request->get('password')];
        }
        return ['email' => $request->get('email'), 'password' => $request->get('password')];
        //return $request->only($this->username(), 'password');
    }

    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);
        if ($request->has('company_id') and $request->company_id) {
            return urldecode(redirect()->route('user.company', ['id' => $request->company_id, 'name' => $request->company_name]));
        } elseif ($request->has('back')) {
            return $this->authenticated($request, $this->guard()->user())
            ?: back();
        } else {
            return $this->authenticated($request, $this->guard()->user())
            ?: redirect()->intended($this->redirectPath());
        }

    }

    public function login(Request $request)
    {

        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            //store cart item if added by guest then login.
            $cart = [];
            if (Cookie::get('shopping_cart')) {
                $cookie_data = stripslashes(Cookie::get('shopping_cart'));
                $cart = json_decode($cookie_data, true) ? json_decode($cookie_data, true) : [];
            }
            foreach ($cart as $key => $value) {
                if (auth('web')->user()->cart) {
                    $item_exist = auth('web')->user()->cart->items->where('shop_product_id', $cart[$key]['item_id'])->first();
                    if ($item_exist) {
                        $item_exist->delete();
                    }

                }
                $request->merge(['shopProductId' => $cart[$key]['item_id'], 'quantity' => $cart[$key]['item_quantity']]);
                $this->cartRepo->setReq($request);
                $this->cartRepo->store(auth('web')->user());
            }
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     *Login With facebook
     *
     */
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        try {
            $user = Socialite::driver($provider)->stateless()->user();
            $check_mail = User::where('email', $user->email)->where('provider', '=', null)->count();
            if ($check_mail > 0) {
                return redirect()->route('login')->with('error', __('home.sameProvider'));
            }

            $authUser = $this->findOrCreateUser($user, $provider);
            // return $authUser;
            Auth::login($authUser);
            // UserLogin::create([
            //     'user_id' => auth('web')->user()->id
            // ]);
            if ($authUser->company_name && $authUser->phone) {
                return redirect('/#');
            }
            return redirect()->route('user.account.settings')->with('success', 'Welcome to ' . config('global.used_app_name', 'Tawredaat'));
        } catch (\Exception$exception) {
            return redirect()->route('login')->with('error', __('home.sameProvider'));
        }
    }

    public function findOrCreateUser($user, $provider)
    {
        $authUser = User::where('provider_id', $user->id)->first();
        if ($authUser) {
            //return "haha";
            return $authUser;
        }
        return User::create([
            'name' => $user->name,
            'email' => $user->email,
            'provider' => $provider,
            'provider_id' => $user->id,
            'password' => bcrypt($user->id),

        ]);
    }

    public function logout(Request $request)
    {
        if (Cookie::get('shopping_cart')) {
            Cookie::queue(Cookie::forget('shopping_cart'));
        }

        $this->guard()->logout();
        //$request->session()->invalidate();
        return $this->loggedOut($request) ?: redirect('/');
    }
}