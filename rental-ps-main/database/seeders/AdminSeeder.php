<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'geraldhinoa@gmail.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('kelompok 4'),
                'role' => 'admin',
                'phone_number' => '+6285808750161',
            ]
        );
    }
}
