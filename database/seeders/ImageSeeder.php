<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ImageSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat kategori terlebih dahulu agar tidak kena error foreign key
        DB::table('categories')->insertOrIgnore([
            ['id' => 1, 'name' => 'Makanan', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Minuman', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 2. Buat atau update Nasi Goreng (ID 1)
        Product::updateOrCreate(
            ['id' => 1],
            [
                'category_id' => 1,
                'name'        => 'Nasi Goreng',
                'price'       => 15000,
                'stock'       => 50,
                'images'      => 'nasi-goreng.jpg',
            ]
        );

        // 3. Buat atau update Burger (ID 2)
        Product::updateOrCreate(
            ['id' => 2],
            [
                'category_id' => 1,
                'name'        => 'Burger',
                'price'       => 20000,
                'stock'       => 30,
                'images'      => 'burger.jpg',
            ]
        );

         Product::updateOrCreate(
            ['id' => 3],
            [
                'category_id' => 1,
                'name'        => 'pangsit',
                'price'       => 20000,
                'stock'       => 30,
                'images'      => 'pangsit.jpg',
            ]
        );

         Product::updateOrCreate(
            ['id' => 4],
            [
                'category_id' => 1,
                'name'        => 'nasi padang',
                'price'       => 20000,
                'stock'       => 30,
                'images'      => 'nasi-padang.jpg',
            ]
        );
    }
}

  
    
