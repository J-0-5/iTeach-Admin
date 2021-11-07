<?php

use App\Parameter;
use App\ParameterValue;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;

class ParameterValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Parameter = Parameter::get();

        foreach ($Parameter as  $parameter) {
            $Parameter_Value = Config::get('const.' . $parameter->name);
            foreach ($Parameter_Value as $parameter_Value) {
                ParameterValue::create([
                    'parameter_id' => $parameter->id,
                    'name' => $parameter_Value
                ]);
            }
        }
    }
}
