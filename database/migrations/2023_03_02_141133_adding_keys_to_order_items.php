<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddingKeysToOrderItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (Schema::hasTable('order_items')) {
            // primary key
            if (Schema::hasColumn('order_items', 'id')) {
                $primary_key_exists = DB::select(
                    DB::raw(
                        'SHOW KEYS
        FROM order_items
        WHERE Key_name="PRIMARY"'
                    )
                );
                if (!$primary_key_exists) {
                    DB::statement('ALTER TABLE `order_items`
                        ADD PRIMARY KEY (`id`)');

                    // auto increment
                    DB::statement('ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=436;');
                }
            }

            // order_id
            if (Schema::hasColumn('order_items', 'order_id')) {
                $order_id_fk_key_exists = DB::select(
                    DB::raw(
                        'SHOW KEYS
        FROM order_items
        WHERE Key_name="order_items_order_id_foreign"'
                    )
                );
                if (!$order_id_fk_key_exists) {
                    DB::statement('ALTER TABLE `order_items`
                     ADD KEY `order_items_order_id_foreign` (`order_id`)');
                    DB::statement('ALTER TABLE `order_items`
 ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`)
 REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;'
                    );
                }
            }
// shop_product_id
            if (Schema::hasColumn('order_items', 'shop_product_id')) {
                $shop_product_id_fk_key_exists = DB::select(
                    DB::raw(
                        'SHOW KEYS
        FROM order_items
        WHERE Key_name="order_items_shop_product_id_foreign"'
                    )
                );
                if (!$shop_product_id_fk_key_exists) {
                    DB::statement('ALTER TABLE `order_items`
                     ADD KEY `order_items_shop_product_id_foreign` (`shop_product_id`)');
                    DB::statement('ALTER TABLE `order_items`
 ADD CONSTRAINT `order_items_shop_product_id_foreign` FOREIGN KEY
 (`shop_product_id`) REFERENCES `shop_products` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;'
                    );
                }
            }
// company_id
            if (Schema::hasColumn('order_items', 'company_id')) {
                $company_id_fk_key_exists = DB::select(
                    DB::raw(
                        'SHOW KEYS
        FROM order_items
        WHERE Key_name="order_items_company_id_foreign"'
                    )
                );
                if (!$company_id_fk_key_exists) {
                    DB::statement('ALTER TABLE `order_items`
                     ADD KEY `order_items_company_id_foreign` (`company_id`)');
                    DB::statement('ALTER TABLE `order_items`
 ADD CONSTRAINT `order_items_company_id_foreign` FOREIGN KEY (`company_id`)
 REFERENCES `companies` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;'
                    );
                }
            }
// offer_package_id
            if (Schema::hasColumn('order_items', 'offer_package_id')) {
                $offer_package_id_fk_key_exists = DB::select(
                    DB::raw(
                        'SHOW KEYS
        FROM order_items
        WHERE Key_name="order_items_offer_package_id_foreign"'
                    )
                );
                if (!$offer_package_id_fk_key_exists) {
                    DB::statement('ALTER TABLE `order_items`
                     ADD KEY `order_items_offer_package_id_foreign` (`offer_package_id`)');
                    DB::statement('ALTER TABLE `order_items`
   ADD CONSTRAINT `order_items_offer_package_id_foreign` FOREIGN KEY (`offer_package_id`) REFERENCES `offer_packages` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;'
                    );
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
        Schema::table('order_items', function (Blueprint $table) {
            //
        });
    }
}
