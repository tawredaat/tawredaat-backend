<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class KeysToCartItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('cart_items')) {
            // primary key
            if (Schema::hasColumn('cart_items', 'id')) {
                $primary_key_exists = DB::select(
                    DB::raw(
                        'SHOW KEYS
        FROM cart_items
        WHERE Key_name="PRIMARY"'
                    )
                );
                if (!$primary_key_exists) {
                    DB::statement('ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`);');

                    // auto increment
                    DB::statement('ALTER TABLE `cart_items`
   MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2578;');
                }
            }
// fks
            // cart_id
            if (Schema::hasColumn('cart_items', 'cart_id')) {
                $cart_id_fk_key_exists = DB::select(
                    DB::raw(
                        'SHOW KEYS
        FROM cart_items
        WHERE Key_name="cart_items_cart_id_foreign"'
                    )
                );
                if (!$cart_id_fk_key_exists) {
                    DB::statement('ALTER TABLE `cart_items`
                      ADD KEY `cart_items_cart_id_foreign` (`cart_id`);');

                    DB::statement('ALTER TABLE `cart_items`
 ADD CONSTRAINT `cart_items_cart_id_foreign` FOREIGN KEY (`cart_id`)
 REFERENCES `carts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;');
                }
            }
// shop_product_id
            if (Schema::hasColumn('cart_items', 'shop_product_id')) {
                $shop_product_id_fk_key_exists = DB::select(
                    DB::raw(
                        'SHOW KEYS
        FROM cart_items
        WHERE Key_name="cart_items_shop_product_id_foreign"'
                    )
                );
                if (!$shop_product_id_fk_key_exists) {
                    DB::statement('ALTER TABLE `cart_items`
                      ADD KEY `cart_items_shop_product_id_foreign` (`shop_product_id`);');

                    DB::statement('ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_shop_product_id_foreign` FOREIGN KEY (`shop_product_id`)
  REFERENCES `shop_products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;');
                }
            }
// offer_package_id
            if (Schema::hasColumn('cart_items', 'offer_package_id')) {
                $offer_package_id_fk_key_exists = DB::select(
                    DB::raw(
                        'SHOW KEYS
        FROM cart_items
        WHERE Key_name="cart_items_offer_package_id_foreign"'
                    )
                );
                if (!$offer_package_id_fk_key_exists) {
                    DB::statement('ALTER TABLE `cart_items`
                      ADD KEY `cart_items_offer_package_id_foreign` (`offer_package_id`);');

                    DB::statement('ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_offer_package_id_foreign` FOREIGN KEY (`offer_package_id`)
   REFERENCES `offer_packages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;');
                }
            }
// company_id
            if (Schema::hasColumn('cart_items', 'company_id')) {
                $company_id_fk_key_exists = DB::select(
                    DB::raw(
                        'SHOW KEYS
        FROM cart_items
        WHERE Key_name="cart_items_company_id_foreign"'
                    )
                );
                if (!$company_id_fk_key_exists) {
                    DB::statement('ALTER TABLE `cart_items`
                      ADD KEY `cart_items_company_id_foreign` (`company_id`);');

                    DB::statement('ALTER TABLE `cart_items`
 ADD CONSTRAINT `cart_items_company_id_foreign` FOREIGN KEY (`company_id`)
  REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;');
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
        Schema::table('cart_items', function (Blueprint $table) {
            //
        });
    }
}
