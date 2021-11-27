<?php

use App\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Subjects = [
            'Administración de servidores',

            'Administración de SO',

            'Diseño y desarrollode Aplicaciones móviles',

            'Programación con Frameworks para Web',

            'Desarrollo Humano',

            'Álgebra lineal',

            'Cálculo II',

            'Inglés',

        ];
        foreach ($Subjects as $Subject) {
            Subject::create([
                'name' => $Subject,
            ]);
        }
    }
}
