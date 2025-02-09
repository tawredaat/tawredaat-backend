<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddingMoreKeysToUserAddresses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        // user_addresses_user_id_foreign
        $user_addresses_user_id_foreign_key_exists = DB::select(
            DB::raw(
                'SHOW KEYS
        FROM user_addresses
        WHERE Key_name="user_addresses_user_id_foreign"'
            )
        );
        if (!$user_addresses_user_id_foreign_key_exists) {
            if (Schema::hasColumn('user_addresses', 'user_id')) {
                $add_unique_address_raw = 'ALTER TABLE `user_addresses`
    ADD KEY `user_addresses_user_id_foreign` (`user_id`);';
                DB::statement($add_unique_address_raw);
            }
        }

        // user_addresses_city_id_foreign
        $user_addresses_city_id_foreign_key_exists = DB::select(
            DB::raw(
                'SHOW KEYS
        FROM user_addresses
        WHERE Key_name="user_addresses_city_id_foreign"'
            )
        );
        if (!$user_addresses_city_id_foreign_key_exists) {
            if (Schema::hasColumn('user_addresses', 'city_id')) {
                $add_unique_address_raw = 'ALTER TABLE `user_addresses`
  ADD KEY `user_addresses_city_id_foreign` (`city_id`);';
                DB::statement($add_unique_address_raw);
            }
        }

        // user_addresses_country_id_foreign
        $user_addresses_country_id_foreign_key_exists = DB::select(
            DB::raw(
                'SHOW KEYS
        FROM user_addresses
        WHERE Key_name="user_addresses_country_id_foreign"'
            )
        );
        if (!$user_addresses_country_id_foreign_key_exists) {
            if (Schema::hasColumn('user_addresses', 'country_id')) {
                $add_unique_address_raw = 'ALTER TABLE `user_addresses`
    ADD KEY `user_addresses_country_id_foreign` (`country_id`);';
                DB::statement($add_unique_address_raw);
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
        Schema::table('user_addresses', function (Blueprint $table) {
            //
        });
    }
}
