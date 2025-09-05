<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlogifySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1) Explicit Admin you can use to log in
        User::updateOrCreate(
            ['email' => 'admin@blogify.test'],
            ['name' => 'Super Admin', 'password' => Hash::make('password'), 'role' => 'admin']
        );

        // 2) Create 50 users with roles (10 Admin, 40 Editor)
        // 10 admins
        User::factory()->count(2)->create([
            'role' => 'admin',
        ]);

        // 40 editors
        User::factory()->count(9)->create([
            'role' => 'editor',
        ]);

        // 3) Categories (10) & Tags (20)
        $categories = Category::factory()->count(20)->create();
        $tags       = Tag::factory()->count(30)->create();

        // 4) Blogs (10), authored by random users (often editors)
        Blog::factory()->count(50)->create()->each(function (Blog $b) use ($categories,$tags) {
            $b->categories()->sync($categories->random(2)->pluck('id'));
            $b->tags()->sync($tags->random(3)->pluck('id'));
        });
    }
}
