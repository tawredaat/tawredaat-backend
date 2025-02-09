<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddingKeysToOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (Schema::hasTable('orders')) {
            // primary key
            if (Schema::hasColumn('orders', 'id')) {
                $primary_key_exists = DB::select(
                    DB::raw(
                        'SHOW KEYS
        FROM orders
        WHERE Key_name="PRIMARY"'
                    )
                );
                if (!$primary_key_exists) {
                    $add_pk_key_raw = 'ALTER TABLE `orders`
                        ADD PRIMARY KEY (`id`)';
                    DB::statement($add_pk_key_raw);

                    // auto increment
                    $auto_increment_raw = 'ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;';
                    DB::statement($auto_increment_raw);
                }
            }

            // fks

            // user_id
            if (Schema::hasColumn('orders', 'user_id')) {
                $user_id_fk_key_exists = DB::select(
                    DB::raw(
                        'SHOW KEYS
        FROM orders
        WHERE Key_name="orders_user_id_foreign"'
                    )
                );
                if (!$user_id_fk_key_exists) {
                    DB::statement('ALTER TABLE `orders`
                     ADD KEY `orders_user_id_foreign` (`user_id`)');
                    DB::statement('ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign`
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL');

                }
            }

            // company_id
            if (Schema::hasColumn('orders', 'company_id')) {
                $company_id_fk_key_exists = DB::select(
                    DB::raw(
                        'SHOW KEYS
        FROM orders
        WHERE Key_name="orders_company_id_foreign"'
                    )
                );
                if (!$company_id_fk_key_exists) {
                    DB::statement('ALTER TABLE `orders`
                     ADD KEY `orders_company_id_foreign` (`company_id`)');
                    DB::statement(' ALTER TABLE `orders`
  ADD CONSTRAINT `orders_company_id_foreign` FOREIGN KEY (`company_id`)
  REFERENCES `companies` (`id`) ON DELETE SET NULL;'
                    );
                }
            }

            // payment_id
            if (Schema::hasColumn('orders', 'payment_id')) {
                $payment_id_fk_key_exists = DB::select(
                    DB::raw(
                        'SHOW KEYS
        FROM orders
        WHERE Key_name="orders_payment_id_foreign"'
                    )
                );
                if (!$payment_id_fk_key_exists) {
                    DB::statement('ALTER TABLE `orders`
                     ADD KEY `orders_payment_id_foreign` (`payment_id`)');
                    DB::statement(' ALTER TABLE `orders`
  ADD CONSTRAINT `orders_payment_id_foreign` FOREIGN KEY (`payment_id`)
  REFERENCES `payments` (`id`) ON DELETE SET NULL');
                }
            }

            // cancelled_by
            if (Schema::hasColumn('orders', 'cancelled_by')) {
                $cancelled_by_fk_key_exists = DB::select(
                    DB::raw(
                        'SHOW KEYS
        FROM orders
        WHERE Key_name="orders_cancelled_by_foreign"'
                    )
                );
                if (!$cancelled_by_fk_key_exists) {
                    DB::statement('ALTER TABLE `orders`
                     ADD KEY `orders_cancelled_by_foreign` (`cancelled_by`)');
                    DB::statement('  ALTER TABLE `orders`
  ADD CONSTRAINT `orders_cancelled_by_foreign` FOREIGN KEY (`cancelled_by`)
  REFERENCES `admins` (`id`) ON DELETE SET NULL;'
                    );
                }
            }

            // order_status_id
            if (Schema::hasColumn('orders', 'order_status_id')) {
                $order_status_id_fk_key_exists = DB::select(
                    DB::raw(
                        'SHOW KEYS
        FROM orders
        WHERE Key_name="orders_order_status_id_foreign"'
                    )
                );
                if (!$order_status_id_fk_key_exists) {
                    DB::statement('ALTER TABLE `orders`
                     ADD KEY `orders_order_status_id_foreign` (`order_status_id`)');
                    DB::statement('ALTER TABLE `orders`
  ADD CONSTRAINT `orders_order_status_id_foreign` FOREIGN KEY (`order_status_id`)
  REFERENCES `order_statuses` (`id`) ON DELETE SET NULL;'
                    );
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
}
