<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserTableSeeder::class);
        $this->call(CriteriasTableSeeder::class);
        $this->call(AlternativesTableSeeder::class);
        $this->call(AlternativeCriteriaTableSeeder::class);
        $this->call(RatioIndicesTableSeeder::class);
        
    }
}
