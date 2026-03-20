<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Prducts extends Migration
{
    public function up()
    {
        $this -> forge -> addField([
            'pk_product' => ['type' => 'INT', 'constraint' => 5, 'auto_increment' => true],
            'product' => ['type' => 'VARCHAR', 'constraint' => 10],
            'price' => ['type' => 'INT', 'constraint' => 10],
            'description' => ['type' => 'TEXT', 'constraint' => 255,'default' => ''],
           'stock_min' => ['type' => 'INT', 'constraint' => 10],
           'stock_max' => ['type' => 'INT', 'constraint' => 10]
        ]);
        $this -> forge -> addKey('pk_product',true);
        $this -> forge -> createTable('products');
    }

    public function down()
    {
        //
    }
}
