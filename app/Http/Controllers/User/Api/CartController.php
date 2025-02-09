<?php

namespace App\Http\Controllers\User\Api;

use App\Actions\User\Cart\ApplyPromoCodeAction;
use App\Actions\User\Cart\ApplyPromoCodeGuestUserAction;
use App\Actions\User\Cart\UpdateAddressWithDefaultAction;
use App\Actions\User\Cart\UpdateCartWithPromoCodeId;
use App\Actions\User\GuestUser\StoreIdAction;
use App\Http\Requests\User\Api\Cart\ApplyPromoCodeRequest;
use App\Http\Requests\User\Api\StoreCartItemRequest;
use App\Http\Requests\User\Api\UpdateCartItemRequest;
use App\Repository\User\CartRepo;
use App\Repository\User\GuestCartRepo;
use App\User;
use App\Models\Promocode;
use Illuminate\Http\Request;
use App\Http\Resources\PromoCodeResource;

class CartController extends BaseResponse
{
    protected $cartRepo;
    protected $guest_cart_repo;
    protected $guest_id_store_action;

    public function __construct(CartRepo $cartRepo, GuestCartRepo $guest_cart_repo,
        StoreIdAction $guest_id_store_action) {
        $this->cartRepo = $cartRepo;
        $this->guest_cart_repo = $guest_cart_repo;
        $this->guest_id_store_action = $guest_id_store_action;
    }

    public function view(Request $request)
    {
        $user = User::getUser($request);

        if (!$user) {
            return $this->response(101, "Validation Error", 200,
                'You must register an account');
        }

        $result = $this->cartRepo->view($user);

        // else {
        //     $guest_user = $this->getGuestUser($request->guest_user_id);
        //     if (is_null($guest_user)) {
        //         return $this->response(500, __('validation.error'), 500);
        //     }
        //     $result = $this->guest_cart_repo->view($guest_user);
        // }

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

    public function store(Request $request,
        UpdateAddressWithDefaultAction $update_address_with_default_action) {
        $user = User::getUser($request);

        // user
        // if ($user) {
        //     $this->cartRepo->setReq($request);
        //     $result = $this->cartRepo->store($user, $update_address_with_default_action);
        // } else {
        //     $guest_user = $this->getGuestUser($request->guest_user_id);
        //     if (is_null($guest_user)) {
        //         return $this->response(500, __('validation.error'), 500);
        //     }
        //     $this->guest_cart_repo->setReq($request);
        //     $result = $this->guest_cart_repo->store($guest_user);
        // }

        $this->cartRepo->setReq($request);
        $user = User::getUser($request);
        if (!$user) {
            return $this->response(101, "Validation Error", 200, 'You must register an account');
        }

        $result = $this->cartRepo->store($user, $update_address_with_default_action);

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

    public function update(UpdateCartItemRequest $request)
    {
        // $user = User::getUser($request);
        // if ($user) {
        //     $this->cartRepo->setReq($request);
        //     $result = $this->cartRepo->update($user);
        // } else {
        //     $this->guest_cart_repo->setReq($request);

        //     $guest_user = $this->getGuestUser($request->guest_user_id);
        //     if (is_null($guest_user)) {
        //         return $this->response(500, __('validation.error'), 500);
        //     }
        //     $result = $this->guest_cart_repo->update($guest_user);
        // }

        $this->cartRepo->setReq($request);
        $user = User::getUser($request);
        if (!$user) {
            return $this->response(101, "Validation Error", 200, 'You must register an account');
        }

        $result = $this->cartRepo->update($user);

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

    public function delete(Request $request, $id)
    {
        // $user = User::getUser($request);
        // if ($user) {
        //     $result = $this->cartRepo->delete($user, $id);
        // } else {
        //     $guest_user = $this->getGuestUser($request->guest_user_id);
        //     if (is_null($guest_user)) {
        //         return $this->response(500, __('validation.error'), 500);
        //     }
        //     $result = $this->guest_cart_repo->delete($guest_user, $id);
        // }

        $user = User::getUser($request);
        if (!$user) {
            return $this->response(101, "Validation Error", 200, 'You must register an account');
        }

        $result = $this->cartRepo->delete($user, $id);

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
    
    public function deleteBundel(Request $request, $id)
    {
        $user = User::getUser($request);
        if (!$user) {
            return $this->response(101, "Validation Error", 200, 'You must register an account');
        }

        $result = $this->cartRepo->deleteBundel($user, $id);

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

    public function applyPromoCode(ApplyPromoCodeRequest $request,
        ApplyPromoCodeAction $apply_promo_code_action,
        ApplyPromoCodeGuestUserAction $apply_promo_code_guest_user_action,
        UpdateCartWithPromoCodeId $update_cart_with_promo_code_id) {

        // $user = User::getUser($request);
        // if ($user) {
        //     $result = $this->cartRepo->applyPromoCode($user, $request->code,
        //         $apply_promo_code_action, $update_cart_with_promo_code_id);
        // } else {
        //     $guest_user = $this->getGuestUser($request->guest_user_id);
        //     if (is_null($guest_user)) {
        //         return $this->response(500, __('validation.error'), 500);
        //     }
        //     $result = $this->guest_cart_repo->applyPromoCode($guest_user, $request->code,
        //         $apply_promo_code_guest_user_action, $update_cart_with_promo_code_id);
        // }

        $user = User::getUser($request);
        if (!$user) {
            return $this->response(101, "Validation Error", 200, 'You must register an account');
        }

        $result = $this->cartRepo->applyPromoCode($user, $request->code,
            $apply_promo_code_action, $update_cart_with_promo_code_id);

        if ($result['success']) {
            return $this->response(200, $result['success'], 200, [], 0, $result['object']);
        } elseif ($result['validator']) {
            return $this->response(101, "Validation Error", 200, $result['validator']);
        } elseif ($result['errors']) {
            return $this->response(403, $result['errors']->getMessage(),  403);
        } else {
            return $this->response(500, "Error", 500);
        }

    }

    function empty(Request $request) {
        $user = User::getUser($request);
        if (!$user) {
            return $this->response(101, "Validation Error", 200, 'You must register an account');
        }

        $result = $this->cartRepo->empty($user);

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

    public function promoDetails($promo)
    {
        $promo = Promocode::where('code', $promo)->first();

        // Check if promo code exists
        if (!$promo) {
            return $this->response(422, 'Promo code not found', 422, [], 0, null);
        }

        // If promo code exists, return the promo details
        $result = new PromoCodeResource($promo);
        return $this->response(200, 'true', 200, [], 0, $result);
    }
    
    // private function getGuestUser($guest_user_id)
    // {
    //     if (is_null($guest_user_id)) {
    //         // create guest user
    //         DB::beginTransaction();
    //         try {
    //             $guest_user = $this->guest_id_store_action->execute();
    //             DB::commit();
    //         } catch (\Exception $exception) {
    //             DB::rollback();
    //             return null;
    //         }

    //     } else {
    //         $guest_user = GuestUser::where('id', $guest_user_id)->first();
    //     }
    //     return $guest_user;
    // }
}
