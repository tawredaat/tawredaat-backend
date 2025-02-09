<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddingKeysToOfferPackages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('offer_packages')) {
            // primary key
            if (Schema::hasColumn('offer_packages', 'id')) {
                $primary_key_exists = DB::select(
                    DB::raw(
                        'SHOW KEYS
        FROM offer_packages
        WHERE Key_name="PRIMARY"'
                    )
                );
                if (!$primary_key_exists) {
                    DB::statement('ALTER TABLE `offer_packages`
                        ADD PRIMARY KEY (`id`)');

                    // auto increment
                    DB::statement('ALTER TABLE `offer_packages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;');
                }
            }

            // fks
            // shop_product_id
            if (Schema::hasColumn('offer_packages', 'shop_product_id')) {
                $shop_product_id_fk_key_exists = DB::select(
                    DB::raw(
                        'SHOW KEYS
        FROM offer_packages
        WHERE Key_name="offer_packages_shop_product_id_foreign"'
                    )
                );
                if (!$shop_product_id_fk_key_exists) {
                    DB::statement('ALTER TABLE `offer_packages`
                     ADD KEY `offer_packages_shop_product_id_foreign` (`shop_product_id`)');

                    DB::statement('ALTER TABLE `offer_packages`
  ADD CONSTRAINT `offer_packages_shop_product_id_foreign` FOREIGN KEY
   (`shop_product_id`) REFERENCES `shop_products` (`id`) ON DELETE CASCADE;'
                    );
                }
            }

            // quantity_type_id
            if (Schema::hasColumn('offer_packages', 'quantity_type_id')) {
                $quantity_type_id_fk_key_exists = DB::select(
                    DB::raw(
                        'SHOW KEYS
        FROM offer_packages
        WHERE Key_name="offer_packages_quantity_type_id_foreign"'
                    )
                );
                if (!$quantity_type_id_fk_key_exists) {
                    DB::statement('ALTER TABLE `offer_packages`
                     ADD KEY `offer_packages_quantity_type_id_foreign` (`quantity_type_id`)');
                    DB::statement('ALTER TABLE `offer_packages`
   ADD CONSTRAINT `offer_packages_quantity_type_id_foreign`
    FOREIGN KEY (`quantity_type_id`) REFERENCES `quantity_types` (`id`);'
                    );
                }
            }

        } // end of if offer_packages exists

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('offer_packages', function (Blueprint $table) {
            //
        });
    }
}
