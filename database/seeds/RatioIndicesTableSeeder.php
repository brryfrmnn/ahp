<?php

use Illuminate\Database\Seeder;

class RatioIndicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ratio_indices')->insert([
		    ['n' => '1','value' => 0.00,'user_id' => 1],
		    ['n' => '2','value' => 0.00,'user_id' => 1],
		    ['n' => '3','value' => 0.58,'user_id' => 1],
		    ['n' => '4','value' => 0.90,'user_id' => 1],
		    ['n' => '5','value' => 1.12,'user_id' => 1],
		    ['n' => '6','value' => 1.24,'user_id' => 1],
		    ['n' => '7','value' => 1.32,'user_id' => 1],
		    ['n' => '8','value' => 1.41,'user_id' => 1],
		    ['n' => '9','value' => 1.45,'user_id' => 1],
		    ['n' => '10','value' => 1.49,'user_id' => 1],
		    ['n' => '11','value' => 1.51,'user_id' => 1],
		    ['n' => '12','value' => 1.48,'user_id' => 1],
		    ['n' => '13','value' => 1.56,'user_id' => 1],
		    ['n' => '14','value' => 1.57,'user_id' => 1],
		    ['n' => '15','value' => 1.59,'user_id' => 1]
		]);
    }
}
