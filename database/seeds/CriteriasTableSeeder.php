<?php

use Illuminate\Database\Seeder;

class CriteriasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('criterias')->insert([
		    ['id'=>1,'name' => 'price', 'user_id' => 1],
		    ['id'=>2,'name' => 'stand', 'user_id' => 1],
		    ['id'=>3,'name' => 'invitation', 'user_id' => 1]
		]);
    }
}
