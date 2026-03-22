<?php

namespace App\Models;

use CodeIgniter\Model;

class Users extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'pk_user';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['fk_phone','password','fk_level'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getDataPerson($userId){
        return $this->db->table('users')
        ->select('users.*,persons.nombre,persons.apellido_paterno,persons.apellido_materno,persons.pk_phone,persons.gender,persons.birthdate')
        ->join('persons','persons.pk_phone= users.fk_phone')
        ->where('users.pk_user',$userId)
        ->get()
        ->getRowArray();
    }
    public function getAllDataPersons(){
    return $this->db->table('users')
        ->select('users.*, persons.nombre, persons.apellido_paterno, persons.apellido_materno, persons.pk_phone, persons.gender, persons.birthdate')
        ->join('persons', 'persons.pk_phone = users.fk_phone')
        ->get()
        ->getResultArray(); 
}
public function createUserWithPerson(array $personData, array $userData): bool
    {
        $this->db->transStart();

        // 1. Insertar en persons
        $this->db->table('persons')->insert($personData);

        // 2. Insertar en users
        $this->insert($userData);

        $this->db->transComplete();

        return $this->db->transStatus(); // Retorna true si todo salió bien, false si hizo rollback
    }

    /**
     * Actualiza la información de un usuario y su persona
     */
    public function updateUserWithPerson(int $userId, string $phone, array $personData, array $userData = []): bool
    {
        $this->db->transStart();

        // 1. Actualizar persons
        $this->db->table('persons')->where('pk_phone', $phone)->update($personData);

        // 2. Actualizar users (solo si hay datos, ej. nueva contraseña)
        if (!empty($userData)) {
            $this->update($userId, $userData);
        }

        $this->db->transComplete();

        return $this->db->transStatus();
    }

    /**
     * Elimina a un usuario desde la tabla persons (Cascada)
     */
    public function deleteUserAndPerson(string $phone): bool
    {
        $this->db->transStart();
        
        // Gracias al ON DELETE CASCADE, esto borrará también al user y sus relaciones
        $this->db->table('persons')->where('pk_phone', $phone)->delete();
        
        $this->db->transComplete();

        return $this->db->transStatus();
    }
}
