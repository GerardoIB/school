<?php

namespace App\Models;

use CodeIgniter\Model;

class TeacherStudentModel extends Model
{
    protected $table      = 'teacher_student';
    protected $primaryKey = 'id';
    protected $allowedFields = ['teacher_id', 'student_id'];

    // Fechas automáticas según tu SQL
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Obtiene la lista de alumnos asignados a un profesor específico
     */
    public function getStudentsByTeacher(int $teacherId)
    {
        return $this->db->table($this->table . ' ts')
            ->select('ts.id as relation_id, u.pk_user, p.nombre, p.apellido_paterno, p.pk_phone, p.telegram_chat_id')
            ->join('users u', 'u.pk_user = ts.student_id')
            ->join('persons p', 'p.pk_phone = u.fk_phone')
            ->where('ts.teacher_id', $teacherId)
            ->get()
            ->getResultArray();
    }

    /**
     * Obtiene todas las asignaciones actuales para el Administrador
     */
    public function getAllAssignments()
    {
        return $this->db->table($this->table . ' ts')
            ->select('
                ts.id, 
                p_t.nombre as profe_n, p_t.apellido_paterno as profe_a, 
                p_s.nombre as alumno_n, p_s.apellido_paterno as alumno_a
            ')
            ->join('users u_t', 'u_t.pk_user = ts.teacher_id') // Join para el profesor
            ->join('persons p_t', 'p_t.pk_phone = u_t.fk_phone')
            ->join('users u_s', 'u_s.pk_user = ts.student_id') // Join para el alumno
            ->join('persons p_s', 'p_s.pk_phone = u_s.fk_phone')
            ->orderBy('p_t.apellido_paterno', 'ASC')
            ->get()
            ->getResultArray();
    }

    /**
     * Intenta realizar una asignación y maneja errores de duplicados (UNIQUE key en SQL)
     */
    public function makeAssignment(int $t_id, int $s_id)
    {
        try {
            return $this->insert([
                'teacher_id' => $t_id,
                'student_id' => $s_id
            ]);
        } catch (\Exception $e) {
            return false; // Error por llave UNIQUE duplicada
        }
    }
}