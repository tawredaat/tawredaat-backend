<?php

namespace App\Http\Controllers\User\Api;

use App\Http\Resources\PaymentNoteResource;
use App\Models\PaymentNote;
use Illuminate\Http\Request;

class PaymentNoteController extends BaseResponse
{
    public function __construct()
    {
    }

    public function list(Request $request)
    {
        $result = PaymentNoteResource::collection(PaymentNote::all());
        return $this->response(200, "Home Screen", 200, [], 0, $result);
    }
}
