<?php

namespace App\Http\Controllers\User\Api;

use App\Http\Requests\User\Api\Auth\ForgotPasswordRequest;
use App\Http\Requests\User\Api\CreateUserRequest;
use App\Http\Requests\User\Api\CreateConsumerRequest;
use App\Http\Requests\User\Api\CreateTechnicianRequest;
use App\Http\Requests\User\Api\CreateCompanyRequest;
use App\Http\Requests\User\Api\LoginProviderUser;
use App\Http\Requests\User\Api\ResendCodeRequest;
use App\Http\Requests\User\Api\UserLogin;
use App\Http\Requests\User\Api\VerifyUserRequest;
use App\Repository\User\AuthRepo;
use Illuminate\Support\Facades\Auth;

class AuthController extends BaseResponse
{
    protected $authRepo;

    public function __construct(AuthRepo $authRepo)
    {
        $this->authRepo = $authRepo;
    }

    public function allInterests()
    {
        $result = $this->authRepo->allInterests();
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

    public function register_consumer(CreateConsumerRequest $request)
    {
        $this->authRepo->setReq($request);
        $result = $this->authRepo->register_consumer();
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
    
    public function register_company(CreateCompanyRequest $request)
    {
        $this->authRepo->setReq($request);
        $result = $this->authRepo->register_company();
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
    
    public function register_technician(CreateTechnicianRequest $request)
    {
        $this->authRepo->setReq($request);
        $result = $this->authRepo->register_technician();
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

    public function login(UserLogin $request)
    {
        $this->authRepo->setReq($request);
        $result = $this->authRepo->login(); //
        if ($result['success']) {
            return $this->response(200, $result['success'], 200, [], 0, $result['object'])
                ->cookie('user_id', $result['object']['user']->id);
        } elseif ($result['validator']) {
            if (isset($result['userId'])) {
                return $this->response(intval($result['status']), "Validation Error", 200, $result['validator'], intval($result['userId']));
            } else {
                return $this->response(101, "Validation Error", 200, $result['validator']);
            }

        } elseif ($result['errors']) {
            return $this->response(500, $result['errors'], 500);
        } else {
            return $this->response(500, "Error", 500);
        }

    }

    public function VerifyAccount(VerifyUserRequest $request)
    {
        $this->authRepo->setReq($request);
        $result = $this->authRepo->VerifyAccount();
        if ($result['success']) {
            return $this->response(200, $result['success'], 200, [], 0, $result['object']);
        } elseif ($result['validator']) {
            return $this->response(101, 'Validation Error', 200, $result['validator']);
        } elseif ($result['errors']) {
            return $this->response(500, $result['errors'], 500);
        } else {
            return $this->response(500, "Error", 500);
        }

    }

    public function resendVerify(ResendCodeRequest $request)
    {
        $this->authRepo->setReq($request);
        $result = $this->authRepo->resendVerify();
        if ($result['success']) {
            return $this->response(200, $result['success'], 200);
        } elseif ($result['validator']) {
            return $this->response(101, 'Validation Error', 200, $result['validator']);
        } elseif ($result['errors']) {
            return $this->response(500, $result['errors'], 500);
        } else {
            return $this->response(500, "Error", 500);
        }

    }

    public function getVerifyCodes()
    {
        $result = $this->authRepo->getVerifyCodes();
        if ($result['success']) {
            return $this->response(200, $result['success'], 200, [], 0, $result['object']);
        } elseif ($result['errors']) {
            return $this->response(500, $result['errors'], 500);
        } else {
            return $this->response(500, "Error", 500);
        }

    }

    public function forgetPassword(ForgotPasswordRequest $request)
    {
        $this->authRepo->setReq($request);
        $result = $this->authRepo->sendNewPassword();
        if ($result['success']) {
            return $this->response(200, $result['success'], 200, [], 0, $result['object']);
        } elseif ($result['validator']) {
            return $this->response(101, 'Validation Error', 200, $result['validator']);
        } elseif ($result['errors']) {
            return $this->response(500, $result['errors'], 500);
        } else {
            return $this->response(500, "Error", 500);
        }

    }

    public function loginProvider(LoginProviderUser $request)
    {
        $this->authRepo->setReq($request);
        $result = $this->authRepo->registerOrLoginProvider();
        if ($result['success']) {
            return $this->response(200, $result['success'], 200, [], 0, $result['user']);
        } elseif ($result['validator']) {
            return $this->response(101, 'Validation Error', 200, $result['validator']);
        } elseif ($result['errors']) {
            return $this->response(500, __('home.sameProvider'), 500);
        } else {
            return $this->response(500, "Error", 500);
        }

    }

    public function logout()
    {
        $user = auth('api')->user();
        if ($user) {
            $request->user()->tokens()->delete();
        }
        return $this->response(200, 'User Logged Out', 200);
    }
}
