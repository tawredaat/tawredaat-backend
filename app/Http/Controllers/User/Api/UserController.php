<?php

namespace App\Http\Controllers\User\Api;

use App\Actions\User\Cart\UpdateAddressWithDefaultAction;
use App\Actions\User\UserAddress\SetAddressIdNullInCartAction;
use App\Actions\User\UserAddress\SetDefaultAction;
use App\Http\Controllers\User\Api\Notifications\SendPushNotificationController;
use App\Http\Requests\User\Api\ChangePasswordRequest;
use App\Http\Requests\User\Api\SelectUserAddress;
use App\Http\Requests\User\Api\SelectUserInterests;
use App\Http\Requests\User\Api\StoreUserAddressRequest;
use App\Http\Requests\User\Api\UpdateUserProfileRequest;
use App\Http\Requests\User\Api\UserAddress\SetDefaultUserAddressRequest;
use App\Http\Resources\UserAddressResource;
use App\Http\Resources\UserResource;
use App\Models\UserAddress;
use App\Repository\User\UserRepo;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends BaseResponse
{

    protected $userRepo;

    public function __construct(UserRepo $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function showProfile()
    {
        $result = $this->userRepo->userInfo();
        if ($result['success']) {
            return $this->response(200, $result['success'], 200, [], 0, $result['object']);
        } elseif ($result['errors']) {
            return $this->response(500, $result['errors'], 500);
        } else {
            return $this->response(500, "Error", 500);
        }

    }

    public function getProfile($user_id)
    {
        try {
            $user = User::findOrFail($user_id);

            return
                ['validator' => null, 'success' => 'User data',
                'errors' => null, 'object' => new UserResource($user)];
        } catch (\Exception $exception) {
            return ['validator' => null, 'success' => null,
                'errors' => $exception, 'object' => null];
        }

    }

    public function updateProfile(UpdateUserProfileRequest $request)
    {
        $this->userRepo->setReq($request);
        $result = $this->userRepo->updateUserInfo(auth('api')->user()->id);
        if ($result['success']) {
            return $this->response(200, $result['success'], 200, [], (int) auth('api')->user()->id, $result['object']);
        } elseif ($result['errors']) {
            return $this->response(500, $result['errors'], 500);
        } else {
            return $this->response(500, "Error", 500);
        }

    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $this->userRepo->setReq($request);
        $result = $this->userRepo->changePassword(auth('api')->user());
        if ($result['success']) {
            return $this->response(200, $result['success'], 200, [], 0, $result['object']);
        } elseif ($result['errors']) {
            return $this->response(500, $result['errors'], 500);
        } else {
            return $this->response(500, "Error", 500);
        }

    }

    public function viewAddresses()
    {
        $result = $this->userRepo->viewAddresses(auth('api')->user());
        if ($result['success']) {
            return $this->response(200, $result['success'], 200, [], 0, $result['object']);
        } elseif ($result['errors']) {
            return $this->response(500, $result['errors'], 500);
        } else {
            return $this->response(500, "Error", 500);
        }

    }

    public function addAddress(StoreUserAddressRequest $request,
        SetDefaultAction $set_default_action,
        UpdateAddressWithDefaultAction $update_address_with_default_action) {
        $this->userRepo->setReq($request);
        $result = $this->userRepo->addAddress(auth('api')->user(), $set_default_action,
            $update_address_with_default_action);
        if ($result['success']) {
            return $this->response(200, $result['success'], 200, [], 0, $result['object']);
        } elseif ($result['errors']) {
            return $this->response(500, $result['errors'], 500);
        } else {
            return $this->response(500, "Error", 500);
        }

    }

    public function updateAddress(StoreUserAddressRequest $request, $id,
        SetDefaultAction $set_default_action,
        UpdateAddressWithDefaultAction $update_address_with_default_action) {
        $this->userRepo->setReq($request);
        $result = $this->userRepo->updateAddress(auth('api')->user(), $id,
            $set_default_action, $update_address_with_default_action);
        if ($result['success']) {
            return $this->response(200, $result['success'], 200, [], 0, $result['object']);
        } elseif ($result['validator']) {
            return $this->response(101, "Validation Error", 200, $result['validator']);
        } elseif ($result['errors']) {
            return $this->response(500, $result['errors'], 500);
        } else {
            return $this->response(500, "Error", 500);
        }

    }

    public function deleteAddress($id, SetAddressIdNullInCartAction $set_address_id_null_in_cart_action)
    {
        try {
            UserAddress::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return $this->response(101, 'Validation Error', 200,
                [__('validation.does_not_exist')]);
        }

        $set_address_id_null_in_cart_action->execute($id);
        $result = $this->userRepo->deleteAddress(auth('api')->user(), $id);
        if ($result['success']) {
            return $this->response(200, $result['success'], 200, [], 0, $result['object']);
        } elseif ($result['validator']) {
            return $this->response(101, "Validation Error", 200, $result['validator']);
        } elseif ($result['errors']) {
            return $this->response(500, $result['errors'], 500);
        } else {
            return $this->response(500, "Error", 500);
        }

    }

    // setDefault
    public function setDefault(SetDefaultUserAddressRequest $request,
        SetDefaultAction $set_default_action,
        UpdateAddressWithDefaultAction $update_address_with_default_action) {
        DB::beginTransaction();
        try {
            $set_default_action->execute($request->id);
            $this->userRepo->updateUserCartWithDefaultAddress(auth('api')->user()->id,
                $update_address_with_default_action);
            DB::commit();
            return $this->response(200, 'Success', 200, [], 0,
                ['address' =>
                    UserAddressResource::collection(UserAddress::where('user_id', auth()->user()->id)->get())]);
        } catch (\Exception $exception) {
            DB::rollback();
            return $this->response(500, "Error", 500);
        }
    }

    public function selectAddress(SelectUserAddress $request)
    {
        $this->userRepo->setReq($request);
        $result = $this->userRepo->selectAddress(auth('api')->user());
        if ($result['success']) {
            return $this->response(200, $result['success'], 200, [], 0, $result['object']);
        } elseif ($result['validator']) {
            return $this->response(101, "Validation Error", 200, $result['validator']);
        } elseif ($result['errors']) {
            return $this->response(500, $result['errors'], 500);
        } else {
            return $this->response(500, "Error", 500);
        }

    }

    public function viewInterests()
    {
        $result = $this->userRepo->viewInterests(auth('api')->user());
        if ($result['success']) {
            return $this->response(200, $result['success'], 200, [], 0, $result['object']);
        } elseif ($result['errors']) {
            return $this->response(500, $result['errors'], 500);
        } else {
            return $this->response(500, "Error", 500);
        }

    }

    public function selectInterests(SelectUserInterests $request)
    {
        $this->userRepo->setReq($request);
        $result = $this->userRepo->selectInterests(auth('api')->user());
        if ($result['success']) {
            return $this->response(200, $result['success'], 200, [], 0, $result['object']);
        } elseif ($result['errors']) {
            return $this->response(500, $result['errors'], 500);
        } else {
            return $this->response(500, "Error", 500);
        }

    }

    public function getNotifications()
    {
        $result = $this->userRepo->getUserNotification();
        if (!is_null($result)) {
            return $this->response(200, "Notifications", 200, [], 0, $result);
        } else {
            return $this->response(200, 'Notifications', 200, ['No Notifications Found']);
        }

    }

    public function sendNotification()
    {
        if (!is_null(Auth::guard('api')->user()->firebase_token)) {
            $firebaseToken = Auth::guard('api')->user()->firebase_token;
            $deviceType = Auth::guard('api')->user()->device_type;

            $sendNotify = new SendPushNotificationController();
            if ($deviceType == 'IOS') {
                return $sendNotify->sendIosNotification(1, 'Test one To ios', 'This is new notification', $firebaseToken);
            } else {
                return $sendNotify->sendAndroidNotification('Test one to android', 'This is new notification', $firebaseToken, 0, 1);
            }
        }
        return "User without firebase Token";
    }
}
