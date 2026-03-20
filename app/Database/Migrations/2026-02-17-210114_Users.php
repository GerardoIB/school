<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
{
    public function up()
    {
        $this -> forge -> addField([
            'id' => ['type' => 'INT', 'constraint' => 5],
            'role' => ['type' => 'VARCHAR','constraint' => 255],
            'created_at' => ['type' => 'TIMESTAMP', 'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP')],
            'updated_at' => ['type' => 'TIMESTAMP', 'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP')]
        
        ]);
        $this -> forge -> addKey('id',true);
        $this -> forge -> createTable('roles');
    }

    public function down()
    {
        $this -> forge -> dropTable('users');
    }
}
