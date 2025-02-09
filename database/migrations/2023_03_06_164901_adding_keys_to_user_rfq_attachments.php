<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddingKeysToUserRfqAttachments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (Schema::hasTable('user_rfq_attachments')) {
            // primary key
            if (Schema::hasColumn('user_rfq_attachments', 'id')) {
                $primary_key_exists = DB::select(
                    DB::raw(
                        'SHOW KEYS
        FROM user_rfq_attachments
        WHERE Key_name="PRIMARY"'
                    )
                );
                if (!$primary_key_exists) {
                    DB::statement('ALTER TABLE `user_rfq_attachments`
  ADD PRIMARY KEY (`id`);');

                    // auto increment
                    DB::statement('ALTER TABLE `user_rfq_attachments`
 MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;');

                }
            }
// fks
            // user_rfq_id
            if (Schema::hasColumn('user_rfq_attachments', 'user_rfq_id')) {
                $user_rfq_id_fk_key_exists = DB::select(
                    DB::raw(
                        'SHOW KEYS
        FROM user_rfq_attachments
        WHERE Key_name="user_rfq_attachments_user_rfq_id_foreign"'
                    )
                );
                if (!$user_rfq_id_fk_key_exists) {
                    DB::statement('ALTER TABLE `user_rfq_attachments`
                      ADD KEY `user_rfq_attachments_user_rfq_id_foreign` (`user_rfq_id`);');

                    DB::statement('ALTER TABLE `user_rfq_attachments`
   ADD CONSTRAINT `user_rfq_attachments_user_rfq_id_foreign`
   FOREIGN KEY (`user_rfq_id`) REFERENCES `user_rfqs` (`id`);');

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
        Schema::table('user_rfq_attachments', function (Blueprint $table) {
            //
        });
    }
}
