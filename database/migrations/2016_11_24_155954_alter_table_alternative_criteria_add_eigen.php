<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableAlternativeCriteriaAddEigen extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('alternative_criteria', function (Blueprint $table) {
            $table->double('eigen_alternative')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('alternative_criteria', function (Blueprint $table) {
            $table->dropColumn('eigen_alternative');
        });
    }
}
