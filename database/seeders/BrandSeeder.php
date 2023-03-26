<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $title_1 = "LG";
        $title_2 = "Louis Vuitton";
        $title_3 = "Adidas";
        $brands = [
            [
                'uuid'       => uuid(),
                'title'      => $title_1,
                'slug'       => Str::slug($title_1, '-'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid'       => uuid(),
                'title'      => $title_2,
                'slug'       => Str::slug($title_2, '-'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid'       => uuid(),
                'title'      => $title_3,
                'slug'       => Str::slug($title_3, '-'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        Brand::insert($brands);
    }
}
