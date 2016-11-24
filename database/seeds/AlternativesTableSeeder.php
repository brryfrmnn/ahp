<?php

use Illuminate\Database\Seeder;

class AlternativesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('alternatives')->insert([
		    ['id'=>1,'name' => 'Packet 1', 'user_id' => 1],
		    ['id'=>2,'name' => 'Packet 2', 'user_id' => 1],
		    ['id'=>3,'name' => 'Packet 3', 'user_id' => 1]
		]);
    }
}
