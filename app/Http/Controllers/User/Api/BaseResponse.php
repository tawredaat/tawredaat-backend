<?php
namespace App\Http\Controllers\User\Api;
use App\Http\Controllers\Controller;

class BaseResponse extends Controller
{
    protected function response($code, $message, $statusCode , $validations = [], $item = 0, $object = null)
    {
        return response()->json(['code' => $code,'message' => $message, 'validation' => $validations,
            'item' => $item, 'data' => $object],$statusCode);
    }
}
