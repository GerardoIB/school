<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Register extends Migration
{
    public function up()
    {
        
        $this -> forge -> addField([
            
            'nombre' => ['type' => 'VARCHAR', 'constraint' => 16, ],
            'apellido_paterno' => ['type' => 'VARCHAR', 'constraint' => 16],
            'apellido_materno' => ['type' => 'VARCHAR', 'constraint' => 16],
            'pk_phone' => ['type' => 'VARCHAR', 'constraint' => 10],
            'gender' => ['type' => 'ENUM','constraint'=> ['hombre', 'mujer'] ],
            'birthdate' => ['type' => 'DATETIME'],
            'created_at' => ['type' => 'TIMESTAMP', 'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP')],
            'updated_at' => ['type' => 'TIMESTAMP', 'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP')]
        
        ]);
        $this -> forge -> addKey('pk_phone',true);
        $this -> forge -> createTable('persons');

    }

    public function down()
    {
        //
       
       $this -> forge -> dropTable('persons');
      
    }
}
