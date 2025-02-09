<?php

namespace App\Actions\User\OnlineTransactionValu;

use App\Models\OnlineTransactionValu;

class StoreAction
{
    public function execute($data, $online_transaction_id)
    {
        return OnlineTransactionValu::create([
            'online_transaction_id' => $online_transaction_id,
            'down_payment' => $data['obj']['data']['down_payment'],
            'installment_plan' => $data['obj']['source_data']['tenure'],
            'installment_plan_list' => json_encode($data['obj']['data']['tenure_list']),
            'monthly_installment' => $data['obj']['data']['emi'],
            'purchase_fees' => $data['obj']['data']['purchase_fees'],
            'customer_code' => $data['obj']['source_data']['customer_code'],
            'receipt_url' => $data['obj']['data']['receipt_url'],
            'purchase_ref_number' => $data['obj']['data']['purchase_ref_number'],
            'product_ref_number' => $data['obj']['data']['product_ref_number'],
            'pan' => $data['obj']['source_data']['pan'],
        ]);

    }
}
