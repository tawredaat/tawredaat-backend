<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddConstraintsToQuantityTypesTranslations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('quantity_type_translations')) {
            // primary key
            $primary_key_exists = DB::select(
                DB::raw(
                    'SHOW KEYS
        FROM quantity_type_translations
        WHERE Key_name="PRIMARY"'
                )
            );
            if (!$primary_key_exists) {
                if (Schema::hasColumn('quantity_type_translations', 'id')) {
                    $add_keys_raw = 'ALTER TABLE `quantity_type_translations`
                        ADD PRIMARY KEY (`id`)';
                    DB::statement($add_keys_raw);
                }

                // auto increment
                $auto_increment_raw = 'ALTER TABLE `quantity_type_translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;';
                DB::statement($auto_increment_raw);
            }

            // unique locale
            // search for the key
            $unique_key_exists = DB::select(
                DB::raw(
                    'SHOW KEYS FROM quantity_type_translations
        WHERE Key_name="quantity_type_translations_quantity_type_id_locale_unique"'
                )
            );

            // if the key does not exists add it
            if (!$unique_key_exists) {
                if (Schema::hasColumn('quantity_type_translations', 'locale')) {

                    $add_unique_key = 'ALTER TABLE `quantity_type_translations`ADD UNIQUE KEY `quantity_type_translations_quantity_type_id_locale_unique`
                     (`quantity_type_id`,`locale`),
  ADD KEY `quantity_type_translations_locale_index` (`locale`);';

                    DB::statement($add_unique_key);
                }
            }

            // FK
            // search for the key
            $unique_key_exists = DB::select(
                DB::raw(
                    'SHOW KEYS
        FROM quantity_type_translations
        WHERE Key_name="quantity_type_translations_quantity_type_id_foreign"'
                )
            );

            // if the key does not exists add it
            if (!$unique_key_exists) {
                if (Schema::hasColumn('quantity_type_translations', 'quantity_type_id')) {

                    $add_fk_key = 'ALTER TABLE `quantity_type_translations`
  ADD CONSTRAINT `quantity_type_translations_quantity_type_id_foreign` FOREIGN KEY
  (`quantity_type_id`) REFERENCES `quantity_types` (`id`) ON DELETE CASCADE;';

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
        Schema::table('quantity_types_translations', function (Blueprint $table) {
            //
        });
    }
}