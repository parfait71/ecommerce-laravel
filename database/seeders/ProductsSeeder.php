<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsSeeder extends Seeder
{
    public function run()
    {
        // Désactiver les contraintes de clés étrangères
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('products')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

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
                'price' => 180000,
                'stock' => 10,
                'category_id' => $informatiqueId,
                'image' => 'products/ordinateur-hp.jpg',
            ],
            [
                'name' => 'PC Gamer ASUS',
                'description' => 'Ryzen 7, 16GB RAM, RTX 3060',
                'price' => 250000,
                'stock' => 5,
                'category_id' => $informatiqueId,
                'image' => 'products/pc-gamer-asus.jp.jpg',
            ],
            [
                'name' => 'Imprimante Canon',
                'description' => 'Jet d\'encre couleur, WiFi',
                'price' => 100000,
                'stock' => 8,
                'category_id' => $impressionId,
                'image' => 'products/imprimante-canon.jpg',
            ],
            [
                'name' => 'Souris Logitech',
                'description' => 'Souris sans fil, ergonomique',
                'price' => 5000,
                'stock' => 30,
                'category_id' => $accessoiresId,
                'image' => 'products/souris-logitech.jpg',
            ],
            [
                'name' => 'Clavier Mécanique',
                'description' => 'RGB, AZERTY, USB',
                'price' => 35000,
                'stock' => 20,
                'category_id' => $accessoiresId,
                'image' => 'products/clavier-mecanique.jpg',
            ],
            [
                'name' => 'Écran Samsung 24"',
                'description' => 'Full HD, HDMI, 75Hz',
                'price' => 25000,
                'stock' => 12,
                'category_id' => $ecransId,
                'image' => 'products/ecran-samsung-24.jpg',
            ],
            [
                'name' => 'Disque SSD 1To',
                'description' => 'SATA, 2.5", 550Mo/s',
                'price' => 50000,
                'stock' => 15,
                'category_id' => $stockageId,
                'image' => 'products/disque-ssd-1to.jpg',
            ],
            [
                'name' => 'Casque Audio JBL',
                'description' => 'Bluetooth, Micro intégré',
                'price' => 20000,
                'stock' => 18,
                'category_id' => $audioId,
                'image' => 'products/casque-audio-jbl.jpg',
            ],
            [
                'name' => 'Webcam HD',
                'description' => '1080p, USB, Microphone',
                'price' => 22000,
                'stock' => 25,
                'category_id' => $accessoiresId,
                'image' => 'products/webcam-hd.jpg',
            ],
            [
                'name' => 'Smartphone Samsung',
                'description' => 'Galaxy A52, 128GB, 6GB RAM',
                'price' => 175000,
                'stock' => 14,
                'category_id' => $telephonieId,
                'image' => 'products/smartphone-samsung.jpg',
            ],
            // 20 nouveaux produits Informatique
            [
                'name' => 'MacBook Pro 14" M1',
                'description' => 'Apple M1, 16GB RAM, 512GB SSD',
                'price' => 525000,
                'stock' => 7,
                'category_id' => $informatiqueId,
                'image' => 'products/macbook-pro-14-m1.jpg',
            ],
            [
                'name' => 'Dell XPS 13',
                'description' => 'Intel i7, 16GB RAM, 1TB SSD',
                'price' => 195000,
                'stock' => 9,
                'category_id' => $informatiqueId,
                'image' => 'products/dell-xps-13.jpg',
            ],
            [
                'name' => 'Lenovo ThinkPad X1',
                'description' => 'Intel i5, 8GB RAM, 256GB SSD',
                'price' => 145000,
                'stock' => 12,
                'category_id' => $informatiqueId,
                'image' => 'products/lenovo-thinkpad-x1.jpg',
            ],
            [
                'name' => 'Acer Aspire 5',
                'description' => 'AMD Ryzen 5, 8GB RAM, 512GB SSD',
                'price' => 105000,
                'stock' => 15,
                'category_id' => $informatiqueId,
                'image' => 'products/acer-aspire-5.jpg',
            ],
            [
                'name' => 'HP Pavilion 15',
                'description' => 'Intel i3, 4GB RAM, 256GB SSD',
                'price' => 135000,
                'stock' => 20,
                'category_id' => $informatiqueId,
                'image' => 'products/hp-pavilion-15.jpg',
            ],
            [
                'name' => 'Asus ZenBook 13',
                'description' => 'Intel i5, 8GB RAM, 512GB SSD',
                'price' => 140000,
                'stock' => 10,
                'category_id' => $informatiqueId,
                'image' => 'products/asus-zenbook-13.jpg',
            ],
            [
                'name' => 'Microsoft Surface Laptop 4',
                'description' => 'Intel i5, 8GB RAM, 256GB SSD',
                'price' => 180000,
                'stock' => 8,
                'category_id' => $informatiqueId,
                'image' => 'products/microsoft-surface-laptop-4.jpg',
            ],
            [
                'name' => 'Souris Gamer Logitech G502',
                'description' => 'Souris gaming avec 11 boutons programmables',
                'price' => 7500,
                'stock' => 25,
                'category_id' => $accessoiresId,
                'image' => 'products/souris-gamer-logitech-g502.jpg',
            ],
            [
                'name' => 'Clavier Mécanique Corsair K70',
                'description' => 'Clavier RGB avec switches Cherry MX',
                'price' => 30000,
                'stock' => 15,
                'category_id' => $accessoiresId,
                'image' => 'products/clavier-mecanique-corsair-k70.jpg',
            ],
            [
                'name' => 'Casque Audio Sony WH-1000XM4',
                'description' => 'Casque Bluetooth avec réduction de bruit',
                'price' => 18000,
                'stock' => 12,
                'category_id' => $audioId,
                'image' => 'products/casque-sony-wh-1000xm4.jpg',
            ],
            [
                'name' => 'Webcam Logitech C920 HD',
                'description' => 'Webcam 1080p avec micro intégré',
                'price' => 35000,
                'stock' => 30,
                'category_id' => $accessoiresId,
                'image' => 'products/webcam-logitech-c920-hd.jpg',
            ],
            [
                'name' => 'Enceinte Bluetooth JBL GO 3',
                'description' => 'Enceinte portable waterproof',
                'price' => 25000,
                'stock' => 40,
                'category_id' => $audioId,
                'image' => 'products/enceinte-bluetooth-jbl-go-3.jpg',
            ],
            [
                'name' => 'Tablette Graphique Wacom Intuos',
                'description' => 'Tablette graphique pour dessin digital',
                'price' => 70000,
                'stock' => 8,
                'category_id' => $accessoiresId,
                'image' => 'products/tablette-graphique-wacom-intuos.jpg',
            ],
            [
                'name' => 'Onduleur APC 650VA',
                'description' => 'Onduleur pour protéger vos équipements',
                'price' => 55000,
                'stock' => 10,
                'category_id' => $informatiqueId,
                'image' => 'products/onduleur-apc-650va.jpg',
            ],
            [
                'name' => 'Disque SSD NVMe Samsung 1To',
                'description' => 'SSD haute performance pour gaming',
                'price' => 65000,
                'stock' => 18,
                'category_id' => $stockageId,
                'image' => 'products/disque-ssd-nvme-samsung-1to.jpg',
            ],
        ]);
    }
}
