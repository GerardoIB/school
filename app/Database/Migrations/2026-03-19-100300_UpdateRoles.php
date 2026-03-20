<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateRoles extends Migration
{
    public function up()
    {
        // Actualizar roles existentes
        $this->db->table('roles')
            ->where('id', 2)
            ->update(['role' => 'Profesor']);

        $this->db->table('roles')
            ->where('id', 3)
            ->update(['role' => 'Alumno']);

        // Agregar rol de Usuario estándar si no existe
        $exists = $this->db->table('roles')->where('id', 4)->countAllResults();
        if ($exists == 0) {
            $this->db->table('roles')->insert([
                'id' => 4,
                'role' => 'Usuario'
            ]);
        }
    }

    public function down()
    {
        // Revertir cambios
        $this->db->table('roles')
            ->where('id', 2)
            ->update(['role' => 'Editor']);

        $this->db->table('roles')
            ->where('id', 3)
            ->update(['role' => 'User']);

        $this->db->table('roles')->where('id', 4)->delete();
    }
}