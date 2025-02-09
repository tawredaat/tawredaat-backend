<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddingKeysToPaymentTranslations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('payment_translations')) {
            // primary key
            $primary_key_exists = DB::select(
                DB::raw(
                    'SHOW KEYS
        FROM payment_translations
        WHERE Key_name="PRIMARY"'
                )
            );
            if (!$primary_key_exists) {
                if (Schema::hasColumn('payment_translations', 'id')) {
                    $add_pk_key_raw = 'ALTER TABLE `payment_translations`
                        ADD PRIMARY KEY (`id`)';
                    DB::statement($add_pk_key_raw);

                    // auto increment
                    $auto_increment_raw = 'ALTER TABLE `payment_translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;';
                    DB::statement($auto_increment_raw);

                }
            }

            // unique locale
            // search for the key
            $unique_key_exists = DB::select(
                DB::raw(
                    'SHOW KEYS FROM payment_translations
        WHERE Key_name="payment_translations_payment_id_locale_unique"'
                )
            );

            // if the key does not exists add it
            if (!$unique_key_exists) {
                if (Schema::hasColumn('payment_translations', 'locale')) {

                    $add_unique_key = 'ALTER TABLE `payment_translations`ADD UNIQUE KEY `payment_translations_payment_id_locale_unique`
                     (`payment_id`,`locale`),
  ADD KEY `payment_translations_locale_index` (`locale`);';

                    DB::statement($add_unique_key);
                }
            }

            // FK
            // search for the key
            $unique_key_exists = DB::select(
                DB::raw(
                    'SHOW KEYS
        FROM payment_translations
        WHERE Key_name="payment_translations_payment_id_foreign"'
                )
            );

            // if the key does not exists add it
            if (!$unique_key_exists) {
                if (Schema::hasColumn('payment_translations', 'payment_id')) {

                    $add_fk_key = 'ALTER TABLE `payment_translations`
  ADD CONSTRAINT `payment_translations_payment_id_foreign` FOREIGN KEY
  (`payment_id`) REFERENCES `payments` (`id`) ON DELETE CASCADE;';

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
        Schema::table('payment_translations', function (Blueprint $table) {
            //
        });
    }
}
