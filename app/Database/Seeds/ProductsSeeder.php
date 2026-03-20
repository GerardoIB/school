<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProductsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'product'     => 'Laptop Gamer Pro',
                'price'       => 1500.00,
                'description' => 'Procesador i9, 32GB RAM, RTX 4080',
                'stock_min'   => 5,
                'stock_max'   => 20,
            ],
            [
                'product'     => 'Mouse Inalámbrico',
                'price'       => 25.50,
                'description' => 'Egonómico con sensor óptico',
                'stock_min'   => 10,
                'stock_max'   => 50,
            ],
        ];

        // Usamos el query builder para insertar
        $this->db->table('products')->insertBatch($data);
    }
}
