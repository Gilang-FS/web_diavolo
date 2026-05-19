<?php
namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Taekwondo', 'slug' => 'taekwondo', 'description' => 'Perlengkapan Taekwondo', 'image' => 'taekwondo/banner.jpg'],
            ['name' => 'Karate',    'slug' => 'karate',    'description' => 'Perlengkapan Karate',    'image' => 'karate/banner.jpg'],
            ['name' => 'Silat',     'slug' => 'silat',     'description' => 'Perlengkapan Silat',     'image' => 'silat/banner.jpg'],
            ['name' => 'Boxing',    'slug' => 'boxing',    'description' => 'Perlengkapan Boxing',    'image' => 'boxing/banner.jpg'],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(['slug' => $cat['slug']], $cat);
        }
    }
}