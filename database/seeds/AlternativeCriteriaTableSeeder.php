<?php

use Illuminate\Database\Seeder;

class AlternativeCriteriaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('alternative_criteria')->insert([
		    ['criteria_id'=>1,'alternative_id' => 1, 'value' => 35000000, 'desc' => 'less'],
		    ['criteria_id'=>2,'alternative_id' => 1, 'value' => 15, 'desc' => 'more'],
		    ['criteria_id'=>3,'alternative_id' => 1, 'value' => 100, 'desc' => 'more'],
		    ['criteria_id'=>1,'alternative_id' => 2, 'value' => 45000000, 'desc' => 'less'],
		    ['criteria_id'=>2,'alternative_id' => 2, 'value' => 12, 'desc' => 'more'],
		    ['criteria_id'=>3,'alternative_id' => 2, 'value' => 120, 'desc' => 'more'],
		    ['criteria_id'=>1,'alternative_id' => 3, 'value' => 50000000, 'desc' => 'less'],
		    ['criteria_id'=>2,'alternative_id' => 3, 'value' => 15, 'desc' => 'more'],
		    ['criteria_id'=>3,'alternative_id' => 3, 'value' => 200, 'desc' => 'more']

		]);
    }
}
