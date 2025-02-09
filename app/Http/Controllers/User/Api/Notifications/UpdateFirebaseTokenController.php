<?php

namespace App\Http\Controllers\User\Api\Notifications;

use App\Http\Controllers\User\Api\BaseResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UpdateFirebaseTokenController extends BaseResponse
{
    public function __invoke(Request $request)
    {
        $user = auth('api')->user();

        $token = $request->input('token');
        DB::beginTransaction();
        try {
            $user->firebase_token = $token;
            $user->save();
            DB::commit();
            return $this->response(200, "Token Updated successfully", 200);
        } catch (\Exception $exception) {
            DB::rollback();
            return $this->response(500, "Error", 500);
        }
    }
}
