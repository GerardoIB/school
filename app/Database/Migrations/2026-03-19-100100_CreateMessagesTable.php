<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMessagesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true
            ],
            'sender_id' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'receiver_id' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'message' => [
                'type' => 'TEXT'
            ],
            'sent_at' => [
                'type' => 'TIMESTAMP',
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP')
            ],
            'read_at' => [
                'type' => 'TIMESTAMP',
                'null' => true
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['sent', 'delivered', 'read'],
                'default' => 'sent'
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('sender_id', 'users', 'pk_user', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('receiver_id', 'users', 'pk_user', 'CASCADE', 'CASCADE');
        $this->forge->addKey('sender_id');
        $this->forge->addKey('receiver_id');

        $this->forge->createTable('messages');
    }

    public function down()
    {
        $this->forge->dropTable('messages');
    }
}