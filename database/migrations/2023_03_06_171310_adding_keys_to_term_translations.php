<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddingKeysToTermTranslations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (Schema::hasTable('term_translations')) {
            // primary key
            $primary_key_exists = DB::select(
                DB::raw(
                    'SHOW KEYS
        FROM term_translations
        WHERE Key_name="PRIMARY"'
                )
            );
            if (!$primary_key_exists) {
                if (Schema::hasColumn('term_translations', 'id')) {
                    $add_pk_key_raw = 'ALTER TABLE `term_translations`
                        ADD PRIMARY KEY (`id`)';
                    DB::statement($add_pk_key_raw);

                    // auto increment
                    $auto_increment_raw = 'ALTER TABLE `term_translations`
 MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;';
                    DB::statement($auto_increment_raw);

                }
            }

            // unique locale
            // search for the key
            $unique_key_exists = DB::select(
                DB::raw(
                    'SHOW KEYS FROM term_translations
        WHERE Key_name="term_translations_term_id_locale_unique"'
                )
            );

            // if the key does not exists add it
            if (!$unique_key_exists) {
                if (Schema::hasColumn('term_translations', 'locale')) {

                    $add_unique_key = 'ALTER TABLE `term_translations`ADD UNIQUE KEY `term_translations_term_id_locale_unique`
                     (`term_id`,`locale`),
  ADD KEY `term_translations_locale_index` (`locale`);';

                    DB::statement($add_unique_key);
                }
            }

            // FK
            // search for the key
            $unique_key_exists = DB::select(
                DB::raw(
                    'SHOW KEYS
        FROM term_translations
        WHERE Key_name="term_translations_term_id_foreign"'
                )
            );

            // if the key does not exists add it
            if (!$unique_key_exists) {
                if (Schema::hasColumn('term_translations', 'term_id')) {

                    $add_fk_key = 'ALTER TABLE `term_translations`
  ADD CONSTRAINT `term_translations_term_id_foreign` FOREIGN KEY
  (`term_id`) REFERENCES `terms` (`id`) ON DELETE CASCADE;';

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
        Schema::table('term_translations', function (Blueprint $table) {
            //
        });
    }
}