<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'gio',
            'email' => 'gio@gmail.com',
            'password' => bcrypt('gio1234$'),
            'email_verified_at' => now(),
        ]);

        $user = User::where('email', 'gio@gmail.com')->first();
        $user->assignRole('admin');

        User::create([
            'name' => 'george',
            'email' => 'george@gmail.com',
            'password' => bcrypt('gio1234$'),
            'email_verified_at' => now(),
        ]);

    }
}
