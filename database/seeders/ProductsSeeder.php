<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsSeeder extends Seeder
{
    public function run()
    {
        $informatiqueId = DB::table('categories')->where('name', 'Informatique')->value('id');
        $accessoiresId = DB::table('categories')->where('name', 'Accessoires')->value('id');
        $audioId = DB::table('categories')->where('name', 'Audio')->value('id');
        $impressionId = DB::table('categories')->where('name', 'Impression')->value('id');
        $ecransId = DB::table('categories')->where('name', 'Écrans')->value('id');
        $stockageId = DB::table('categories')->where('name', 'Stockage')->value('id');
        $telephonieId = DB::table('categories')->where('name', 'Téléphonie')->value('id');

        DB::table('products')->insert([
            [
                'name' => 'Ordinateur Portable HP',
                'description' => 'Core i5, 8GB RAM, 512GB SSD',
                'price' => 450000,
                'stock' => 10,
                'category_id' => $informatiqueId,
                'image' => null,
            ],
            [
                'name' => 'PC Gamer ASUS',
                'description' => 'Ryzen 7, 16GB RAM, RTX 3060',
                'price' => 850000,
                'stock' => 5,
                'category_id' => $informatiqueId,
                'image' => null,
            ],
            [
                'name' => 'Imprimante Canon',
                'description' => 'Jet d\'encre couleur, WiFi',
                'price' => 120000,
                'stock' => 8,
                'category_id' => $impressionId,
                'image' => null,
            ],
            [
                'name' => 'Souris Logitech',
                'description' => 'Souris sans fil, ergonomique',
                'price' => 15000,
                'stock' => 30,
                'category_id' => $accessoiresId,
                'image' => null,
            ],
            [
                'name' => 'Clavier Mécanique',
                'description' => 'RGB, AZERTY, USB',
                'price' => 35000,
                'stock' => 20,
                'category_id' => $accessoiresId,
                'image' => null,
            ],
            [
                'name' => 'Écran Samsung 24"',
                'description' => 'Full HD, HDMI, 75Hz',
                'price' => 90000,
                'stock' => 12,
                'category_id' => $ecransId,
                'image' => null,
            ],
            [
                'name' => 'Disque SSD 1To',
                'description' => 'SATA, 2.5", 550Mo/s',
                'price' => 60000,
                'stock' => 15,
                'category_id' => $stockageId,
                'image' => null,
            ],
            [
                'name' => 'Casque Audio JBL',
                'description' => 'Bluetooth, Micro intégré',
                'price' => 40000,
                'stock' => 18,
                'category_id' => $audioId,
                'image' => null,
            ],
            [
                'name' => 'Webcam HD',
                'description' => '1080p, USB, Microphone',
                'price' => 25000,
                'stock' => 25,
                'category_id' => $accessoiresId,
                'image' => null,
            ],
            [
                'name' => 'Smartphone Samsung',
                'description' => 'Galaxy A52, 128GB, 6GB RAM',
                'price' => 210000,
                'stock' => 14,
                'category_id' => $telephonieId,
                'image' => null,
            ],
        ]);
    }
}
