<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class UserSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('es_ES');

        // 1. Actualizar roles: Admin(1), Profesor(2), Alumno(3), Usuario(4)
        $roles = [
            ['id' => 1, 'role' => 'Admin'],
            ['id' => 2, 'role' => 'Profesor'],
            ['id' => 3, 'role' => 'Alumno'],
            ['id' => 4, 'role' => 'Usuario'],
        ];

        // Limpiar e insertar roles
      //  $this->db->table('roles')->truncate();
      //  $this->db->table('roles')->insertBatch($roles);

        // 2. Crear usuarios de prueba
        // Admin (nivel 1)
      /*  $adminPhone = '7121895039';
        $this->db->table('persons')->insert([
            'pk_phone' => $adminPhone,
            'nombre' => 'Admin',
            'apellido_paterno' => 'Principal',
            'apellido_materno' => 'Sistema',
            'gender' => 'M',
            'birthdate' => '1980-01-01',
            'telegram_chat_id' => null,
            'telegram_username' => null,
        ]); */
        $adminPhone = '7121895039';
        $this->db->table('users')->insert([
            'fk_phone' => $adminPhone,
            'password' => password_hash('admin123', PASSWORD_DEFAULT),
            'fk_level' => 1,
        ]);
        

        // Crear 3 profesores (nivel 2)
        $professorPhones = [];
        for ($i = 0; $i < 3; $i++) {
            $phone = '222222222' . $i;
            $professorPhones[] = $phone;

            $this->db->table('persons')->insert([
                'pk_phone' => $phone,
                'nombre' => $faker->firstNameMale,
                'apellido_paterno' => $faker->lastName,
                'apellido_materno' => $faker->lastName,
                'gender' => 'M',
                'birthdate' => $faker->date('Y-m-d', '1985-01-01'),
                'telegram_chat_id' => '10' . $i . '5' . $faker->numerify('####'), // Simular chat_id
                'telegram_username' => '@prof_' . strtolower($faker->firstName),
            ]);
            $this->db->table('users')->insert([
                'fk_phone' => $phone,
                'password' => password_hash('prof123', PASSWORD_DEFAULT),
                'fk_level' => 2,
            ]);
        }

        // Crear 10 alumnos (nivel 3)
        $studentPhones = [];
        for ($i = 0; $i < 10; $i++) {
            $phone = '333333333' . $i;
            $studentPhones[] = $phone;

            $this->db->table('persons')->insert([
                'pk_phone' => $phone,
                'nombre' => $faker->firstName,
                'apellido_paterno' => $faker->lastName,
                'apellido_materno' => $faker->lastName,
                'gender' => $faker->randomElement(['M', 'F']),
                'birthdate' => $faker->date('Y-m-d', '2005-01-01'),
                'telegram_chat_id' => '20' . $i . '5' . $faker->numerify('####'), // Simular chat_id
                'telegram_username' => '@alu_' . strtolower($faker->firstName),
            ]);
            $this->db->table('users')->insert([
                'fk_phone' => $phone,
                'password' => password_hash('alumno123', PASSWORD_DEFAULT),
                'fk_level' => 3,
            ]);
        }

        // Relacionar profesores con alumnos (muchos a muchos)
        // Obtener los IDs de los profesores y alumnos
        $professors = $this->db->table('users')
            ->select('pk_user')
            ->where('fk_level', 2)
            ->get()
            ->getResultArray();

        $students = $this->db->table('users')
            ->select('pk_user')
            ->where('fk_level', 3)
            ->get()
            ->getResultArray();

        // Crear relaciones aleatorias
        $relations = [];
        foreach ($professors as $prof) {
            // Cada profesor tiene entre 3 y 6 alumnos
            $numStudents = rand(3, min(6, count($students)));
            $assignedStudents = $faker->randomElements($students, $numStudents);

            foreach ($assignedStudents as $student) {
                $relations[] = [
                    'teacher_id' => $prof['pk_user'],
                    'student_id' => $student['pk_user'],
                ];
            }
        }

        if (!empty($relations)) {
            $this->db->table('teacher_student')->insertBatch($relations);
        }

        // Crear algunos mensajes de prueba
        $messages = [];
        foreach ($professors as $i => $prof) {
            // Cada profesor envía algunos mensajes
            $profStudents = $this->db->table('teacher_student')
                ->where('teacher_id', $prof['pk_user'])
                ->get()
                ->getResultArray();

            foreach ($profStudents as $j => $ps) {
                if ($j < 2) { // Solo 2 mensajes por profesor
                    $messages[] = [
                        'sender_id' => $prof['pk_user'],
                        'receiver_id' => $ps['student_id'],
                        'message' => $faker->randomElement([
                            'Recuerda entregar tu tarea para mañana.',
                            'Excelente trabajo en la última clase.',
                            'No olvides revisar el material de apoyo.',
                            'Próxima clase: revisión de ejercicios.',
                        ]),
                        'status' => 'sent',
                    ];
                }
            }
        }

        if (!empty($messages)) {
            $this->db->table('messages')->insertBatch($messages);
        }
    }
}