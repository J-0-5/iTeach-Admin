<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ParameterSeeder::class);
        $this->call(ParameterValueSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(SubjectSeeder::class);
    }
}
