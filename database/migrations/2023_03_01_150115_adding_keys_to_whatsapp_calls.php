<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddingKeysToWhatsappCalls extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (Schema::hasTable('whatsapp_calls')) {
            // primary key
            $primary_key_exists = DB::select(
                DB::raw(
                    'SHOW KEYS
        FROM whatsapp_calls
        WHERE Key_name="PRIMARY"'
                )
            );
            if (!$primary_key_exists) {
                if (Schema::hasColumn('whatsapp_calls', 'id')) {
                    $add_keys_raw = 'ALTER TABLE `whatsapp_calls`
                        ADD PRIMARY KEY (`id`)';
                    DB::statement($add_keys_raw);
                }
            }

            // auto increment
            $auto_increment_raw = 'ALTER TABLE `whatsapp_calls`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1085;';
            DB::statement($auto_increment_raw);

            // fk company_id
            $whatsapp_calls_company_id_foreign_key_exists = DB::select(
                DB::raw(
                    'SHOW KEYS
        FROM whatsapp_calls
        WHERE Key_name="whatsapp_calls_company_id_foreign"'
                )
            );
            if (!$whatsapp_calls_company_id_foreign_key_exists) {
                if (Schema::hasColumn('whatsapp_calls', 'company_id')) {
                    $add_company_id_fk_key_raw = 'ALTER TABLE `whatsapp_calls`
  ADD CONSTRAINT `whatsapp_calls_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE';
                    DB::statement($add_company_id_fk_key_raw);
                }
            }

            // user id fk
            $whatsapp_calls_user_id_foreign_key_exists = DB::select(
                DB::raw(
                    'SHOW KEYS
        FROM whatsapp_calls
        WHERE Key_name="whatsapp_calls_user_id_foreign"'
                )
            );
            if (!$whatsapp_calls_user_id_foreign_key_exists) {
                if (Schema::hasColumn('whatsapp_calls', 'user_id')) {
                    $add_user_id_fk_key_raw = 'ALTER TABLE `whatsapp_calls`
  ADD CONSTRAINT `whatsapp_calls_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;';
                    DB::statement($add_user_id_fk_key_raw);
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
        Schema::table('whatsapp_calls', function (Blueprint $table) {
            //
        });
    }
}
