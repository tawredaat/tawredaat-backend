<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class KeysToBrandCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (Schema::hasTable('brand_categories')) {
            // primary key
            if (Schema::hasColumn('brand_categories', 'id')) {
                $primary_key_exists = DB::select(
                    DB::raw(
                        'SHOW KEYS
        FROM brand_categories
        WHERE Key_name="PRIMARY"'
                    )
                );
                if (!$primary_key_exists) {
                    DB::statement('ALTER TABLE `brand_categories`
  ADD PRIMARY KEY (`id`);');

                    // auto increment
                    DB::statement('ALTER TABLE `brand_categories`
   MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2944;');
                }
            }

            // fks
            // brand_id
            if (Schema::hasColumn('brand_categories', 'brand_id')) {
                $brand_id_fk_key_exists = DB::select(
                    DB::raw(
                        'SHOW KEYS
        FROM brand_categories
        WHERE Key_name="brand_categories_brand_id_index"'
                    )
                );
                if (!$brand_id_fk_key_exists) {
                    DB::statement('ALTER TABLE `brand_categories`
                      ADD KEY `brand_categories_brand_id_foreign` (`brand_id`);');

                    DB::statement('ALTER TABLE `brand_categories`
 ADD CONSTRAINT `brand_categories_brand_id_foreign` FOREIGN KEY (`brand_id`)
 REFERENCES `brands` (`id`) ON DELETE CASCADE');
                }
            }
// category_id
            if (Schema::hasColumn('brand_categories', 'category_id')) {
                $category_id_fk_key_exists = DB::select(
                    DB::raw(
                        'SHOW KEYS
        FROM brand_categories
        WHERE Key_name="brand_categories_category_id_index"'
                    )
                );
                if (!$category_id_fk_key_exists) {
                    DB::statement('ALTER TABLE `brand_categories`
                      ADD KEY `brand_categories_category_id_foreign` (`category_id`);');

                    DB::statement('ALTER TABLE `brand_categories`
 ADD CONSTRAINT `brand_categories_category_id_foreign` FOREIGN KEY (`category_id`)
 REFERENCES `categories` (`id`) ON DELETE CASCADE');
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
        Schema::table('brand_categories', function (Blueprint $table) {
            //
        });
    }
}
