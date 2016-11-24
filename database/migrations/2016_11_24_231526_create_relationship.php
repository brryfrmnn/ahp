<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelationship extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('criteria_weightings', function ($table) {
            $table->foreign('first_criteria_id')->references('id')->on('criterias');
            $table->foreign('second_criteria_id')->references('id')->on('criterias');
        });
        Schema::table('eigen_criterias', function ($table) {
            $table->foreign('criteria_id')->references('id')->on('criterias');
        });
        Schema::table('results', function ($table) {
            $table->foreign('alternative_id')->references('id')->on('alternatives');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('criteria_weightings', function (Blueprint $table) {
            $table->dropForeign('criteria_weightings_first_criteria_id_foreign');
            $table->dropForeign('criteria_weightings_second_criteria_id_foreign');
        });
        Schema::table('eigen_criterias', function ($table) {
            $table->dropForeign('eigen_criterias_criteria_id_foreign');
        });
        Schema::table('results', function ($table) {
            $table->dropForeign('results_alternative_id_foreign');
        });
    }
}
