<?php

use App\Parameter;
use App\ParameterValue;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin_rol = ParameterValue::where('name', 'Admin')->first();
        $teacher_rol = ParameterValue::where('name', 'Profesor')->first();
        $User = [
            [
                'first_name' => 'Admin',
                'first_last_name' => 'Itsa',
                'photo_url' => 'https://www.canva.com/design/DAErgA5_5Fw/50qtGEjkxBLMotXqa6R9IQ/view?utm_content=DAErgA5_5Fw&utm_campaign=designshare&utm_medium=link&utm_source=publishsharelink',
                'role_id' => $admin_rol->id,
                'email' => 'admin@itsa.edu.co',
                'password' => Hash::make('secret')
            ],
            [
                'first_name' => 'Charles',
                'first_last_name' => 'Xavier',
                'photo_url' => 'https://cdn.hobbyconsolas.com/sites/navi.axelspringer.es/public/styles/1200/public/media/image/2020/01/profesor-xavier-1847543.jpg?itok=W3lN-g7f',
                'role_id' => $teacher_rol->id,
                'email' => 'cxavier@itsa.edu.co',
                'password' => Hash::make('secret')
            ]
        ];

        foreach ($User as  $user) {
            User::create([
                'first_name' => $user['first_name'],
                'first_last_name' => $user['first_last_name'],
                'photo_url' => $user['photo_url'],
                'role_id' => $user['role_id'],
                'email' => $user['email'],
                'password' => $user['password'],
            ]);
        }
    }
}
