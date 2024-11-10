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
                'value' => 'Copyright © 2024. All rights reserved.'
            ],
            [
                'type' => 'file',
                'key' => 'app_favicon',
                'name' => 'Favicon Aplikasi',
                'value' => 'poliwangi.png'
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
                'key' => 'app_instagram',
                'name' => 'Instagram',
                'value' => 'https://www.instagram.com/poliwangi_jinggo/'
            ],
            [
                'type' => 'general',
                'key' => 'app_youtube',
                'name' => 'Youtube',
                'value' => 'https://www.youtube.com/c/poliwangitv'
            ],
            [
                'type' => 'general',
                'key' => 'app_facebook',
                'name' => 'Facebook',
                'value' => 'https://www.facebook.com/polinewangi/'
            ],
            [
                'type' => 'general',
                'key' => 'app_address',
                'name' => 'Alamat Aplikasi',
                'value' => 'Jalan Raya Jember KM 13 Banyuwangi 68461, Jawa Timur - Indonesia'
            ],
            [
                'type' => 'general',
                'key' => 'app_template_mentor',
                'name' => 'Template Persetujuan Pembimbing',
                'value' => 'https://drive.google.com/file/d/1bWSKpAuqVDlee8WK_rwDrCc6Gn5nNbh_/view?usp=sharing'
            ],
            [
                'type' => 'general',
                'key' => 'app_template_summary',
                'name' => 'Template Ringkasan',
                'value' => 'https://drive.google.com/file/d/1CF7BnMwtpPVVmo3fkdBsJztGabu_I3FE/view?usp=sharing'
            ],
            [
                'type' => 'file',
                'key' => 'app_bg',
                'name' => 'Background Foto',
                'value' => 'bg.jpeg'
            ],
            [
                'type' => 'general',
                'key' => 'app_template_filing',
                'name' => 'Template Pemberkasan Seminar',
                'value' => 'https://drive.google.com/file/d/1CF7BnMwtpPVVmo3fkdBsJztGabu_I3FE/view?usp=sharing'
            ],
            ]);
    }
}
