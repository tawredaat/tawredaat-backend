<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddingKeysToOauthRefreshTokens extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('oauth_refresh_tokens')) {
            // primary key
            if (Schema::hasColumn('oauth_refresh_tokens', 'id')) {
                $primary_key_exists = DB::select(
                    DB::raw(
                        'SHOW KEYS
        FROM oauth_refresh_tokens
        WHERE Key_name="PRIMARY"'
                    )
                );
                if (!$primary_key_exists) {
                    DB::statement('ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`);');

                }
            }
            // access_token_id
            if (Schema::hasColumn('oauth_refresh_tokens', 'access_token_id')) {
                $access_token_id_fk_key_exists = DB::select(
                    DB::raw(
                        'SHOW KEYS
        FROM oauth_refresh_tokens
        WHERE Key_name="oauth_refresh_tokens_access_token_id_foreign"'
                    )
                );
                if (!$access_token_id_fk_key_exists) {
                    DB::statement('ALTER TABLE `oauth_refresh_tokens`
                     ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`)');

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
        Schema::table('oauth_refresh_tokens', function (Blueprint $table) {
            //
        });
    }
}
