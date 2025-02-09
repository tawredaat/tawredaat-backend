<?php

namespace App\Http\Controllers\User\Api;

use App\Actions\User\GuestUser\StoreAction;
use App\Http\Controllers\User\Api\BaseResponse;
use App\Http\Requests\User\Api\GuestUser\StoreRequest;
use App\Http\Resources\GuestUserResource;
use App\Models\GuestUser;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class GuestUserController extends BaseResponse
{
    public function store(StoreRequest $request, StoreAction $store_action)
    {
        try {
            $guest_user = GuestUser::findOrFail($request->id);
        } catch (ModelNotFoundException $e) {
            return $this->response(101, 'Validation Error', 200,
                [__('User::validation.not_found')]);
        }

        DB::beginTransaction();
        try {

            $store_action->execute($request);
            DB::commit();
            return $this->response(200, __('validation.created'), 200, [], 0, [
                'guest_user' => new GuestUserResource($guest_user)]);
        } catch (\Exception $exception) {
            DB::rollback();
            return $this->response(500, "Error", 500);
        }

    }
}
