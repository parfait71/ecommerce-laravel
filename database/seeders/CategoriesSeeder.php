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
        DB::table('categories')->insert([
            ['name' => 'Informatique', 'description' => 'Matériel informatique'],
            ['name' => 'Téléphonie', 'description' => 'Smartphones et accessoires'],
        ]);
    }
}
