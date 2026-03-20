<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTelegramToPersons extends Migration
{
    public function up()
    {
        $this->forge->addColumn('persons', [
            'telegram_chat_id' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'after' => 'birthdate'
            ],
            'telegram_username' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'after' => 'telegram_chat_id'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('persons', 'telegram_chat_id');
        $this->forge->dropColumn('persons', 'telegram_username');
    }
}