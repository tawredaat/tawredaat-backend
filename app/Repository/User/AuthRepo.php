<?php

namespace App\Repository\User;

use App\Events\User\UserLoggedIn;
use App\Helpers\General;
use App\Helpers\UploadFile;
use App\Http\Resources\Collections\InterestsCollection;
use App\Http\Resources\UserResource;
use App\Mail\User\WelcomeNewRegisteredUser;
use App\Mail\User\YourNewPasswordMail;
use App\Mail\UserRegisterMail;
use App\Models\Interest;
use App\Models\Setting;
use App\Models\UserInterest;
use App\Models\UserLogin;
use App\Models\UserVerification;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Mailjet\Resources;

class AuthRepo
{
    private $request;
    private $result = array();

    public function setReq(Request $request)
    {
        $this->request = $request;
    }

    public function login()
    {
        $request = $this->request;
        DB::beginTransaction();
        try {
            if (Auth::attempt([
                'email' => $request->input('email'),
                'password' => $request->input('password'),
                'isVerify' => 1,
                'isActive' => 0
            ])) {
                return $this->result = [
                    'validator' => [__('auth.userNotActive')],
                    'success' => null,
                    'errors' => null,
                    'object' => null
                ];
            } 
    
            if (Auth::attempt([
                'email' => $request->input('email'),
                'password' => $request->input('password'),
                'isVerify' => 1,
                'isActive' => 1
            ]) || Auth::attempt([
                'email' => $request->input('email'),
                'password' => $request->input('password'),
                'isVerify' => 0,
                'isActive' => 1
            ])) {
                
                $user = Auth::user();
                $token = $user->createToken('API Token')->plainTextToken;
                $results['user'] = new UserResource($user);
    
                DB::commit();
                return $this->result = [
                    'validator' => null,
                    'success' => $token ,
                    'errors' => null,
                    'object' => $results
                ];
            }
    
            return $this->result = [
                'validator' => ['error in login'],
                'success' => null,
                'errors' => null,
                'object' => null
            ];
    
        } catch (\Exception $exception) {
            DB::rollback();
            return $this->result = [
                'validator' => null,
                'success' => null,
                'errors' => $exception->getMessage(), // Fixed: Show error message
                'object' => null
            ];
        }
    }

    public function register_consumer()
    {
        $request = $this->request;
        DB::beginTransaction();
    
        try {
            $user = User::create([
                'full_name' => $request->input('full_name'),
                'user_type' => 'consumer',
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
                'phone' => $request->input('phone'),
            ]);
    
            $results['token']  = $user->createToken('AppName')->plainTextToken;
            $results['user'] = new UserResource($user);
    
            DB::commit();
            $setting = Setting::first();
            $logo = $setting->site_logo;
            $order = $user;
    
            event(new UserLoggedIn($user));
    
            return $this->result = [
                'validator' => null,
                'success' => __('auth.userCreated'),
                'errors' => null,
                'object' => $results
            ];
    
        } catch (\Exception $e) {
            DB::rollback();
            return $this->result = [
                'validator' => null,
                'success' => null,
                'errors' => $e,
                'object' => null
            ];
        }
    }
    
    public function register_company()
    {
        $request = $this->request;
        DB::beginTransaction();
    
        try {
            $user = User::create([
                'company_name' => $request->input('company_name'),
                'full_name' => $request->input('full_name'),
                'user_type' => 'company',
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
                'phone' => $request->input('phone'),
            ]);
    
            $results['token']  = $user->createToken('AppName')->plainTextToken;
            $results['user'] = new UserResource($user);
    
            DB::commit();
            $setting = Setting::first();
            $logo = $setting->site_logo;
            $order = $user;
    
            event(new UserLoggedIn($user));
    
            return $this->result = [
                'validator' => null,
                'success' => __('auth.userCreated'),
                'errors' => null,
                'object' => $results
            ];
    
        } catch (\Exception $e) {
            DB::rollback();
            return $this->result = [
                'validator' => null,
                'success' => null,
                'errors' => $e,
                'object' => null
            ];
        }
    }
    
    public function register_technician()
    {
        $request = $this->request;
        DB::beginTransaction();
        $categories = implode(',', $request->input('category_name')); 
        try {
            $user = User::create([
                'category_name' => $categories,
                'city_id' => $request->input('city_id'),
                'full_name' => $request->input('full_name'),
                'user_type' => 'technician',
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
                'phone' => $request->input('phone'),
            ]);
    
            $results['token']  = $user->createToken('AppName')->plainTextToken;
            $results['user'] = new UserResource($user);
    
            DB::commit();
            $setting = Setting::first();
            $logo = $setting->site_logo;
            $order = $user;
    
            event(new UserLoggedIn($user));
    
            return $this->result = [
                'validator' => null,
                'success' => __('auth.userCreated'),
                'errors' => null,
                'object' => $results
            ];
    
        } catch (\Exception $e) {
            DB::rollback();
            return $this->result = [
                'validator' => null,
                'success' => null,
                'errors' => $e,
                'object' => null
            ];
        }
    }

    public function VerifyAccount()
    {
        $request = $this->request;
        DB::beginTransaction();
        try {
            $result = UserVerification::where([['user_id',
                $request->input('userId')], ['code', $request->input('code')]])->first();
            $validDate = date('Y-m-d H:i:s',
                strtotime('+5 minutes', strtotime($result->created_at)));
            $now = date('Y-m-d H:i:s');
            if ($now <= $validDate) {
                $result->user->isVerify = 1;
                $result->user->save();
                $results['user'] = new UserResource($result->user);
                UserVerification::where('user_id', $request->input('userId'))->delete();
                DB::commit();
                if ($result->user) {
                    $setting = Setting::first();
                    $logo = $setting->site_logo;
                    // send user welcome email
                    // {{sendMail($result->user->email,$result->user->name,'Welcome to Souqkahraba.com!',$logo,config('global.used_app_name', 'Tawredaat'),'User.mails.welcome_new_registered_user');}}
        

                    // Mail::to($result->user->email)->send(new WelcomeNewRegisteredUser($result->user->name));
                }

                auth()->login($result->user);
                $this->saveFirebaseToken($request->all());
                // $this->saveLogin($request);
                $token = $result->user->createToken($result->user->id)->accessToken;
                event(new UserLoggedIn($result->user));
                return $this->result = ['validator' => null, 'success' => $token, 'errors' => null, 'object' => $results];
            }
            return $this->result = ['validator' => [__('auth.codeExpired')], 'success' => null, 'errors' => null, 'object' => null];
        } catch (\Exception $exception) {
            DB::rollback();
            return $this->result = ['validator' => null, 'success' => null, 'errors' => $exception, 'object' => null];
        }
    }

    public function resendVerify()
    {
        $request = $this->request;
        $userId = $request->input('userId');
        DB::beginTransaction();
        try {
            $user = User::where('id', $userId)->first();
            $code = General::generateCode(4);
            if ($user->verification_codes->count()) {
                $user->verification_codes->each->delete();
            }

            UserVerification::create([
                'user_id' => $user->id,
                'code' => $code,
            ]);
            // General::SendSMS($user->phone,$code.' 'is your verification code for souqkahrba.com'');
            // Mail::to($user)->send(new VerifyUser($user, $code));
            DB::commit();
            return $this->result = ['validator' => null, 'success' => __('auth.codeSent'), 'errors' => null];
        } catch (\Exception $exception) {
            DB::rollback();
            return $this->result = ['validator' => null, 'success' => null, 'errors' => $exception, 'object' => null];
        }
    }

    public function getVerifyCodes()
    {
        DB::beginTransaction();
        try {
            $codes = UserVerification::select('user_id', 'code')->orderby('id', 'desc')->limit(5)->get();
            $results['codes'] = $codes;
            DB::commit();
            return $this->result = ['validator' => null, 'success' => 'Verifications Code', 'errors' => null, 'object' => $results];
        } catch (\Exception $exception) {
            DB::rollback();
            return $this->result = ['validator' => null, 'success' => null, 'errors' => $exception, 'object' => null];
        }
    }

    public function sendNewPassword()
    {
    $email = $this->request->get('email');
    DB::beginTransaction();
    try {
        $user = User::where('email', $email)->first();

        if ($user) {
            if (!is_null($user->provider_id)) {
                return $this->result = ['validator' => [__('auth.resetSocialPass')],
                    'success' => null, 'errors' => null, 'object' => null];
            }

            $newPassword = Str::random(8);
            // dd($newPassword);
            $user->password = bcrypt($newPassword);
            $user->save();
            $setting = Setting::first();
            $logo = $setting->site_logo;
            
            // Log SMTP connection
            \Log::info('Attempting to send email via SMTP...');

            // Mail::to($user->email)->send(new YourNewPasswordMail($newPassword));
            // {{sendMail($user->email,$user->name,'New Password Generated' ,$logo,config('global.used_app_name', 'Tawredaat'),'User.mails.your_new_password' , $newPassword);}}
            {{sendMail($user->email,$user->name,'Welcome to Tawredaat.com!!',$logo,config('global.used_app_name', 'Tawredaat'),
                'User.mails.your_new_password',$newPassword);}}

            \Log::info('Email sent successfully.');

            DB::commit();
            return $this->result = ['validator' => null, 'success' => __('auth.changePassMessage'), 'errors' => null, 'object' => null];
        } else {
            return $this->result = ['validator' => [__('auth.accountNotExitstOrverified')], 'success' => null, 'errors' => null, 'object' => null];
        }

    } catch (\Exception $exception) {
        dd($exception);
        \Log::error('Error sending email: ' . $exception->getMessage());
        DB::rollback();
        return $this->result = ['validator' => null, 'success' => null, 'errors' => $exception];
    }
}

    public function registerOrLoginProvider()
    {
        $request = $this->request;
        DB::beginTransaction();
        try {
            $user = User::where([['provider_id', $request->input('providerId')], ['provider', $request->input('provider')]])->first();
            if (is_null($user)) {
                $checkEmail = User::wherenotnull('email')->where('email', $request->input('email'))->count();
                if ($checkEmail > 0) {
                    return $this->result = ['validator' => [__('auth.emailTaken')], 'success' => null, 'errors' => null, 'object' => null];
                } else {
                    $user = User::create([
                        'name' => $request->input('name'),
                        'email' => $request->input('email'),
                        'password' => bcrypt($request->input('providerId')),
                        'provider' => $request->input('provider'),
                        'provider_id' => $request->input('providerId'),
                        'isVerify' => 1,
                        'isActive' => 1,
                    ]);
                    DB::commit();
                }
            }
            $results = $this->loginProvider($user->provider_id, $request->all());
            DB::commit();
            event(new UserLoggedIn($user));
            return $results;
        } catch (\Exception $exception) {
            DB::rollback();
            return $this->result = ['validator' => null, 'success' => null, 'errors' => $exception];
        }
    }

    public function loginProvider($providerId, $input)
    {
        if (Auth::attempt(['provider_id' => $providerId, 'password' => $providerId, 'isVerify' => 0, 'isActive' => 1])) {
            $this->result = ['validator' => [__('auth.userNotVerfiy')], 'success' => null, 'errors' => null, 'userId' => Auth::user()->id, 'userPhone' => Auth::user()->phone, 'status' => 105];
        } elseif (Auth::attempt(['provider_id' => $providerId, 'password' => $providerId, 'isVerify' => 1, 'isActive' => 0])) {
            $this->result = ['validator' => [__('auth.userNotActive')], 'success' => null, 'errors' => null, 'object' => null];
        } elseif (Auth::attempt(['provider_id' => $providerId, 'password' => $providerId, 'isVerify' => 1, 'isActive' => 1])) {
            $response = General::oauthClient($providerId, $providerId);
            if ($response->getStatusCode() == 200) {
                $this->saveFirebaseToken($input);
                $data = json_decode($response->getBody());
                $object['user'] = new UserResource(Auth::user());
                //$this->saveLogin();
                return $this->result = ['validator' => null, 'success' => $data->access_token, 'errors' => null, 'user' => $object];
            }
            $this->result = ['validator' => [__('auth.errorLogin')], 'success' => null, 'errors' => null, 'object' => null];
        } else {
            $this->result = ['validator' => [__('auth.InvalidCredent')], 'success' => null, 'errors' => null, 'object' => null];
        }

        $user = auth()->user();
        event(new UserLoggedIn($user));
        return $this->result;
    }

    public function allInterests()
    {
        try {
            $results['interests'] = new InterestsCollection(Interest::all());
            return $this->result = ['validator' => null, 'success' => 'User interests', 'errors' => null, 'object' => $results];
        } catch (\Exception $exception) {
            return $this->result = ['validator' => null, 'success' => null, 'errors' => $exception, 'object' => null];
        }
    }
    /**
     * Save Login
     * @param $input
     */
    private function saveLogin($request)
    {
        DB::beginTransaction();
        try {
            UserLogin::create([
                'user_id' => Auth::user()->id,
            ]);

            if ($request->hasHeader('deviceId')) {
                $user = DB::table('users')->where('device_id', $request->header('deviceId'))->first();
                $currentUser = Auth::user();
                $cart = $currentUser->cart;
                if ($user) {
                    DB::table('users')->where('device_id', $this->request->header('deviceId'))->delete();
                }
                $currentUser->updateCartAfterLogin();
                $currentUser->save();
            }
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
        }
    }

    /**
     * @param $input
     */
    private function saveFirebaseToken($input)
    {
        $user = Auth::user();
        if (isset($input['firebaseToken'])) {
            $user->firebase_token = $input['firebaseToken'];
        }

        if (isset($input['deviceType'])) {
            $user->device_type = $input['deviceType'];
        }

        $user->save();
    }
}
