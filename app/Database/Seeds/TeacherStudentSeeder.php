<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class TeacherStudentSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('es_ES');

        // Este seeder puede usarse independientemente para crear más relaciones
        // o datos de prueba adicionales

        // Obtener profesores y alumnos existentes
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

        if (empty($professors) || empty($students)) {
            echo "No hay profesores o alumnos para crear relaciones.\n";
            return;
        }

        // Crear relaciones adicionales si no existen
        foreach ($students as $student) {
            // Verificar si el alumno ya tiene al menos un profesor asignado
            $existingRelation = $this->db->table('teacher_student')
                ->where('student_id', $student['pk_user'])
                ->countAllResults();

            if ($existingRelation == 0) {
                // Asignar un profesor aleatorio
                $randomProf = $faker->randomElement($professors);
                $this->db->table('teacher_student')->insert([
                    'teacher_id' => $randomProf['pk_user'],
                    'student_id' => $student['pk_user'],
                ]);
            }
        }

        echo "Relaciones profesor-alumno verificadas y creadas.\n";
    }
}