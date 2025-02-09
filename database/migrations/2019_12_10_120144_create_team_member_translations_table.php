<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateTeamMemberTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_member_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('team_member_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['team_member_id', 'locale']);
            $table->foreign('team_member_id')->references('id')->on('team_members')->onDelete('cascade');
            $table->string('name');
            $table->string('title');
            $table->string('alt')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('team_member_translations');
    }
}
