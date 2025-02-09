<?php

namespace App\Actions\User\Survey;

use App\Models\Survey;

class StoreAction
{
    public function execute($request)
    {
        return Survey::create([
            'order_id' => $request->order_id,
            'finding_ease_score' => $request->finding_ease_score,
            'usage_problems_score' => $request->usage_problems_score,
            'usage_problems_explanation' => $request->usage_problems_explanation,
            'shipping_time_score' => $request->shipping_time_score,
            'product_quality_delivery_time_score' => $request->product_quality_delivery_time_score,
            'courier_score' => $request->courier_score,
        ]);

    }
}
