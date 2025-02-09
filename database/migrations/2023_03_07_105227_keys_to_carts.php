<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class KeysToCarts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('carts')) {
            // primary key
            if (Schema::hasColumn('carts', 'id')) {
                $primary_key_exists = DB::select(
                    DB::raw(
                        'SHOW KEYS
        FROM carts
        WHERE Key_name="PRIMARY"'
                    )
                );
                if (!$primary_key_exists) {
                    DB::statement('ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`);');

                    // auto increment
                    DB::statement('ALTER TABLE `carts`
 MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=843;');
                }
            }
            // fks
            // user_id
            if (Schema::hasColumn('carts', 'user_id')) {
                $user_id_fk_key_exists = DB::select(
                    DB::raw(
                        'SHOW KEYS
        FROM carts
        WHERE Key_name="carts_user_id_foreign"'
                    )
                );
                if (!$user_id_fk_key_exists) {
                    DB::statement('ALTER TABLE `carts`
                      ADD KEY `carts_user_id_foreign` (`user_id`);');

                    DB::statement('ALTER TABLE `carts`
ADD CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`)
REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;');
                }
            }
// user_address_id
            if (Schema::hasColumn('carts', 'user_address_id')) {
                $user_address_id_fk_key_exists = DB::select(
                    DB::raw(
                        'SHOW KEYS
        FROM carts
        WHERE Key_name="carts_user_address_id_foreign"'
                    )
                );
                if (!$user_address_id_fk_key_exists) {
                    DB::statement('ALTER TABLE `carts`
                      ADD KEY `carts_user_address_id_foreign` (`user_address_id`);');

                    DB::statement('ALTER TABLE `carts`
  ADD CONSTRAINT `carts_user_address_id_foreign` FOREIGN KEY (`user_address_id`)
  REFERENCES `user_addresses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;');
                }
            }
// payment_id
            if (Schema::hasColumn('carts', 'payment_id')) {
                $payment_id_fk_key_exists = DB::select(
                    DB::raw(
                        'SHOW KEYS
        FROM carts
        WHERE Key_name="carts_payment_id_foreign"'
                    )
                );
                if (!$payment_id_fk_key_exists) {
                    DB::statement('ALTER TABLE `carts`
                      ADD KEY `carts_payment_id_foreign` (`payment_id`);');

                    DB::statement('ALTER TABLE `carts`
 ADD CONSTRAINT `carts_payment_id_foreign` FOREIGN KEY (`payment_id`)
  REFERENCES `payments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;');
                }
            }
// promocode_id
            if (Schema::hasColumn('carts', 'promocode_id')) {
                $promocode_id_fk_key_exists = DB::select(
                    DB::raw(
                        'SHOW KEYS
        FROM carts
        WHERE Key_name="carts_promocode_id_foreign"'
                    )
                );
                if (!$promocode_id_fk_key_exists) {
                    DB::statement('ALTER TABLE `carts`
                      ADD KEY `carts_promocode_id_foreign` (`promocode_id`);');

                    DB::statement('ALTER TABLE `carts`
 ADD CONSTRAINT `carts_promocode_id_foreign` FOREIGN KEY (`promocode_id`)
 REFERENCES `promocodes` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;');
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
        Schema::table('carts', function (Blueprint $table) {
            //
        });
    }
}
