<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddingKeysToOrderStatusTranslations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('order_status_translations')) {
            // primary key
            $primary_key_exists = DB::select(
                DB::raw(
                    'SHOW KEYS
        FROM order_status_translations
        WHERE Key_name="PRIMARY"'
                )
            );
            if (!$primary_key_exists) {
                if (Schema::hasColumn('order_status_translations', 'id')) {
                    $add_pk_key_raw = 'ALTER TABLE `order_status_translations`
                        ADD PRIMARY KEY (`id`)';
                    DB::statement($add_pk_key_raw);

                    // auto increment
                    $auto_increment_raw = 'ALTER TABLE `order_status_translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;';
                    DB::statement($auto_increment_raw);

                }
            }

            // unique locale
            // search for the key
            $unique_key_exists = DB::select(
                DB::raw(
                    'SHOW KEYS FROM order_status_translations
        WHERE Key_name="order_status_translations_order_status_id_locale_unique"'
                )
            );

            // if the key does not exists add it
            if (!$unique_key_exists) {
                if (Schema::hasColumn('order_status_translations', 'locale')) {

                    $add_unique_key = 'ALTER TABLE `order_status_translations`ADD UNIQUE KEY `order_status_translations_order_status_id_locale_unique`
                     (`order_status_id`,`locale`),
  ADD KEY `order_status_translations_locale_index` (`locale`);';

                    DB::statement($add_unique_key);
                }
            }

            // FK
            // search for the key
            $unique_key_exists = DB::select(
                DB::raw(
                    'SHOW KEYS
        FROM order_status_translations
        WHERE Key_name="order_status_translations_order_status_id_foreign"'
                )
            );

            // if the key does not exists add it
            if (!$unique_key_exists) {
                if (Schema::hasColumn('order_status_translations', 'order_status_id')) {

                    $add_fk_key = 'ALTER TABLE `order_status_translations`
  ADD CONSTRAINT `order_status_translations_order_status_id_foreign` FOREIGN KEY
  (`order_status_id`) REFERENCES `order_statuses` (`id`) ON DELETE CASCADE;';

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
        Schema::table('order_status_translations', function (Blueprint $table) {
            //
        });
    }
}
