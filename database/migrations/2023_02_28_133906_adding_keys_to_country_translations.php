<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddingKeysToCountryTranslations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (Schema::hasTable('country_translations')) {
            // primary key
            $primary_key_exists = DB::select(
                DB::raw(
                    'SHOW KEYS
        FROM country_translations
        WHERE Key_name="PRIMARY"'
                )
            );
            if (!$primary_key_exists) {
                if (Schema::hasColumn('country_translations', 'id')) {
                    $add_keys_raw = 'ALTER TABLE `country_translations`
                        ADD PRIMARY KEY (`id`)';
                    DB::statement($add_keys_raw);
                    // auto increment
                    $auto_increment_raw = 'ALTER TABLE `country_translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;';
                    DB::statement($auto_increment_raw);

                }
            }

            // unique locale
            // search for the key
            $unique_key_exists = DB::select(
                DB::raw(
                    'SHOW KEYS FROM country_translations
        WHERE Key_name="country_translations_country_id_locale_unique"'
                )
            );

            // if the key does not exists add it
            if (!$unique_key_exists) {
                if (Schema::hasColumn('country_translations', 'locale')) {

                    $add_unique_key = 'ALTER TABLE `country_translations`ADD UNIQUE KEY `country_translations_country_id_locale_unique`
                     (`country_id`,`locale`),
  ADD KEY `country_translations_locale_index` (`locale`);';

                    DB::statement($add_unique_key);
                }
            }

            // FK
            // search for the key
            $unique_key_exists = DB::select(
                DB::raw(
                    'SHOW KEYS
        FROM country_translations
        WHERE Key_name="country_translations_country_id_foreign"'
                )
            );

            // if the key does not exists add it
            if (!$unique_key_exists) {
                if (Schema::hasColumn('country_translations', 'country_id')) {

                    $add_fk_key = 'ALTER TABLE `country_translations`
  ADD CONSTRAINT `country_translations_country_id_foreign` FOREIGN KEY
  (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE;';

                    DB::statement($add_fk_key);

                    // auto increment
                    $auto_increment_raw = 'ALTER TABLE `country_translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;';
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
        Schema::table('countary_translations', function (Blueprint $table) {
            //
        });
    }
}
