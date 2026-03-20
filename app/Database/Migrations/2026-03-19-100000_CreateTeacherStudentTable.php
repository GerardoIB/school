<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTeacherStudentTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true
            ],
            'teacher_id' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'student_id' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP')
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('teacher_id', 'users', 'pk_user', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('student_id', 'users', 'pk_user', 'CASCADE', 'CASCADE');

        // Índice único para evitar duplicados
        $this->forge->addKey(['teacher_id', 'student_id'], false, true);

        $this->forge->createTable('teacher_student');
    }

    public function down()
    {
        $this->forge->dropTable('teacher_student');
    }
}