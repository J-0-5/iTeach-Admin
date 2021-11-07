<?php

use App\Parameter;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;

class ParameterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Parameter = Config::get('const.parameter');

        foreach ($Parameter as $value) {
            Parameter::create([
                'name' => $value,
            ]);
        }
    }
}
