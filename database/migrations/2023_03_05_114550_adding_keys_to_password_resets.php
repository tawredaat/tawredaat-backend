<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddingKeysToPasswordResets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('password_resets')) {
            // email
            if (Schema::hasColumn('password_resets', 'email')) {
                $email_fk_key_exists = DB::select(
                    DB::raw(
                        'SHOW KEYS
        FROM password_resets
        WHERE Key_name="password_resets_email_index"'
                    )
                );
                if (!$email_fk_key_exists) {
                    DB::statement('ALTER TABLE `password_resets`
                      ADD KEY `password_resets_email_index` (`email`);');

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
        Schema::table('password_resets', function (Blueprint $table) {
            //
        });
    }
}
