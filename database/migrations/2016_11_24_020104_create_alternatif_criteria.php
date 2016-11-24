<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlternatifCriteria extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('criterias', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('user_id');
            $table->timestamps();
        });
        Schema::create('alternatives', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('user_id');
            $table->timestamps();
        });
        Schema::create('alternative_criteria', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('criteria_id');
            $table->unsignedInteger('alternative_id');
            $table->double('value');
            $table->timestamps();
        });
        Schema::create('ratio_indices', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('n');
            $table->double('value');
            $table->unsignedInteger('user_id');
            $table->timestamps();
        });
        Schema::table('alternative_criteria', function ($table) {
            $table->foreign('criteria_id')->references('id')->on('criterias');
            $table->foreign('alternative_id')->references('id')->on('alternatives');
        });
        Schema::table('criterias', function ($table) {
            $table->foreign('user_id')->references('id')->on('users');
        });
        Schema::table('alternatives', function ($table) {
            $table->foreign('user_id')->references('id')->on('users');
        });
        Schema::table('ratio_indices', function ($table) {
            $table->foreign('user_id')->references('id')->on('users');
        });
        

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ratio_indices', function ($table) {
            $table->dropForeign('ratio_indices_user_id_foreign');
        });
        Schema::table('criterias', function ($table) {
            $table->dropForeign('criterias_user_id_foreign');
        });
        Schema::table('alternatives', function ($table) {
            $table->dropForeign('alternatives_user_id_foreign');
        });
        Schema::table('alternative_criteria', function ($table) {
            $table->dropForeign('alternative_criteria_criteria_id_foreign');
            $table->dropForeign('alternative_criteria_alternative_id_foreign');
        });
        
        Schema::dropIfExists('criterias');
        Schema::dropIfExists('alternatives');
        Schema::dropIfExists('alternative_criteria');
        Schema::dropIfExists('ratio_indices');
    }
}
