<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductVariation;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Simple Product 1
        Product::create([
            'type' => 'simple',
            'name' => ['en' => 'iPhone 15', 'ar' => 'آيفون 15'],
            'price' => 999,
            'original_price' => 1199,
            'discount' => 200,
            'image' => 'https://via.placeholder.com/300',
            'is_featured' => true,
            'ai_suggested' => true,
        ]);

        // Simple Product 2
        Product::create([
            'type' => 'simple',
            'name' => ['en' => 'MacBook Air', 'ar' => 'ماك بوك آير'],
            'price' => 1500,
            'original_price' => 1500,
            'discount' => 0,
            'image' => 'https://via.placeholder.com/300',
            'is_featured' => false,
            'ai_suggested' => false,
        ]);

        // Variable Product 1
        $tshirt = Product::create([
            'type' => 'variable',
            'name' => ['en' => 'T-Shirt', 'ar' => 'تي شيرت'],
            'discount' => null,
            'image' => 'https://via.placeholder.com/300',
            'is_featured' => false,
            'ai_suggested' => false,
        ]);

        $tshirt->variations()->createMany([
            ['price' => 50, 'variations' => ['size' => 'S', 'color' => 'Red']],
            ['price' => 60, 'variations' => ['size' => 'M', 'color' => 'Blue']],
            ['price' => 75, 'variations' => ['size' => 'L', 'color' => 'Black']],
        ]);

        // Variable Product 2
        $shoes = Product::create([
            'type' => 'variable',
            'name' => ['en' => 'Running Shoes', 'ar' => 'أحذية جري'],
            'discount' => null,
            'image' => 'https://via.placeholder.com/300',
            'is_featured' => true,
            'ai_suggested' => false,
        ]);

        $shoes->variations()->createMany([
            ['price' => 100, 'variations' => ['size' => 40, 'color' => 'White']],
            ['price' => 120, 'variations' => ['size' => 42, 'color' => 'Black']],
        ]);
    }
}
