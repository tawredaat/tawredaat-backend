<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddingKeysToBrandTranslationsDatabaseKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('brand_translations')) {
            // primary key
            $primary_key_exists = DB::select(
                DB::raw(
                    'SHOW KEYS
        FROM brand_translations
        WHERE Key_name="PRIMARY"'
                )
            );
            if (!$primary_key_exists) {
                if (Schema::hasColumn('brand_translations', 'id')) {
                    $add_keys_raw = 'ALTER TABLE `brand_translations`
                        ADD PRIMARY KEY (`id`)';
                    DB::statement($add_keys_raw);

                    // auto increment
                    $auto_increment_raw = 'ALTER TABLE `brand_translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=899;';
                    DB::statement($auto_increment_raw);

                }
            }

            // unique locale
            // search for the key
            $unique_key_exists = DB::select(
                DB::raw(
                    'SHOW KEYS FROM brand_translations
        WHERE Key_name="brand_translations_brand_id_locale_unique"'
                )
            );

            // if the key does not exists add it
            if (!$unique_key_exists) {
                if (Schema::hasColumn('brand_translations', 'locale')) {

                    $add_unique_key = 'ALTER TABLE `brand_translations`ADD UNIQUE KEY `brand_translations_brand_id_locale_unique`
                     (`brand_id`,`locale`),
  ADD KEY `brand_translations_locale_index` (`locale`);';

                    DB::statement($add_unique_key);
                }
            }

            // FK
            // search for the key
            $unique_key_exists = DB::select(
                DB::raw(
                    'SHOW KEYS
        FROM brand_translations
        WHERE Key_name="brand_translations_brand_id_foreign"'
                )
            );

            // if the key does not exists add it
            if (!$unique_key_exists) {
                if (Schema::hasColumn('brand_translations', 'brand_id')) {

                    $add_fk_key = 'ALTER TABLE `brand_translations`
  ADD CONSTRAINT `brand_translations_brand_id_foreign` FOREIGN KEY
  (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE;';

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
        Schema::table('brand_translations_database_keys', function (Blueprint $table) {
            //
        });
    }
}
