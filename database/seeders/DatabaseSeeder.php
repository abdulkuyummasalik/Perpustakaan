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
        $categories = ['Fiksi', 'Sains', 'Teknologi', 'Sejarah', 'Biografi','Romantis', 'Novel'];
        foreach ($categories as $categoryName) {
            Category::create([
                'name' => $categoryName,
                'slug'=> Str::slug($categoryName),
            ]);
        }
        for ($i = 1; $i <= 20; $i++) {
            Book::create([
                'title' => 'Book ' . $i,
                'author' => fake()->name(),
                'publisher' => fake()->company(),
                'year' => fake()->year(),
                'stock' => fake()->numberBetween(1, 100),
                'category_id' => Category::inRandomOrder()->first()->id,
                'slug' => Str::slug('Book ' . $i),
                'image' => "-",
            ]);
        }

        User::create([
            'name' => 'Khoyum Masalik',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Muhammad Anwar',
            'email' => 'user0@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        User::create([
            'name' => 'Farhan Syarif',
            'email' => 'user1@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        User::create([
            'name' => 'Ilham Awaludin',
            'email' => 'user2@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);
    }
}
