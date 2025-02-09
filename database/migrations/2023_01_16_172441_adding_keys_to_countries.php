<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddingKeysToCountries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // primary key
        if (Schema::hasTable('countries')) {
            $primary_key_exists = DB::select(
                DB::raw(
                    'SHOW KEYS
        FROM countries
        WHERE Key_name="PRIMARY"'
                )
            );

            if (!$primary_key_exists) {
                if (Schema::hasColumn('countries', 'id')) {
                    $add_keys_raw = 'ALTER TABLE `countries` ADD PRIMARY KEY (`id`)';
                    DB::statement($add_keys_raw);

                    // auto increment
                    $auto_increment_raw = 'ALTER TABLE `countries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;';
                    DB::statement($auto_increment_raw);

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
        Schema::table('countries', function (Blueprint $table) {
            //
        });
    }
}
