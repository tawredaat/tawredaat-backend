<?php

use App\Models\OrderStatus;
use Illuminate\Database\Seeder;

class NewOrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // check if the order status does not exist
        if (is_null(OrderStatus::whereHas('translations', function ($query) {
            $query->where('name', 'Approved by Client')
            ->whereRaw('LOWER(`name`) LIKE ? ', [trim(strtolower('Approved by Client')) . '%'])
            ->where('locale', 'en');
        })->first())) {
            OrderStatus::create([
                'color' => '#FFF',
                'en' => ['name' => 'Approved by Client'],
                'ar' => ['name' => 'وافق عليها العميل'],
            ]);
        }

        // check if the order status does not exist
        if (is_null(OrderStatus::whereHas('translations', function ($query) {
            $query->where('name', 'Preparing')
            ->whereRaw('LOWER(`name`) LIKE ? ', [trim(strtolower('Preparing')) . '%'])
            ->where('locale', 'en');
        })->first())) {
            OrderStatus::create([
                'color' => '#FFF',
                'en' => ['name' => 'Preparing'],
                'ar' => ['name' => 'جاري التحضير'],
            ]);
        }

        // check if the order status does not exist
        if (is_null(OrderStatus::whereHas('translations', function ($query) {
            $query->where('name', 'Verifying order')
            ->whereRaw('LOWER(`name`) LIKE ? ', [trim(strtolower('Verifying order')) . '%'])
            ->where('locale', 'en');
        })->first())) {
            OrderStatus::create([
                'color' => '#FFF',
                'en' => ['name' => 'Verifying order'],
                'ar' => ['name' => 'جاري التأكد من الطلب'],
            ]);
        }

    }
}
