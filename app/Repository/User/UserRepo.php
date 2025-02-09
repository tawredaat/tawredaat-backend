<?php

namespace App\Repository\User;

use App\Actions\User\Cart\UpdateAddressWithDefaultAction;
use App\Actions\User\UserAddress\SetDefaultAction;
use App\Helpers\UploadFile;
use App\Http\Resources\Collections\InterestsCollection;
use App\Http\Resources\Collections\UserAddressesCollection;
use App\Http\Resources\UserAddressResource;
use App\Http\Resources\UserResource;
use App\Models\Cart;
use App\Models\Interest;
use App\Models\Notification;
use App\Models\UserAddress;
use App\Models\UserInterest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserRepo
{
    private $request;
    private $result = array();

    public function setReq(Request $request)
    {
        $this->request = $request;
    }

    public function userInfo()
    {
        DB::beginTransaction();
        try {
            $results['user'] = new UserResource(auth('web')->check() ? auth('web')->user() : auth('api')->user());
            return $this->result = ['validator' => null, 'success' => 'User Details', 'errors' => null, 'object' => $results];
        } catch (\Exception $exception) {
            DB::rollback();
            return $this->result = ['validator' => null, 'success' => null, 'errors' => $exception, 'object' => null];
        }
    }

    public function updateUserInfo($id)
    {
        $request = $this->request;
        DB::beginTransaction();
        try {
            $user = User::find($id);
            if ($user) {
                if ($request->has('photo')) {
                    if ($user->photo) {
                        UploadFile::RemoveFile($user->photo);
                    }

                    $photo = UploadFile::UploadSinglelFile($request->photo, 'users');
                } else {
                    $photo = $user->photo;
                }

                $user->name = $request->input('first_name') ? $request->input('first_name') : $user->name;
                $user->last_name = $request->input('last_name') ? $request->input('last_name') : $user->last_name;
                $user->email = $request->input('email') ? $request->input('email') : $user->email;
                $user->title = $request->input('T') ? $request->input('T') : ($request->input('title') ? $request->input('title') : $user->title);
                $user->phone = $request->input('phone') ? $request->input('phone') : $user->phone;
                $user->company_name = $request->input('CN') ? $request->input('CN') : ($request->input('company_name') ? $request->input('company_name') : $user->company_name);
                $user->photo = $photo;
                $user->save();
                DB::commit();
                $results['user'] = new UserResource($user);
                return $this->result = ['validator' => null, 'success' => __('home.saveSettings'), 'errors' => null, 'object' => $results];
            }
            return $this->result = ['validator' => [__('home.userNotFound')], 'success' => null, 'errors' => null, 'object' => null];
        } catch (\Exception $exception) {
            DB::rollback();
            return $this->result = ['validator' => null, 'success' => null, 'errors' => $exception, 'object' => null];
        }
    }

    public function viewAddresses($user)
    {
        DB::beginTransaction();
        try {
            $results['addresses'] = new UserAddressesCollection($user->addresses);
            return $this->result = ['validator' => null, 'success' => 'User Addresses', 'errors' => null, 'object' => $results];
        } catch (\Exception $exception) {
            DB::rollback();
            return $this->result = ['validator' => null, 'success' => null, 'errors' => $exception, 'object' => null];
        }
    }
    /**
     * Store user addresss instance in DB..
     *
     * @return $result
     */
    public function addAddress($user,
        SetDefaultAction $set_default_action,
        UpdateAddressWithDefaultAction $update_address_with_default_action) {
        DB::beginTransaction();
        try {
            $request = $this->request;
            $userAddressesCount = $user->addresses()->count();
            $address = UserAddress::create([
                'user_id' => $user->id,
                'city_id' => $request->input('country_id'),
                'area' => $request->input('area'),
                'detailed_address' => $request->input('detailed_address'),
                'address_type' => $request->input('address_type'),
                'reciever_name' => $request->input('reciever_name'),
                'reciever_phone' => $request->input('reciever_phone'),
                'longitude' => $request->input('longitude'),
                'latitude' => $request->input('latitude'),
                'is_default' => $request->input('is_default'),
            ]);
            if ($userAddressesCount < 1) {
            $user->user_address_id = $address->id;
            $user->save();
            $cart = Cart::where('user_id', $user->id)->first();
            if($cart !== null)
            {
                $cart->user_address_id = $address->id;
                $cart->save();
            }
            
            }
            if ($request->input('is_default')) {
                $set_default_action->execute($address->id);
                // update cart
                $this->updateUserCartWithDefaultAddress($user->id,
                    $update_address_with_default_action);
            }
            DB::commit();
            $results['address'] = new UserAddressResource($address);
            return $this->result = ['validator' => null, 'success' => __('home.addressAdded'), 'errors' => null, 'object' => $results];
        } catch (\Exception $exception) {
            dd($exception);
            DB::rollback();
            return $this->result = ['validator' => null, 'success' => null, 'errors' => $exception, 'object' => null];
        }
    }

    public function updateAddress($user, $id,
        SetDefaultAction $set_default_action,
        UpdateAddressWithDefaultAction $update_address_with_default_action) {
        DB::beginTransaction();
        try {
            $request = $this->request;
            $address = UserAddress::where('user_id', $user->id)->find($id);
            if ($address) {
                $address->update([
                    'user_id' => $user->id,
                    'city_id' => $request->input('country_id'),
                    'area' => $request->input('area'),
                    'detailed_address' => $request->input('detailed_address'),
                    'address_type' => $request->input('address_type'),
                    'reciever_name' => $request->input('reciever_name'),
                    'reciever_phone' => $request->input('reciever_phone'),
                    'longitude' => $request->input('longitude'),
                    'latitude' => $request->input('latitude'),
                    'is_default' => $request->input('is_default'),
                ]);
                if ($request->input('is_default')) {
                    $set_default_action->execute($address->id);
                    $this->updateUserCartWithDefaultAddress($user->id,
                        $update_address_with_default_action);
                }

                DB::commit();
                $results['address'] = new UserAddressResource($address);
                return $this->result = ['validator' => null, 'success' => __('home.addressUpdated'), 'errors' => null, 'object' => $results];
            }
            return $this->result = ['validator' => ['This address not found!'], 'success' => null, 'errors' => null, 'object' => null];

        } catch (\Exception $exception) {
            DB::rollback();
            return $this->result = ['validator' => null, 'success' => null, 'errors' => $exception, 'object' => null];
        }
    }

    public function deleteAddress($user, $id)
    {
        DB::beginTransaction();
        try {
            $address = UserAddress::where('user_id', $user->id)->find($id);
            if ($address) {
                $address->delete();
                DB::commit();
                return $this->result = ['validator' => null, 'success' => __('home.addressDeleted'), 'errors' => null, 'object' => null];
            }
            return $this->result = ['validator' => ['This address not found!'], 'success' => null, 'errors' => null, 'object' => null];
        } catch (\Exception $exception) {
            DB::rollback();
            return $this->result = ['validator' => null, 'success' => null, 'errors' => $exception, 'object' => null];
        }
    }

    public function selectAddress($user)
    {
        DB::beginTransaction();
        try {
            if (!in_array($this->request->input('user_address_id'), $user->addresses->pluck('id')->toArray())) {
                return $this->result = ['validator' => ['This address not found!'], 'success' => null, 'errors' => null, 'object' => null];
            }

            $user->user_address_id = $this->request->input('user_address_id');
            $user->save();
            $cart = Cart::where('user_id', $user->id)->first();
            if($cart !== null)
            {
                $cart->user_address_id = $this->request->input('user_address_id');
                $cart->save();
            }
            
            DB::commit();
            $results['address'] = new UserAddressResource(UserAddress::find($this->request->input('user_address_id')));
            return $this->result = ['validator' => null, 'success' => _('home.addressSelected'), 'errors' => null, 'object' => $results];
        } catch (\Exception $exception) {
            dd( $exception);
            DB::rollback();
            return $this->result = ['validator' => null, 'success' => null, 'errors' => $exception, 'object' => null];
        }
    }
    /**
     * Show user interests..
     *
     * @return $result
     */
    public function viewInterests($user)
    {
        DB::beginTransaction();
        try {
            $results['interests'] = new InterestsCollection(Interest::all());
            return $this->result = ['validator' => null, 'success' => 'User interests', 'errors' => null, 'object' => $results];
        } catch (\Exception $exception) {
            DB::rollback();
            return $this->result = ['validator' => null, 'success' => null, 'errors' => $exception, 'object' => null];
        }
    }

    public function selectInterests($user)
    {
        DB::beginTransaction();
        try {
            $user->interests()->delete();
            foreach ($this->request->input('interest_id') as $interest) {
                UserInterest::create(['user_id' => $user->id, 'interest_id' => $interest]);
            }

            DB::commit();
            $results['interests'] = new InterestsCollection(Interest::all());
            return $this->result = ['validator' => null, 'success' => 'User interests', 'errors' => null, 'object' => $results];
        } catch (\Exception $exception) {
            DB::rollback();
            return $this->result = ['validator' => null, 'success' => null, 'errors' => $exception, 'object' => null];
        }
    }

    public function changePassword($user)
    {
        $request = $this->request;
        DB::beginTransaction();
        try {
            $user->password = bcrypt($request->input('newPassword'));
            $user->save();
            DB::commit();
            return $this->result = ['validator' => null, 'success' => 'Password changed successfully', 'errors' => null, 'object' => null];
        } catch (\Exception $exception) {
            DB::rollback();
            return $this->result = ['validator' => null, 'success' => null, 'errors' => $exception, 'object' => null];
        }
    }

    public function getUserNotification()
    {
        $user_id = auth('api')->user()->id;
        $notifications = Notification::all()->sortByDesc("id");

        $result['notifications'] = [];
        $title = config('global.used_app_name', 'Tawredaat');
        foreach ($notifications as $notification) {
            if ($notification->users == null) {
                $parse = [
                    'id' => $notification->id,
                    'title' => $title,
                    'message' => $notification->message,
                    'created_at' => $notification->created_at,
                ];
                array_push($result['notifications'], $parse);
            } else {
                $usersIds = json_decode($notification->users);
                if (in_array($user_id, $usersIds)) {
                    $parse = [
                        'id' => $notification->id,
                        'title' => $title,
                        'message' => $notification->message,
                        'created_at' => $notification->created_at,
                    ];
                    array_push($result['notifications'], $parse);
                }

            }
        }
        return $result;
    }

    public function updateUserCartWithDefaultAddress($user_id,
        $update_address_with_default_action) {
        // check if the user has a cart
        $cart = Cart::where('user_id', $user_id)->first();
        if (!is_null($cart)) {
            // set address
            $update_address_with_default_action->execute($cart);
        }
    }
}
