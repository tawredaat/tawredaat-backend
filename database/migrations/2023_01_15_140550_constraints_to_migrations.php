<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ConstraintsToMigrations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('migrations')) {
            $primary_key_exists = DB::select(
                DB::raw(
                    'SHOW KEYS
        FROM migrations
        WHERE Key_name="PRIMARY"'
                )
            );

            //dd($primary_key_exists);
            if (!$primary_key_exists) {
                if (Schema::hasColumn('migrations', 'id')) {
                    $add_keys_raw = 'ALTER TABLE `migrations`
                        ADD PRIMARY KEY (`id`)';
                    DB::statement($add_keys_raw);

                    // auto increment
                    $auto_increment_raw = 'ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=160;';
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
        Schema::table('migrations', function (Blueprint $table) {
            //
        });
    }
}
