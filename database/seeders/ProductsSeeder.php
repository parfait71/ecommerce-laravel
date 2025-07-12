<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Récupère l'ID de la catégorie "Informatique"
        $categoryId = DB::table('categories')->where('name', 'Informatique')->value('id');

        DB::table('products')->insert([
            [
                'name' => 'Ordinateur Portable HP',
                'description' => 'Core i5, 8GB RAM, 512GB SSD',
                'price' => 450000,
                'stock' => 10, // tu peux ajuster selon tes besoins
                'category_id' => $categoryId,
                'image' => null, // ou une URL vers une image
            ],
        ]);
    }
}
