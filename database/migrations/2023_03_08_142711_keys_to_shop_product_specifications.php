<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class KeysToShopProductSpecifications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('shop_product_specifications')) {
            // primary key
            if (Schema::hasColumn('shop_product_specifications', 'id')) {
                $primary_key_exists = DB::select(
                    DB::raw(
                        'SHOW KEYS
        FROM shop_product_specifications
        WHERE Key_name="PRIMARY"'
                    )
                );
                if (!$primary_key_exists) {
                    DB::statement('ALTER TABLE `shop_product_specifications`
  ADD PRIMARY KEY (`id`);');

                    // auto increment
                    DB::statement('ALTER TABLE `shop_product_specifications`
   MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24325;');
                }
            }

            // fks
            // shop_product_id
            if (Schema::hasColumn('shop_product_specifications', 'shop_product_id')) {
                $shop_product_id_fk_key_exists = DB::select(
                    DB::raw(
                        'SHOW KEYS
        FROM shop_product_specifications
        WHERE Key_name="shop_product_specifications_shop_product_id_index"'
                    )
                );
                if (!$shop_product_id_fk_key_exists) {
                    DB::statement('ALTER TABLE `shop_product_specifications`
                      ADD KEY `shop_product_specifications_shop_product_id_foreign` (`shop_product_id`);');

                    DB::statement('ALTER TABLE `shop_product_specifications`
 ADD CONSTRAINT `shop_product_specifications_shop_product_id_foreign` FOREIGN KEY (`shop_product_id`)
 REFERENCES `shop_products` (`id`) ON DELETE CASCADE');
                }
            }
// specification_id
            if (Schema::hasColumn('shop_product_specifications', 'specification_id')) {
                $specification_id_fk_key_exists = DB::select(
                    DB::raw(
                        'SHOW KEYS
        FROM shop_product_specifications
        WHERE Key_name="shop_product_specifications_specification_id_index"'
                    )
                );
                if (!$specification_id_fk_key_exists) {
                    DB::statement('ALTER TABLE `shop_product_specifications`
                      ADD KEY `shop_product_specifications_specification_id_foreign` (`specification_id`);');

                    DB::statement('ALTER TABLE `shop_product_specifications`
 ADD CONSTRAINT `shop_product_specifications_specification_id_foreign` FOREIGN KEY (`specification_id`)
 REFERENCES `specifications` (`id`) ON DELETE CASCADE');
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
        Schema::table('shop_product_specifications', function (Blueprint $table) {
            //
        });
    }
}
