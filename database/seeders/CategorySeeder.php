<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Tenda',
            'Carrier & Ransel',
            'Sleeping Bag & Matras',
            'Alat Masak Outdoor',
            'Lampu & Penerangan',
            'Pakaian Outdoor',
            'Sepatu Tracking',
            'Alat Panjat Tebing',
            'Perlengkapan Navigasi',
            'Survival Kit',
        ];

        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }
    }
}
