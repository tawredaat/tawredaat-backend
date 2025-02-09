<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddingKeysToBrands extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (Schema::hasTable('brands')) {
            // primary key
            $primary_key_exists = DB::select(
                DB::raw(
                    'SHOW KEYS
        FROM brands
        WHERE Key_name="PRIMARY"'
                )
            );

            if (!$primary_key_exists) {
                if (Schema::hasColumn('brands', 'id')) {

                    $add_keys_raw = 'ALTER TABLE `brands`
                        ADD PRIMARY KEY (`id`)';
                    DB::statement($add_keys_raw);

                    // auto increment
                    $auto_increment_raw = 'ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=450;';
                    DB::statement($auto_increment_raw);

                }
            }

            // FK
            $brands_country_id_foreign_key_exists = DB::select(
                DB::raw(
                    'SHOW KEYS
        FROM brands
        WHERE Key_name="brands_country_id_foreign"'
                )
            );

            if (!$brands_country_id_foreign_key_exists) {

                if (Schema::hasColumn('brands', 'country_id')) {

                    $add_fk_key_raw = 'ALTER TABLE `brands`
  ADD CONSTRAINT `brands_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`);';

                    DB::statement($add_fk_key_raw);
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
        Schema::table('brands', function (Blueprint $table) {
            //
        });
    }
}
