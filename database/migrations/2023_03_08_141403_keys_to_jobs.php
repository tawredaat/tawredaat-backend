<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class KeysToJobs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('jobs')) {
            // primary key
            if (Schema::hasColumn('jobs', 'id')) {
                $primary_key_exists = DB::select(
                    DB::raw(
                        'SHOW KEYS
        FROM jobs
        WHERE Key_name="PRIMARY"'
                    )
                );
                if (!$primary_key_exists) {
                    DB::statement('ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`);');

                    // auto increment
                    DB::statement('ALTER TABLE `jobs`
   MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT');
                }
            }

            // queue
            if (Schema::hasColumn('jobs', 'queue')) {
                $queue_fk_key_exists = DB::select(
                    DB::raw(
                        'SHOW KEYS
        FROM jobs
        WHERE Key_name="jobs_queue_index"'
                    )
                );
                if (!$queue_fk_key_exists) {
                    DB::statement('ALTER TABLE `jobs`
                      ADD KEY `jobs_queue_index` (`queue`);');
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
        Schema::table('jobs', function (Blueprint $table) {
            //
        });
    }
}
