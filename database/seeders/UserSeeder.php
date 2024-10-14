<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $developer = User::create([
            'name' => 'root',
            'username' => 'root',
            'email' => 'root@gmail.com',
            'password' => Hash::make('root'),
            'image' => 'default.jpg',
            'is_active' => 1
        ])->assignRole('Developer');
        $admin = User::create([
            'name' => 'admin',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
            'image' => 'default.jpg',
            'is_active' => 1
        ])->assignRole('Admin');
    }
}
