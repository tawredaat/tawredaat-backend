<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddingKeysToOrderStatuses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('order_statuses')) {
            // primary key
            if (Schema::hasColumn('order_statuses', 'id')) {
                $primary_key_exists = DB::select(
                    DB::raw(
                        'SHOW KEYS
        FROM order_statuses
        WHERE Key_name="PRIMARY"'
                    )
                );
                if (!$primary_key_exists) {

                    $add_pk_key_raw = 'ALTER TABLE `order_statuses`
                        ADD PRIMARY KEY (`id`)';
                    DB::statement($add_pk_key_raw);

                    // auto increment
                    $auto_increment_raw = 'ALTER TABLE `order_statuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;;';
                    DB::statement($auto_increment_raw);

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
        Schema::table('order_statuses', function (Blueprint $table) {
            //
        });
    }
}
