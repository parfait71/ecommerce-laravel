<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // ✅ Import nécessaire

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $informatiqueId = DB::table('categories')->where('name', 'Informatique')->value('id');
        $accessoiresId = DB::table('categories')->where('name', 'Accessoires')->value('id');
        $audioId = DB::table('categories')->where('name', 'Audio')->value('id');
        $impressionId = DB::table('categories')->where('name', 'Impression')->value('id');
        $ecransId = DB::table('categories')->where('name', 'Écrans')->value('id');
        $stockageId = DB::table('categories')->where('name', 'Stockage')->value('id');
        $telephonieId = DB::table('categories')->where('name', 'Téléphonie')->value('id');

        DB::table('categories')->insert([

            ['name' => 'Informatique', 'description' => 'Ordinateurs, PC portables, tout-en-un, composants'],
            ['name' => 'Accessoires', 'description' => 'Souris, claviers, webcams, périphériques'],
            ['name' => 'Audio', 'description' => 'Casques, écouteurs, enceintes'],
            ['name' => 'Impression', 'description' => 'Imprimantes, scanners'],
            ['name' => 'Écrans', 'description' => 'Moniteurs, écrans PC'],
            ['name' => 'Stockage', 'description' => 'Disques durs, SSD, clés USB'],
            ['name' => 'Téléphonie', 'description' => 'Smartphones et accessoires'],
        ]);
    }
}
