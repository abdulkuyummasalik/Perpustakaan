<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $categories = ['Fiksi', 'Sains', 'Teknologi', 'Sejarah', 'Biografi'];
        foreach ($categories as $categoryName) {
            Category::create([
                'name' => $categoryName,
                'slug'=> Str::slug($categoryName),
            ]);
        }

        // $images = [
        //     'https://example.com/book1.jpg',
        //     'https://example.com/book2.jpg',
        //     'https://example.com/book3.jpg',
        //     'https://example.com/book4.jpg',
        //     'https://example.com/book5.jpg',
        // ];

        // for ($i = 1; $i <= 11; $i++) {
        //     Book::create([
        //         'title' => 'Book ' . $i,
        //         'author' => fake()->name(),
        //         'publisher' => fake()->company(),
        //         'year' => fake()->year(),
        //         'stock' => fake()->numberBetween(1, 100),
        //         'category_id' => Category::inRandomOrder()->first()->id,
        //         'slug' => Str::slug('Book ' . $i),
        //         'image' => "img/2.jpg",
        //         // 'image' => $images[array_rand($images)],
        //     ]);
        // }

        User::create([
            'name' => 'Khoyum Masalik',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Muhammad Anwar',
            'email' => 'user@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);
    }
}
