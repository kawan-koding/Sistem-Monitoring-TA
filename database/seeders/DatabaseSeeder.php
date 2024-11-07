<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            SettingSeeder::class,
            UserSeeder::class,
            PeriodeTASeeder::class,
            JenisTaSeeder::class,
            TopikSeeder::class,
            JurusanSeeder::class,
            ProgramStudiSeeder::class,
            KategoriNilaiSeeder::class,
            RuanganSeeder::class,
            JenisDokumenSeeder::class
        ]);
    }
}
