<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::insert([
            [
                'type' => 'general',
                'key' => 'app_name',
                'name' => 'Nama Aplikasi',
                'value' => 'Sistem Monitoring Tugas Akhir'
            ],
            [
                'type' => 'file',
                'key' => 'app_logo',
                'name' => 'Logo Aplikasi',
                'value' => 'poliwangi.png'
            ],
             [
                'type' => 'general',
                'key' => 'app_copyright',
                'name' => 'Copyright Aplikasi',
                'value' => 'Copyright © 2022. All rights reserved.'
            ],
            [
                'type' => 'file',
                'key' => 'app_favicon',
                'name' => 'Favicon Aplikasi',
                'value' => 'favicon.png'
            ],
            [
                'type' => 'general',
                'key' => 'app_email',
                'name' => 'Email Aplikasi',
                'value' => 'poliwangi@poliwangi.ac.id'
            ],
            [
                'type' => 'general',
                'key' => 'app_phone',
                'name' => 'Telepon Aplikasi',
                'value' => '(0333) 636780'
            ],
            [
                'type' => 'general',
                'key' => 'app_address',
                'name' => 'Alamat Aplikasi',
                'value' => 'SMK 17 AGUSTUS 1945 MUNCAR JL. RAYA BLAMBANGAN NO. 37 MUNCAR, KAB. BANYUWANGI PROV. JATIM'
            ],
        ]);
        //
        // Setting::create([
        //     'type' => 'general',
        //     'options' => 'profile',
        //     'label' => 'logo',
        //     'value' => "POLIWANGI.png",
        //     'is_default' => 1,
        //     'display_suffix' => "-",
        // ]);
        // Setting::create([
        //     'type' => 'general',
        //     'options' => 'profile',
        //     'label' => 'icon',
        //     'value' => "POLIWANGI.png",
        //     'is_default' => 1,
        //     'display_suffix' => "-",
        // ]);
        // Setting::create([
        //     'type' => 'general',
        //     'options' => 'profile',
        //     'label' => 'name',
        //     'value' => "POLITEKNIK NEGERI BANYUWANGI",
        //     'is_default' => 1,
        //     'display_suffix' => "-",
        // ]);
        // Setting::create([
        //     'type' => 'general',
        //     'options' => 'profile',
        //     'label' => 'telephone',
        //     'value' => "08965789",
        //     'is_default' => 1,
        //     'display_suffix' => "-",
        // ]);
        // Setting::create([
        //     'type' => 'general',
        //     'options' => 'profile',
        //     'label' => 'address',
        //     'value' => "lkhjh hhooio",
        //     'is_default' => 1,
        //     'display_suffix' => "-",
        // ]);
        
    }
}
