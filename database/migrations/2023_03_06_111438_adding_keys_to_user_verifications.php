<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddingKeysToUserVerifications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('user_verifications')) {
            // primary key
            if (Schema::hasColumn('user_verifications', 'id')) {
                $primary_key_exists = DB::select(
                    DB::raw(
                        'SHOW KEYS
        FROM user_verifications
        WHERE Key_name="PRIMARY"'
                    )
                );
                if (!$primary_key_exists) {
                    DB::statement('ALTER TABLE `user_verifications`
  ADD PRIMARY KEY (`id`);');

                    // auto increment
                    DB::statement('ALTER TABLE `user_verifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2350;');

                }
            }

            if (Schema::hasColumn('user_verifications', 'user_id')) {
                $user_id_fk_key_exists = DB::select(
                    DB::raw(
                        'SHOW KEYS
        FROM user_verifications
        WHERE Key_name="user_verifications_user_id_foreign"'
                    )
                );
                if (!$user_id_fk_key_exists) {
                    DB::statement('ALTER TABLE `user_verifications`
                      ADD KEY `user_verifications_user_id_foreign` (`user_id`);');

                    DB::statement('ALTER TABLE `user_verifications`
  ADD CONSTRAINT `user_verifications_user_id_foreign` FOREIGN KEY (`user_id`)
   REFERENCES `users` (`id`) ON DELETE CASCADE;');

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
        Schema::table('user_verifications', function (Blueprint $table) {
            //
        });
    }
}