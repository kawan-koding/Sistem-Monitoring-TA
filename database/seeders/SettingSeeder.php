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
        //
        Setting::create([
            'groups' => 'general',
            'options' => 'profile',
            'label' => 'logo',
            'value' => "POLIWANGI.png",
            'is_default' => 1,
            'display_suffix' => "-",
        ]);
        Setting::create([
            'groups' => 'general',
            'options' => 'profile',
            'label' => 'icon',
            'value' => "POLIWANGI.png",
            'is_default' => 1,
            'display_suffix' => "-",
        ]);
        Setting::create([
            'groups' => 'general',
            'options' => 'profile',
            'label' => 'name',
            'value' => "POLITEKNIK NEGERI BANYUWANGI",
            'is_default' => 1,
            'display_suffix' => "-",
        ]);
        Setting::create([
            'groups' => 'general',
            'options' => 'profile',
            'label' => 'telephone',
            'value' => "08965789",
            'is_default' => 1,
            'display_suffix' => "-",
        ]);
        Setting::create([
            'groups' => 'general',
            'options' => 'profile',
            'label' => 'address',
            'value' => "lkhjh hhooio",
            'is_default' => 1,
            'display_suffix' => "-",
        ]);
    }
}
