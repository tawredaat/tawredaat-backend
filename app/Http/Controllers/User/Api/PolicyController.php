<?php

namespace App\Http\Controllers\User\Api;

use App\Http\Resources\FAQResource;
use App\Models\FAQ;

class PolicyController extends BaseResponse
{
    public function faqs()
    {
        $result['faqs'] = null;
        try {
            $faqs = FAQ::first();
            if ($faqs) {
                $results['faqs'] = new FAQResource($faqs);
                return ['validator' => null, 'success' => 'success', 'errors' => null, 'object' => $results];
            }
            return ['validator' => 'FAQs Not found', 'success' => null, 'errors' => null, 'object' => null];
        } catch (\Exception $exception) {
            return ['validator' => null, 'success' => null, 'errors' => $exception, 'object' => null];
        }

    }
}
