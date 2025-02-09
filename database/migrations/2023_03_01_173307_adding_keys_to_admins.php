<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddingKeysToAdmins extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (Schema::hasTable('admins')) {
            // primary key
            if (Schema::hasColumn('admins', 'id')) {
                $primary_key_exists = DB::select(
                    DB::raw(
                        'SHOW KEYS
        FROM admins
        WHERE Key_name="PRIMARY"'
                    )
                );
                if (!$primary_key_exists) {

                    $add_pk_key_raw = 'ALTER TABLE `admins`
                        ADD PRIMARY KEY (`id`)';
                    DB::statement($add_pk_key_raw);

                    // auto increment
                    $auto_increment_raw = 'ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;';
                    DB::statement($auto_increment_raw);
                }
            }

            // unique email
            if (Schema::hasColumn('admins', 'email')) {
                $unique_key_exists = DB::select(
                    DB::raw(
                        'SHOW KEYS
        FROM admins
        WHERE Key_name="admins_email_unique"'
                    )
                );
                if (!$unique_key_exists) {

                    $add_unique_key_raw = 'ALTER TABLE `admins`
                         ADD UNIQUE KEY `admins_email_unique` (`email`)';
                    DB::statement($add_unique_key_raw);
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
        Schema::table('admins', function (Blueprint $table) {
            //
        });
    }
}