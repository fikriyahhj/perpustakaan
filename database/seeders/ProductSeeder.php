<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void
{
    \App\Models\Product::create([
        'name' => 'Laut Bercerita',
        'sku' => 'BKU001',
        'price' => 50000,
        'stock' => 5,
    ]);

    \App\Models\Product::create([
        'name' => 'Bumi',
        'sku' => 'BKU002',
        'price' => 60000,
        'stock' => 3,
    ]);

    \App\Models\Product::create([
        'name' => 'Negeri 5 Menara',
        'sku' => 'BKU003',
        'price' => 55000,
        'stock' => 4,
    ]);
}
}