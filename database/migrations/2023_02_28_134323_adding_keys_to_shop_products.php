<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddingKeysToShopProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (Schema::hasTable('shop_products')) {
            // primary key
            $primary_key_exists = DB::select(
                DB::raw(
                    'SHOW KEYS
        FROM shop_products
        WHERE Key_name="PRIMARY"'
                )
            );

            if (!$primary_key_exists) {
                if (Schema::hasColumn('shop_products', 'id')) {

                    $add_keys_raw = 'ALTER TABLE `shop_products`
                        ADD PRIMARY KEY (`id`)';

                    DB::statement($add_keys_raw);

                    // auto increment
                    $auto_increment_raw = 'ALTER TABLE `shop_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6036;';
                    DB::statement($auto_increment_raw);

                }
            }

            // category id FK

            $category_id_fk_key_exists = DB::select(
                DB::raw(
                    'SHOW KEYS
        FROM shop_products
        WHERE Key_name="shop_products_category_id_foreign"'
                )
            );

            if (!$category_id_fk_key_exists) {
                if (Schema::hasColumn('shop_products', 'category_id')) {

                    $add_category_id_fk_key_raw = 'ALTER TABLE `shop_products`
  ADD CONSTRAINT `shop_products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`)';

                    DB::statement($add_category_id_fk_key_raw);
                }
            }

            // brand id FK

            $brand_id_fk_key_exists = DB::select(
                DB::raw(
                    'SHOW KEYS
        FROM shop_products
        WHERE Key_name="shop_products_brand_id_foreign"'
                )
            );

            if (!$brand_id_fk_key_exists) {
                if (Schema::hasColumn('shop_products', 'brand_id')) {

                    $add_brand_id_fk_key_raw = 'ALTER TABLE `shop_products`
  ADD CONSTRAINT `shop_products_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`)';

                    DB::statement($add_brand_id_fk_key_raw);
                }
            }

            // quantity type id FK

            $quantity_type_id_fk_key_exists = DB::select(
                DB::raw(
                    'SHOW KEYS
        FROM shop_products
        WHERE Key_name="shop_products_quantity_type_id_foreign"'
                )
            );

            if (!$quantity_type_id_fk_key_exists) {
                if (Schema::hasColumn('shop_products', 'quantity_type_id')) {

                    $add_quantity_type_id_fk_key_raw = 'ALTER TABLE `shop_products`
  ADD CONSTRAINT `shop_products_quantity_type_id_foreign` FOREIGN KEY (`quantity_type_id`) REFERENCES `quantity_types` (`id`)';

                    DB::statement($add_quantity_type_id_fk_key_raw);
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
        Schema::table('shop_products', function (Blueprint $table) {
            //
        });
    }
}
