<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Roles extends Migration
{
    public function up()
    {
        //
       
        $this -> forge -> addField([
            'pk_user' => ['type' => 'INT', 'constraint' => 5, 'auto_increment' => true],
            'fk_phone' => ['type' => 'VARCHAR', 'constraint' => 10],
            'password' => ['type' => 'VARCHAR', 'constraint' => 255],
            'locked' => ['type' => 'TINYINT', 'constraint' => 1,'default' => '0'],
            'fk_level' => ['type' => 'INT', 'constraint' => 5],
            'created_at' => ['type' => 'TIMESTAMP', 'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP')],
            'updated_at' => ['type' => 'TIMESTAMP', 'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP')]
        
        ]);
        $this -> forge -> addKey('pk_user',true);
        $this -> forge -> addForeignKey('fk_phone','persons','pk_phone','cascade','cascade');
        $this -> forge -> addForeignKey('fk_level','roles','id','no action');
        $this -> forge -> createTable('users');
    
    }


    public function down()
    {
        $this -> forge -> dropTable('roles');
    }
}
