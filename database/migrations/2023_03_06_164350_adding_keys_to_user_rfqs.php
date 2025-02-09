<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddingKeysToUserRfqs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('user_rfqs')) {
            // primary key
            if (Schema::hasColumn('user_rfqs', 'id')) {
                $primary_key_exists = DB::select(
                    DB::raw(
                        'SHOW KEYS
        FROM user_rfqs
        WHERE Key_name="PRIMARY"'
                    )
                );
                if (!$primary_key_exists) {
                    DB::statement('ALTER TABLE `user_rfqs`
  ADD PRIMARY KEY (`id`);');

                    // auto increment
                    DB::statement('ALTER TABLE `user_rfqs`
 MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;');

                }
            }

            // fks
            // user_id
            if (Schema::hasColumn('user_rfqs', 'user_id')) {
                $user_id_fk_key_exists = DB::select(
                    DB::raw(
                        'SHOW KEYS
        FROM user_rfqs
        WHERE Key_name="user_rfqs_user_id_foreign"'
                    )
                );
                if (!$user_id_fk_key_exists) {
                    DB::statement('ALTER TABLE `user_rfqs`
                      ADD KEY `user_rfqs_user_id_foreign` (`user_id`);');

                    DB::statement('ALTER TABLE `user_rfqs`
   ADD CONSTRAINT `user_rfqs_user_id_foreign` FOREIGN KEY (`user_id`)
   REFERENCES `users` (`id`)');

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
        Schema::table('user_rfqs', function (Blueprint $table) {
            //
        });
    }
}
