<?php

namespace App\Http\Controllers\User\Api;

use App\Actions\User\Survey\StoreAction;
use App\Http\Requests\User\Api\Survey\SurveyRequest;
use App\Http\Resources\SurveyResource;
use Illuminate\Support\Facades\DB;

class SurveyController extends BaseResponse
{
    public function __invoke(SurveyRequest $request, StoreAction $store_action)
    {
        try {
            DB::beginTransaction();
            $survey = $store_action->execute($request);
            DB::commit();
            return ['validator' => null, 'success' => 'Order Status',
                'errors' => null,
                'object' => new SurveyResource($survey)];
        } catch (\Exception $exception) {
            DB::rollBack();
            return ['validator' => null, 'success' => null,
                'errors' => $exception, 'object' => null];
        }

    }
}
