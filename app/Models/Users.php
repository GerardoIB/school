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
}
