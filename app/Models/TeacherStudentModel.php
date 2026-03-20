<?php

namespace App\Models;

use CodeIgniter\Model;

class TeacherStudentModel extends Model
{
    protected $table = 'teacher_student';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['teacher_id', 'student_id'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    /**
     * Obtiene todos los alumnos asignados a un profesor
     */
    public function getStudentsByTeacher(int $teacherId): array
    {
        return $this->db->table('teacher_student ts')
            ->select('
                ts.id as relation_id,
                u.pk_user,
                p.nombre,
                p.apellido_paterno,
                p.apellido_materno,
                p.pk_phone,
                p.telegram_chat_id,
                p.telegram_username,
                p.gender
            ')
            ->join('users u', 'u.pk_user = ts.student_id')
            ->join('persons p', 'p.pk_phone = u.fk_phone')
            ->where('ts.teacher_id', $teacherId)
            ->get()
            ->getResultArray();
    }

    /**
     * Obtiene todos los profesores de un alumno
     */
    public function getTeachersByStudent(int $studentId): array
    {
        return $this->db->table('teacher_student ts')
            ->select('
                ts.id as relation_id,
                u.pk_user,
                p.nombre,
                p.apellido_paterno,
                p.apellido_materno,
                p.pk_phone,
                p.telegram_chat_id,
                p.telegram_username
            ')
            ->join('users u', 'u.pk_user = ts.teacher_id')
            ->join('persons p', 'p.pk_phone = u.fk_phone')
            ->where('ts.student_id', $studentId)
            ->get()
            ->getResultArray();
    }

    /**
     * Asigna un alumno a un profesor
     */
    public function assignStudentToTeacher(int $teacherId, int $studentId): bool
    {
        // Verificar que no exista la relación
        $exists = $this->where('teacher_id', $teacherId)
            ->where('student_id', $studentId)
            ->first();

        if ($exists) {
            return false; // Ya existe
        }

        return $this->insert([
            'teacher_id' => $teacherId,
            'student_id' => $studentId
        ]);
    }

    /**
     * Remueve un alumno de un profesor
     */
    public function removeStudentFromTeacher(int $teacherId, int $studentId): bool
    {
        return $this->where('teacher_id', $teacherId)
            ->where('student_id', $studentId)
            ->delete();
    }

    /**
     * Verifica si un profesor tiene asignado un alumno específico
     */
    public function isAssigned(int $teacherId, int $studentId): bool
    {
        return $this->where('teacher_id', $teacherId)
            ->where('student_id', $studentId)
            ->countAllResults() > 0;
    }

    /**
     * Cuenta alumnos de un profesor
     */
    public function countStudentsByTeacher(int $teacherId): int
    {
        return $this->where('teacher_id', $teacherId)->countAllResults();
    }

    /**
     * Obtiene alumnos para DataTables (server-side)
     */
    public function getStudentsDataTable(int $teacherId, array $params = []): array
    {
        $builder = $this->db->table('teacher_student ts')
            ->select('
                ts.id as relation_id,
                u.pk_user,
                p.nombre,
                p.apellido_paterno,
                p.apellido_materno,
                p.pk_phone,
                p.telegram_chat_id,
                p.telegram_username
            ')
            ->join('users u', 'u.pk_user = ts.student_id')
            ->join('persons p', 'p.pk_phone = u.fk_phone')
            ->where('ts.teacher_id', $teacherId);

        // Total de registros
        $total = $builder->countAllResults(false);

        // Aplicar búsqueda si existe
        if (!empty($params['search'])) {
            $search = $params['search'];
            $builder->groupStart()
                ->like('p.nombre', $search)
                ->orLike('p.apellido_paterno', $search)
                ->orLike('p.apellido_materno', $search)
                ->orLike('p.pk_phone', $search)
                ->groupEnd();
        }

        // Contar registros filtrados
        $filtered = $builder->countAllResults(false);

        // Aplicar ordenamiento
        if (!empty($params['order'])) {
            $orderColumn = $params['order'][0]['column'] ?? 0;
            $orderDir = $params['order'][0]['dir'] ?? 'asc';
            $columns = ['p.nombre', 'p.apellido_paterno', 'p.pk_phone', 'p.telegram_chat_id'];
            if (isset($columns[$orderColumn])) {
                $builder->orderBy($columns[$orderColumn], $orderDir);
            }
        }

        // Aplicar paginación
        if (!empty($params['start']) && !empty($params['length'])) {
            $builder->limit($params['length'], $params['start']);
        }

        $data = $builder->get()->getResultArray();

        return [
            'data' => $data,
            'recordsTotal' => $total,
            'recordsFiltered' => $filtered
        ];
    }
}