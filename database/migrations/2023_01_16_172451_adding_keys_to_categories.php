<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddingKeysToCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // primary key
        if (Schema::hasTable('categories')) {
            $primary_key_exists = DB::select(
                DB::raw(
                    'SHOW KEYS
        FROM categories
        WHERE Key_name="PRIMARY"'
                )
            );

            if (!$primary_key_exists) {
                if (Schema::hasColumn('categories', 'id')) {
                    $add_keys_raw = 'ALTER TABLE `categories`
                        ADD PRIMARY KEY (`id`)';
                    DB::statement($add_keys_raw);

                    // auto increment
                    $auto_increment_raw = 'ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=339;';
                    DB::statement($auto_increment_raw);

                }
            }

            $parent_key_exists = DB::select(
                DB::raw(
                    'SHOW KEYS
        FROM categories
        WHERE Key_name="categories_parent_foreign"'
                )
            );

            if (!$parent_key_exists) {

                if (Schema::hasColumn('categories', 'parent')) {

                    $add_keys_raw = 'ALTER TABLE `categories`
  ADD CONSTRAINT `categories_parent_foreign` FOREIGN KEY (`parent`) REFERENCES `categories` (`id`);';

                    DB::statement($add_keys_raw);
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
        Schema::table('categories', function (Blueprint $table) {
            //
        });
    }
}
