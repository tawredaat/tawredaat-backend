<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddingKeysToUserInterests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (Schema::hasTable('user_interests')) {
            // primary key
            if (Schema::hasColumn('user_interests', 'id')) {
                $primary_key_exists = DB::select(
                    DB::raw(
                        'SHOW KEYS
        FROM user_interests
        WHERE Key_name="PRIMARY"'
                    )
                );
                if (!$primary_key_exists) {
                    DB::statement('ALTER TABLE `user_interests`
  ADD PRIMARY KEY (`id`);');

                    // auto increment
                    DB::statement('ALTER TABLE `user_interests`
 MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;');

                }
            }

            // fks
            // user_id
            if (Schema::hasColumn('user_interests', 'user_id')) {
                $user_id_fk_key_exists = DB::select(
                    DB::raw(
                        'SHOW KEYS
        FROM user_interests
        WHERE Key_name="user_interests_user_id_foreign"'
                    )
                );
                if (!$user_id_fk_key_exists) {
                    DB::statement('ALTER TABLE `user_interests`
                      ADD KEY `user_interests_user_id_foreign` (`user_id`);');

                    DB::statement('ALTER TABLE `user_interests`
  ADD CONSTRAINT `user_interests_user_id_foreign` FOREIGN KEY (`user_id`)
   REFERENCES `users` (`id`) ON DELETE CASCADE;');

                }
            }
            // interest_id
            if (Schema::hasColumn('user_interests', 'interest_id')) {
                $interest_id_fk_key_exists = DB::select(
                    DB::raw(
                        'SHOW KEYS
        FROM user_interests
        WHERE Key_name="user_interests_interest_id_foreign"'
                    )
                );
                if (!$interest_id_fk_key_exists) {
                    DB::statement('ALTER TABLE `user_interests`
                      ADD KEY `user_interests_interest_id_foreign` (`interest_id`);');

                    DB::statement('ALTER TABLE `user_interests`
  ADD CONSTRAINT `user_interests_interest_id_foreign` FOREIGN KEY (`interest_id`)
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
        Schema::table('user_interests', function (Blueprint $table) {
            //
        });
    }
}
