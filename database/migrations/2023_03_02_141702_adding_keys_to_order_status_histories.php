<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddingKeysToOrderStatusHistories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('order_status_histories')) {
            // primary key
            if (Schema::hasColumn('order_status_histories', 'id')) {
                $primary_key_exists = DB::select(
                    DB::raw(
                        'SHOW KEYS
        FROM order_status_histories
        WHERE Key_name="PRIMARY"'
                    )
                );
                if (!$primary_key_exists) {
                    DB::statement('ALTER TABLE `order_status_histories`
                        ADD PRIMARY KEY (`id`)');

                    // auto increment
                    DB::statement('ALTER TABLE `order_status_histories`
 MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;');
                }
            }

            // fks
            // order_id
            if (Schema::hasColumn('order_status_histories', 'order_id')) {
                $order_id_fk_key_exists = DB::select(
                    DB::raw(
                        'SHOW KEYS
        FROM order_status_histories
        WHERE Key_name="order_status_histories_order_id_foreign"'
                    )
                );
                if (!$order_id_fk_key_exists) {
                    DB::statement('ALTER TABLE `order_status_histories`
                     ADD KEY `order_status_histories_order_id_foreign` (`order_id`)');
                    DB::statement('ALTER TABLE `order_status_histories`
   ADD CONSTRAINT `order_status_histories_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;'
                    );
                }
            }

            // status_id
            if (Schema::hasColumn('order_status_histories', 'status_id')) {
                $status_id_fk_key_exists = DB::select(
                    DB::raw(
                        'SHOW KEYS
        FROM order_status_histories
        WHERE Key_name="order_status_histories_status_id_foreign"'
                    )
                );
                if (!$status_id_fk_key_exists) {
                    DB::statement('ALTER TABLE `order_status_histories`
                     ADD KEY `order_status_histories_status_id_foreign` (`status_id`)');
                    DB::statement('ALTER TABLE `order_status_histories`
    ADD CONSTRAINT `order_status_histories_status_id_foreign` FOREIGN KEY (`status_id`) REFERENCES `order_statuses` (`id`) ON DELETE CASCADE;'
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
        Schema::table('order_status_histories', function (Blueprint $table) {
            //
        });
    }
}
