<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class KeysToMoreInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (Schema::hasTable('more_infos')) {
            // primary key
            if (Schema::hasColumn('more_infos', 'id')) {
                $primary_key_exists = DB::select(
                    DB::raw(
                        'SHOW KEYS
        FROM more_infos
        WHERE Key_name="PRIMARY"'
                    )
                );
                if (!$primary_key_exists) {
                    DB::statement('ALTER TABLE `more_infos`
  ADD PRIMARY KEY (`id`);');

                    // auto increment
                    DB::statement('ALTER TABLE `more_infos`
   MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3742;');
                }
            }
            // company_id
            if (Schema::hasColumn('more_infos', 'company_id')) {
                $company_id_fk_key_exists = DB::select(
                    DB::raw(
                        'SHOW KEYS
        FROM more_infos
        WHERE Key_name="more_infos_company_id_foreign"'
                    )
                );
                if (!$company_id_fk_key_exists) {
                    DB::statement('ALTER TABLE `more_infos`
                      ADD KEY `more_infos_company_id_foreign` (`company_id`);');

                    DB::statement('ALTER TABLE `more_infos`
 ADD CONSTRAINT `more_infos_company_id_foreign` FOREIGN KEY (`company_id`)
 REFERENCES `companies` (`id`) ON DELETE CASCADE');
                }
            }
            // fks
            // user_id
            if (Schema::hasColumn('more_infos', 'user_id')) {
                $user_id_fk_key_exists = DB::select(
                    DB::raw(
                        'SHOW KEYS
        FROM more_infos
        WHERE Key_name="more_infos_user_id_foreign"'
                    )
                );
                if (!$user_id_fk_key_exists) {
                    DB::statement('ALTER TABLE `more_infos`
                      ADD KEY `more_infos_user_id_foreign` (`user_id`);');

                    DB::statement('ALTER TABLE `more_infos`
  ADD CONSTRAINT `more_infos_user_id_foreign` FOREIGN KEY (`user_id`)
  REFERENCES `users` (`id`) ON DELETE CASCADE');

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
        Schema::table('more_infos', function (Blueprint $table) {
            //
        });
    }
}
