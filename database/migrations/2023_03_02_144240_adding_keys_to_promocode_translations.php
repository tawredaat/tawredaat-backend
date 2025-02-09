<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddingKeysToPromocodeTranslations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('promocode_translations')) {
            // primary key
            $primary_key_exists = DB::select(
                DB::raw(
                    'SHOW KEYS
        FROM promocode_translations
        WHERE Key_name="PRIMARY"'
                )
            );
            if (!$primary_key_exists) {
                if (Schema::hasColumn('promocode_translations', 'id')) {
                    $add_pk_key_raw = 'ALTER TABLE `promocode_translations`
                        ADD PRIMARY KEY (`id`)';
                    DB::statement($add_pk_key_raw);

                    // auto increment
                    $auto_increment_raw = 'ALTER TABLE `promocode_translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;';
                    DB::statement($auto_increment_raw);

                }
            }

            // unique locale
            // search for the key
            $unique_key_exists = DB::select(
                DB::raw(
                    'SHOW KEYS FROM promocode_translations
        WHERE Key_name="promocode_translations_promocode_id_locale_unique"'
                )
            );

            // if the key does not exists add it
            if (!$unique_key_exists) {
                if (Schema::hasColumn('promocode_translations', 'locale')) {

                    $add_unique_key = 'ALTER TABLE `promocode_translations`ADD UNIQUE KEY `promocode_translations_promocode_id_locale_unique`
                     (`promocode_id`,`locale`),
  ADD KEY `promocode_translations_locale_index` (`locale`);';

                    DB::statement($add_unique_key);
                }
            }

            // FK
            // search for the key
            $unique_key_exists = DB::select(
                DB::raw(
                    'SHOW KEYS
        FROM promocode_translations
        WHERE Key_name="promocode_translations_promocode_id_foreign"'
                )
            );

            // if the key does not exists add it
            if (!$unique_key_exists) {
                if (Schema::hasColumn('promocode_translations', 'promocode_id')) {

                    $add_fk_key = 'ALTER TABLE `promocode_translations`
  ADD CONSTRAINT `promocode_translations_promocode_id_foreign` FOREIGN KEY
  (`promocode_id`) REFERENCES `promocodes` (`id`) ON DELETE CASCADE;';

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
        Schema::table('promocode_translations', function (Blueprint $table) {
            //
        });
    }
}