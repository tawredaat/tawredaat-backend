<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddingKeysToCategoryTranslationsDatabaseKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (Schema::hasTable('category_translations')) {
            // primary key
            $primary_key_exists = DB::select(
                DB::raw(
                    'SHOW KEYS
        FROM category_translations
        WHERE Key_name="PRIMARY"'
                )
            );
            if (!$primary_key_exists) {
                if (Schema::hasColumn('category_translations', 'id')) {
                    $add_keys_raw = 'ALTER TABLE `category_translations`
                        ADD PRIMARY KEY (`id`)';
                    DB::statement($add_keys_raw);

                    // auto increment
                    $auto_increment_raw = 'ALTER TABLE `category_translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=677;';
                    DB::statement($auto_increment_raw);

                }
            }

            // unique locale
            // search for the key
            $unique_key_exists = DB::select(
                DB::raw(
                    'SHOW KEYS FROM category_translations
        WHERE Key_name="category_translations_category_id_locale_unique"'
                )
            );

            // if the key does not exists add it
            if (!$unique_key_exists) {
                if (Schema::hasColumn('category_translations', 'locale')) {

                    $add_unique_key = 'ALTER TABLE `category_translations`ADD UNIQUE KEY `category_translations_category_id_locale_unique`
                     (`category_id`,`locale`),
  ADD KEY `category_translations_locale_index` (`locale`);';

                    DB::statement($add_unique_key);
                }
            }

            // FK
            // search for the key
            $unique_key_exists = DB::select(
                DB::raw(
                    'SHOW KEYS
        FROM category_translations
        WHERE Key_name="category_translations_category_id_foreign"'
                )
            );

            // if the key does not exists add it
            if (!$unique_key_exists) {
                if (Schema::hasColumn('category_translations', 'category_id')) {

                    $add_fk_key = 'ALTER TABLE `category_translations`
  ADD CONSTRAINT `category_translations_category_id_foreign` FOREIGN KEY
  (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;';

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
        Schema::table('category_translations_database_keys', function (Blueprint $table) {
            //
        });
    }
}
