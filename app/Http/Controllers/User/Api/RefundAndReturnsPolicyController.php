<?php

namespace App\Http\Controllers\User\Api;

use App\Repository\User\HomeRepo;

class RefundAndReturnsPolicyController extends BaseResponse
{
    protected $homeRepo;

    public function __construct(HomeRepo $homeRepo)
    {
        $this->homeRepo = $homeRepo;
    }

    public function __invoke()
    {
        $result = $this->homeRepo->refundAndReturnsPolicy();

        if ($result['success']) {
            return $this->response(200, $result['success'], 200, [], 0, $result['object']);
        } elseif ($result['errors']) {
            return $this->response(500, $result['errors'], 500);
        } else {
            return $this->response(500, "Error", 500);
        }

    }

}
