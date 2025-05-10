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
     */
    public function run(): void
    {
        User::query()->create([
            'name' => 'test Account',
            'email' => 'example@gmail.com',
            'password' => Hash::make('password'),
            'email_verified_at' => date('Y-m-d H:i:s')
        ]);
    }
}
