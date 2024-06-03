<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Category;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        User::create([
            'name' => 'Brian',
            'username' => 'brian',
            'email' => 'brian@gmail.com',
            'password' => bcrypt('password')
        ]);
        // User::create([
        //     'name' => 'George',
        //     'email' => 'george@gmail.com',
        //     'password' => bcrypt('12345')
        // ]);

        User::factory(4)->create();

        Category::create([
            'name'=> 'Web Programming',
            'slug'=> 'web-programming'
        ]);

        Category::create([
            'name'=> 'Web Design',
            'slug'=> 'web-design'
        ]);

        Category::create([
            'name'=> 'Personal',
            'slug'=> 'personal'
        ]);


        Post::factory(6)->create();
    }
}
