<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name'        => 'Elektronik',
                'description' => 'Barang-barang elektronik seperti HP, laptop, dll.',
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s')
            ],
            [
                'name'        => 'Pakaian',
                'description' => 'Baju, celana, dan aksesoris fashion.',
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s')
            ],
            [
                'name'        => 'Makanan',
                'description' => 'Makanan ringan, minuman, dan kebutuhan dapur.',
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s')
            ]
        ];

        $this->db->table('product_category')->insertBatch($data);
    }
}
