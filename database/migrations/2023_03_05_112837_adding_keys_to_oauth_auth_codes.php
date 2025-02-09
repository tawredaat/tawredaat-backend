<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddingKeysToOauthAuthCodes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('oauth_auth_codes')) {
            // primary key
            if (Schema::hasColumn('oauth_auth_codes', 'id')) {
                $primary_key_exists = DB::select(
                    DB::raw(
                        'SHOW KEYS
        FROM oauth_auth_codes
        WHERE Key_name="PRIMARY"'
                    )
                );
                if (!$primary_key_exists) {
                    DB::statement('ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`);');

                }
            }
            // user_id
            if (Schema::hasColumn('oauth_auth_codes', 'user_id')) {
                $user_id_fk_key_exists = DB::select(
                    DB::raw(
                        'SHOW KEYS
        FROM oauth_auth_codes
        WHERE Key_name="oauth_auth_codes_user_id_index"'
                    )
                );
                if (!$user_id_fk_key_exists) {
                    DB::statement('ALTER TABLE `oauth_auth_codes`
                      ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);');

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
        Schema::table('oauth_auth_codes', function (Blueprint $table) {
            //
        });
    }
}
