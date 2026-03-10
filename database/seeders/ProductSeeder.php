<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Product::create([
        'name'=>'iPhone 15',
        'price'=>80000,
        'stock'=>10,
        'vendor_id'=>1
        ]);

        Product::create([
        'name'=>'Samsung S24',
        'price'=>75000,
        'stock'=>10,
        'vendor_id'=>2
        ]);
    }
}
