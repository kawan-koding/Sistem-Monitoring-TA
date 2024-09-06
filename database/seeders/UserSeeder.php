<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $admin = User::create([
            'name' => 'root',
            'username' => 'root',
            // 'email' => 'root@gmail.com',
            'password' => password_hash('root', PASSWORD_DEFAULT),
            'picture' => 'default.jpg',
            'is_active' => 1
        ]);

        $admin->assignRole('admin');

        $admin = User::create([
            'name' => 'kaprodi',
            'username' => 'kaprodi',
            // 'email' => 'kaprodi@gmail.com',
            'password' => password_hash('kaprodi', PASSWORD_DEFAULT),
            'picture' => 'default.jpg',
            'is_active' => 1
        ]);

        $admin->assignRole('kaprodi');
    }
}
