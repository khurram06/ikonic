<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // Hash::make('password') in Laravel 8
            'is_admin' => true,
        ]);

        // Create additional admin users with different emails
        User::factory(1)->create([
            'email' => 'admin1@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'is_admin' => true,
        ]);

        User::factory(1)->create([
            'email' => 'admin2@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'is_admin' => true,
        ]);

        // Create additional admin users with different emails
        User::factory(1)->create([
            'email' => 'user1@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
        ]);

        User::factory(1)->create([
            'email' => 'user2@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
        ]);

    }
}
