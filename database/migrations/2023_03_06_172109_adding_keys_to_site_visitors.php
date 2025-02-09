<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddingKeysToSiteVisitors extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (Schema::hasTable('site_visitors')) {
            // primary key
            if (Schema::hasColumn('site_visitors', 'id')) {
                $primary_key_exists = DB::select(
                    DB::raw(
                        'SHOW KEYS
        FROM site_visitors
        WHERE Key_name="PRIMARY"'
                    )
                );
                if (!$primary_key_exists) {
                    DB::statement('ALTER TABLE `site_visitors`
  ADD PRIMARY KEY (`id`);');

                    // auto increment
                    DB::statement('ALTER TABLE `site_visitors`
 MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=835083;');

                }
            }

            // fks
            // user_id
            if (Schema::hasColumn('site_visitors', 'user_id')) {
                $user_id_fk_key_exists = DB::select(
                    DB::raw(
                        'SHOW KEYS
        FROM site_visitors
        WHERE Key_name="site_visitors_user_id_foreign_2"'
                    )
                );

                //dd($user_id_fk_key_exists);

                if (!$user_id_fk_key_exists) {
                    DB::statement('SET FOREIGN_KEY_CHECKS=0;');

                    DB::statement('ALTER TABLE `site_visitors`
                      ADD KEY `site_visitors_user_id_foreign_2` (`user_id`);');

                    DB::statement('ALTER TABLE `site_visitors`
  ADD CONSTRAINT `site_visitors_user_id_foreign_2` FOREIGN KEY (`user_id`)
  REFERENCES `users` (`id`) ON DELETE CASCADE;');

                    DB::statement('SET FOREIGN_KEY_CHECKS=1;');

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
        Schema::table('site_visitors', function (Blueprint $table) {
            //
        });
    }
}
