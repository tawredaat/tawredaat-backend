<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddingKeysToCityTranslationsDatabaseKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('city_translations')) {
            // primary key
            $primary_key_exists = DB::select(
                DB::raw(
                    'SHOW KEYS
        FROM city_translations
        WHERE Key_name="PRIMARY"'
                )
            );
            if (!$primary_key_exists) {
                if (Schema::hasColumn('city_translations', 'id')) {
                    $add_keys_raw = 'ALTER TABLE `city_translations`
                        ADD PRIMARY KEY (`id`)';
                    DB::statement($add_keys_raw);

                    // auto increment
                    $auto_increment_raw = 'ALTER TABLE `city_translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;';
                    DB::statement($auto_increment_raw);
                }
            }

            // unique locale
            // search for the key
            $unique_key_exists = DB::select(
                DB::raw(
                    'SHOW KEYS FROM city_translations
        WHERE Key_name="city_translations_city_id_locale_unique"'
                )
            );

            // if the key does not exists add it
            if (!$unique_key_exists) {
                if (Schema::hasColumn('city_translations', 'locale')) {

                    $add_unique_key = 'ALTER TABLE `city_translations`ADD UNIQUE KEY `city_translations_city_id_locale_unique`
                     (`city_id`,`locale`),
  ADD KEY `city_translations_locale_index` (`locale`);';

                    DB::statement($add_unique_key);
                }
            }

            // FK
            // search for the key
            $unique_key_exists = DB::select(
                DB::raw(
                    'SHOW KEYS
        FROM city_translations
        WHERE Key_name="city_translations_city_id_foreign"'
                )
            );

            // if the key does not exists add it
            if (!$unique_key_exists) {
                if (Schema::hasColumn('city_translations', 'city_id')) {

                    $add_fk_key = 'ALTER TABLE `city_translations`
  ADD CONSTRAINT `city_translations_city_id_foreign` FOREIGN KEY
  (`city_id`) REFERENCES `cities` (`id`) ON DELETE CASCADE;';

                    DB::statement($add_fk_key);
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
        Schema::table('city_translations_database_keys', function (Blueprint $table) {
            //
        });
    }
}