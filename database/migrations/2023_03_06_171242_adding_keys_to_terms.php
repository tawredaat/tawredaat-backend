<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddingKeysToTerms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (Schema::hasTable('terms')) {
            // primary key
            if (Schema::hasColumn('terms', 'id')) {
                $primary_key_exists = DB::select(
                    DB::raw(
                        'SHOW KEYS
        FROM terms
        WHERE Key_name="PRIMARY"'
                    )
                );
                if (!$primary_key_exists) {
                    DB::statement('ALTER TABLE `terms`
  ADD PRIMARY KEY (`id`);');

                    // auto increment
                    DB::statement('ALTER TABLE `terms`
 MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;');

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
        Schema::table('terms', function (Blueprint $table) {
            //
        });
    }
}
