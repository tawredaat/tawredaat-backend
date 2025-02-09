<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddingKeysToFiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('files')) {
            // primary key
            if (Schema::hasColumn('files', 'id')) {
                $primary_key_exists = DB::select(
                    DB::raw(
                        'SHOW KEYS
        FROM files
        WHERE Key_name="PRIMARY"'
                    )
                );
                if (!$primary_key_exists) {
                    DB::statement('ALTER TABLE `files`
  ADD PRIMARY KEY (`id`);');

                    // auto increment
                    DB::statement('ALTER TABLE `files`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT');
                }
            }

            if (Schema::hasColumn('files', 'model_id') && Schema::hasColumn('files', 'model_type')) {
                $files_model_type_model_id_index = DB::select(
                    DB::raw(
                        'SHOW KEYS
        FROM files
        WHERE Key_name="files_model_type_model_id_index"'
                    )
                );
                if (!$files_model_type_model_id_index) {
                    DB::statement('ALTER TABLE `files`
                     ADD KEY `files_model_type_model_id_index` (`model_type`,`model_id`)');
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
        Schema::table('files', function (Blueprint $table) {
            //
        });
    }
}