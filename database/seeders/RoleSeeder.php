<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $admin = Role::create([
            'name' => 'admin',
            'guard_name' => 'web'
        ]);
        $admin->givePermissionTo(Permission::where('group', 'admin')->get());
        $kaprodi = Role::create([
            'name' => 'kaprodi',
            'guard_name' => 'web'
        ]);
        $kaprodi->givePermissionTo(Permission::where('group', 'kaprodi')->get(), ['read-dashboard']);
        $dosen = Role::create([
            'name' => 'dosen',
            'guard_name' => 'web'
        ]);
        $dosen->givePermissionTo(Permission::where('group', 'dosen')->get(), ['read-dashboard']);
        $mahasiswa = Role::create([
            'name' => 'mahasiswa',
            'guard_name' => 'web'
        ]);
        $mahasiswa->givePermissionTo(Permission::where('group', 'mahasiswa')->get(), ['read-dashboard']);

    }
}
