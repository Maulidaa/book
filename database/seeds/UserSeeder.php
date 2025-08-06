<?php

use Illuminate\Database\Seeder;
use App\User;
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
        // Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'role_id' => 1,
            'picture' => null,
            'email_verified_at' => now(),
        ]);

        // Author
        User::create([
            'name' => 'Author One',
            'email' => 'author1@example.com',
            'password' => Hash::make('password123'),
            'role_id' => 2,
            'picture' => null,
            'email_verified_at' => now(),
        ]);

        // Readers (default user)
        for ($i = 1; $i <= 10; $i++) {
            User::create([
                'name' => 'Reader ' . $i,
                'email' => 'reader' . $i . '@example.com',
                'password' => Hash::make('password123'),
                'role_id' => 3,
                'picture' => null,
                'email_verified_at' => now(),
            ]);
        }
    }
}
