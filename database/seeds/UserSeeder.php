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
        $student_rol = ParameterValue::where( 'name', 'Estudiante')->first(); 

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
            ],
            [
                'first_name' => 'Javier',
                'first_last_name' => 'Santaolalla',
                'photo_url' => 'https://s3.amazonaws.com/iomedia-s3/media/celebrities/10649/products/thyssen_santaolalla_marquee__L.jpeg',
                'role_id' => $teacher_rol->id,
                'email' => 'jsantaolalla@itsa.edu.co',
                'password' => Hash::make('secret')
            ],
            [
                'first_name' => 'Selena',
                'first_last_name' => 'Gomez',
                'photo_url' => 'https://e.radio-grpp.io/normal/2018/09/05/325532_673318.jpg',
                'role_id' => $teacher_rol->id,
                'email' => 'sgomez@itsa.edu.co',
                'password' => Hash::make('secret')
            ],
            [
                'first_name' => 'Susana',
                'first_last_name' => 'Rodriguez',
                'photo_url' => 'https://www.show.news/__export/1612130998908/sites/debate/img/2021/01/31/emmaa_crop1612130950724.png_943222218.png',
                'role_id' => $teacher_rol->id,
                'email' => 'srodriguez@itsa.edu.co',
                'password' => Hash::make('secret')
            ], 
            [
                'first_name' => 'Juan',
                'first_last_name' => 'Anachury',
                'photo_url' => 'https://wl-genial.cf.tsp.li/resize/728x/jpg/fb1/d1b/28cce45b038d6baddba3db025d.jpg',
                'role_id' => $student_rol->id,
                'email' => 'juanachury@itsa.edu.co',
                'password' => Hash::make('secret')
            ],
            [
                'first_name' => 'Valerie',
                'first_last_name' => 'Cordero',
                'photo_url' => 'https://media.istockphoto.com/photos/facing-my-future-with-confidence-picture-id1139495117?k=20&m=1139495117&s=612x612&w=0&h=6P1Q43Oi_yERh9pMLki5LrkF3jaG82puPMeQdCoUNx8=',
                'role_id' => $student_rol->id,
                'email' => 'vcordero@itsa.edu.co',
                'password' => Hash::make('secret')
            ], 
            [
                'first_name' => 'Jesus',
                'first_last_name' => 'Ballesteros',
                'photo_url' => 'https://www.studentworldonline.com/userfiles/images/Students/Vietnamese%20student_istock.jpg.jpg',
                'role_id' => $student_rol->id,
                'email' => 'jballesteros@itsa.edu.co',
                'password' => Hash::make('secret')
            ],
            [
                'first_name' => 'Sielva',
                'first_last_name' => 'Maldonado',
                'photo_url' => 'https://www.itsmiparis.com/wp-content/themes/nextline_v4/images/itsmi_student_life.jpg',
                'role_id' => $student_rol->id,
                'email' => 'smaldonado@itsa.edu.co',
                'password' => Hash::make('secret')
            ],
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
