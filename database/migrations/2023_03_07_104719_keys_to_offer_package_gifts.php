<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class KeysToOfferPackageGifts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (Schema::hasTable('offer_package_gifts')) {
            // primary key
            if (Schema::hasColumn('offer_package_gifts', 'id')) {
                $primary_key_exists = DB::select(
                    DB::raw(
                        'SHOW KEYS
        FROM offer_package_gifts
        WHERE Key_name="PRIMARY"'
                    )
                );
                if (!$primary_key_exists) {
                    DB::statement('ALTER TABLE `offer_package_gifts`
  ADD PRIMARY KEY (`id`);');

                    // auto increment
                    DB::statement('ALTER TABLE `offer_package_gifts`
   MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;');

                }
            }
            // fks
            // offer_package_id
            if (Schema::hasColumn('offer_package_gifts', 'offer_package_id')) {
                $offer_package_id_fk_key_exists = DB::select(
                    DB::raw(
                        'SHOW KEYS
        FROM offer_package_gifts
        WHERE Key_name="offer_package_gifts_offer_package_id_foreign"'
                    )
                );
                if (!$offer_package_id_fk_key_exists) {
                    DB::statement('ALTER TABLE `offer_package_gifts`
                      ADD KEY `offer_package_gifts_offer_package_id_foreign` (`offer_package_id`);');

                    DB::statement('ALTER TABLE `offer_package_gifts`
  ADD CONSTRAINT `offer_package_gifts_offer_package_id_foreign` FOREIGN KEY
  (`offer_package_id`) REFERENCES `offer_packages` (`id`) ON DELETE CASCADE');
                }
            }
            // quantity_type_id
            if (Schema::hasColumn('offer_package_gifts', 'quantity_type_id')) {
                $quantity_type_id_fk_key_exists = DB::select(
                    DB::raw(
                        'SHOW KEYS
        FROM offer_package_gifts
        WHERE Key_name="offer_package_gifts_quantity_type_id_foreign"'
                    )
                );
                if (!$quantity_type_id_fk_key_exists) {
                    DB::statement('ALTER TABLE `offer_package_gifts`
                      ADD KEY `offer_package_gifts_quantity_type_id_foreign` (`quantity_type_id`);');

                    DB::statement('ALTER TABLE `offer_package_gifts`
 ADD CONSTRAINT `offer_package_gifts_quantity_type_id_foreign`
 FOREIGN KEY (`quantity_type_id`) REFERENCES `quantity_types` (`id`);');
                }
            }
            // shop_product_id
            if (Schema::hasColumn('offer_package_gifts', 'shop_product_id')) {
                $shop_product_id_fk_key_exists = DB::select(
                    DB::raw(
                        'SHOW KEYS
        FROM offer_package_gifts
        WHERE Key_name="offer_package_gifts_shop_product_id_foreign"'
                    )
                );
                if (!$shop_product_id_fk_key_exists) {
                    DB::statement('ALTER TABLE `offer_package_gifts`
                      ADD KEY `offer_package_gifts_shop_product_id_foreign` (`shop_product_id`);');

                    DB::statement('ALTER TABLE `offer_package_gifts`
 ADD CONSTRAINT `offer_package_gifts_shop_product_id_foreign` FOREIGN KEY (`shop_product_id`)
 REFERENCES `shop_products` (`id`) ON DELETE CASCADE;');
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
        Schema::table('offer_package_gifts', function (Blueprint $table) {
            //
        });
    }
}
