<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddingKeysToQuantityTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quantity_types', function (Blueprint $table) {

            if (Schema::hasTable('quantity_types')) {
                // primary key

                $primary_key_exists = DB::select(
                    DB::raw(
                        'SHOW KEYS
        FROM quantity_types
        WHERE Key_name="PRIMARY"'
                    )
                );

                if (!$primary_key_exists) {
                    if (Schema::hasColumn('quantity_types', 'id')) {

                        $add_keys_raw = 'ALTER TABLE `quantity_types`
                        ADD PRIMARY KEY (`id`)';

                        DB::statement($add_keys_raw);

                        // auto increment
                        $auto_increment_raw = 'ALTER TABLE `quantity_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;';
                        DB::statement($auto_increment_raw);

                    }
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quantity_types', function (Blueprint $table) {
            //
        });
    }
}
