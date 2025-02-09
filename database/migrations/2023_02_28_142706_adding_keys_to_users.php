<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddingKeysToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('users')) {
            // primary key
            $primary_key_exists = DB::select(
                DB::raw(
                    'SHOW KEYS
        FROM users
        WHERE Key_name="PRIMARY"'
                )
            );
            if (!$primary_key_exists) {
                if (Schema::hasColumn('users', 'id')) {
                    $add_keys_raw = 'ALTER TABLE `users`
                        ADD PRIMARY KEY (`id`)';
                    DB::statement($add_keys_raw);
                    // auto increment
                    $auto_increment_raw = 'ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7692;';
                    DB::statement($auto_increment_raw);

                }
            }

            // user address fk
            $users_user_address_id_foreign_key_exists = DB::select(
                DB::raw(
                    'SHOW KEYS
        FROM users
        WHERE Key_name="users_user_address_id_foreign"'
                )
            );
            if (!$users_user_address_id_foreign_key_exists) {
                if (Schema::hasColumn('users', 'user_address_id')) {
                    $add_user_address_fk_key_raw = 'ALTER TABLE `users`
  ADD CONSTRAINT `users_user_address_id_foreign` FOREIGN KEY (`user_address_id`)
  REFERENCES `user_addresses` (`id`) ON DELETE SET NULL;';
                    DB::statement($add_user_address_fk_key_raw);
                }
            }

            // users_email_unique
            $users_email_unique_key_exists = DB::select(
                DB::raw(
                    'SHOW KEYS
        FROM users
        WHERE Key_name="users_email_unique"'
                )
            );
            if (!$users_email_unique_key_exists) {
                if (Schema::hasColumn('users', 'email')) {
                    $add_unique_address_raw = 'ALTER TABLE `users`
    ADD UNIQUE KEY `users_email_unique` (`email`);';
                    DB::statement($add_unique_address_raw);
                }
            }

            // users_provider_id_unique
            $users_provider_id_unique_key_exists = DB::select(
                DB::raw(
                    'SHOW KEYS
        FROM users
        WHERE Key_name="users_provider_id_unique"'
                )
            );
            if (!$users_provider_id_unique_key_exists) {
                if (Schema::hasColumn('users', 'provider_id')) {
                    $add_unique_address_raw = 'ALTER TABLE `users`
    ADD UNIQUE KEY `users_provider_id_unique` (`provider_id`);';
                    DB::statement($add_unique_address_raw);
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
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
