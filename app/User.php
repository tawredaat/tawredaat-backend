<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'last_name', 'email', 'password', 'title', 'company_name', 'photo', 'phone', 'provider', 'provider_id', 'isVerify', 'isActive', 'user_address_id', 'device_id', 'device_type', 'email_verified_at', 'remember_token', 'firebase_token','full_name' , 'user_type', 'category_name' , 'city_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function findForPassport($username)
    {
        return User::orWhere('email', $username)->orWhere('phone', $username)->orWhere('provider_id', $username)->first();
    }
    public function verification_codes()
    {
        return $this->hasMany('App\Models\UserVerification', 'user_id');
    }

    public function addresses()
    {
        return $this->hasMany('App\Models\UserAddress');
    }
    public function selectedAddress()
    {
        return $this->hasOne('App\Models\UserAddress', 'id', 'user_address_id');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order')->orderBy('id', 'DESC');
    }
    public function interests()
    {
        return $this->hasMany('App\Models\UserInterest');
    }

    public function rfqs()
    {
        return $this->hasMany('App\Models\UserRfq');
    }

    public function cart()
    {
        return $this->hasOne('App\Models\Cart');
    }
  
   	public function city()
    {
        return $this->belongsTo('App\Models\City' , 'city_id');
    }
    public function items()
    {
        return $this->hasManyThrough('App\Models\CartItem', 'App\Models\Cart');
    }

    public static function getUser($request)
    {
        if ($request->hasHeader('deviceId')) {
            $user = self::where('device_id', $request->header('deviceId'))->first();
            if (!$user) {
                $user = self::create(['device_id' => $request->header('deviceId'), 'password' => bcrypt($request->header('deviceId'))]);
            }

        } elseif (auth('api')->check()) {
            $user = auth('api')->user();
        } else {
            return null;
        }

        return $user;
    }
}
