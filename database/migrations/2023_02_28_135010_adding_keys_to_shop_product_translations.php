<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddingKeysToShopProductTranslations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (Schema::hasTable('shop_product_translations')) {
            // primary key
            $primary_key_exists = DB::select(
                DB::raw(
                    'SHOW KEYS
        FROM shop_product_translations
        WHERE Key_name="PRIMARY"'
                )
            );
            if (!$primary_key_exists) {
                if (Schema::hasColumn('shop_product_translations', 'id')) {
                    $add_keys_raw = 'ALTER TABLE `shop_product_translations`
                        ADD PRIMARY KEY (`id`)';
                    DB::statement($add_keys_raw);
                    // auto increment
                    $auto_increment_raw = 'ALTER TABLE `shop_product_translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12071;';
                    DB::statement($auto_increment_raw);

                }
            }

            // unique locale
            // search for the key
            $unique_key_exists = DB::select(
                DB::raw(
                    'SHOW KEYS FROM shop_product_translations
        WHERE Key_name="shop_product_translations_shop_product_id_locale_unique"'
                )
            );

            // if the key does not exists add it
            if (!$unique_key_exists) {
                if (Schema::hasColumn('shop_product_translations', 'locale')) {

                    $add_unique_key = 'ALTER TABLE `shop_product_translations`ADD UNIQUE KEY `shop_product_translations_shop_product_id_locale_unique`
                     (`shop_product_id`,`locale`),
  ADD KEY `shop_product_translations_locale_index` (`locale`);';

                    DB::statement($add_unique_key);
                }
            }

            // FK
            // search for the key
            $unique_key_exists = DB::select(
                DB::raw(
                    'SHOW KEYS
        FROM shop_product_translations
        WHERE Key_name="shop_product_translations_shop_product_id_foreign"'
                )
            );

            // if the key does not exists add it
            if (!$unique_key_exists) {
                if (Schema::hasColumn('shop_product_translations', 'shop_product_id')) {

                    $add_fk_key = 'ALTER TABLE `shop_product_translations`
  ADD CONSTRAINT `shop_product_translations_shop_product_id_foreign` FOREIGN KEY
  (`shop_product_id`) REFERENCES `shop_products` (`id`) ON DELETE CASCADE;';

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
        Schema::table('shop_product_translations', function (Blueprint $table) {
            //
        });
    }
}
