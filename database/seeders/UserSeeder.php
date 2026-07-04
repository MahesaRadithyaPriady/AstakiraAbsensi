<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'nama' => 'Mahesa Radithya Priady',
            'email' => 'mahesa@astakiramedia.com',
            'password' => 'Mahesaradit1702',
            'role' => 'admin',
        ]);
    }
}
