<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     // 'name' => 'Test User',
        //     // 'email' => 'test@example.com',
        //     'name' => 'admin',
        //     'email' => 'scm.shwesinoo@gmail.com',
        //     'password' => Hash::make('password'),
        //     'profile' => '1588646773.png',
        //     'type' => '0',
        //     'created_user_id' => 1,
        //     'updated_user_id' => 1,
        // ]);

        Post::factory(10)->create();
    }
}
