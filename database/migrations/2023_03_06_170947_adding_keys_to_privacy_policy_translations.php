<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddingKeysToPrivacyPolicyTranslations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (Schema::hasTable('privacy_policy_translations')) {
            // primary key
            $primary_key_exists = DB::select(
                DB::raw(
                    'SHOW KEYS
        FROM privacy_policy_translations
        WHERE Key_name="PRIMARY"'
                )
            );
            if (!$primary_key_exists) {
                if (Schema::hasColumn('privacy_policy_translations', 'id')) {
                    $add_pk_key_raw = 'ALTER TABLE `privacy_policy_translations`
                        ADD PRIMARY KEY (`id`)';
                    DB::statement($add_pk_key_raw);

                    // auto increment
                    $auto_increment_raw = 'ALTER TABLE `privacy_policy_translations`
 MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;';
                    DB::statement($auto_increment_raw);

                }
            }

            // unique locale
            // search for the key
            $unique_key_exists = DB::select(
                DB::raw(
                    'SHOW KEYS FROM privacy_policy_translations
        WHERE Key_name="privacy_policy_translations_privacy_policy_id_locale_unique"'
                )
            );

            // if the key does not exists add it
            if (!$unique_key_exists) {
                if (Schema::hasColumn('privacy_policy_translations', 'locale')) {

                    $add_unique_key = 'ALTER TABLE `privacy_policy_translations`ADD UNIQUE KEY `privacy_policy_translations_privacy_policy_id_locale_unique`
                     (`privacy_policy_id`,`locale`),
  ADD KEY `privacy_policy_translations_locale_index` (`locale`);';

                    DB::statement($add_unique_key);
                }
            }

            // FK
            // search for the key
            $unique_key_exists = DB::select(
                DB::raw(
                    'SHOW KEYS
        FROM privacy_policy_translations
        WHERE Key_name="privacy_policy_translations_privacy_policy_id_foreign"'
                )
            );

            // if the key does not exists add it
            if (!$unique_key_exists) {
                if (Schema::hasColumn('privacy_policy_translations', 'privacy_policy_id')) {

                    $add_fk_key = 'ALTER TABLE `privacy_policy_translations`
  ADD CONSTRAINT `privacy_policy_translations_privacy_policy_id_foreign` FOREIGN KEY
  (`privacy_policy_id`) REFERENCES `privacy_policies` (`id`) ON DELETE CASCADE;';

                    DB::statement($add_fk_key);
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
        Schema::table('privacy_policy_translations', function (Blueprint $table) {
            //
        });
    }
}