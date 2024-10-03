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
        $developer = Role::create([
            'name' => 'Developer',
            'guard_name' => 'web'
        ]);

        $admin = Role::create([
            'name' => 'Admin',
            'guard_name' => 'web'
        ]);

        $kaprodi = Role::create([
            'name' => 'Kaprodi',
            'guard_name' => 'web'
        ]);

        $dosen = Role::create([
            'name' => 'Dosen',
            'guard_name' => 'web'
        ]);
        
        $mahasiswa = Role::create([
            'name' => 'Mahasiswa',
            'guard_name' => 'web'
        ]);
        
        $developer->givePermissionTo(Permission::all());

        $admin->givePermissionTo([
            'read-dashboard',
            'read-permissions','change-permissions',
            'read-roles', 'create-roles', 'update-roles', 'delete-roles',
            'read-users', 'create-users', 'update-users', 'delete-users',
            'read-mahasiswa', 'create-mahasiswa', 'update-mahasiswa', 'delete-mahasiswa','import-mahasiswa',
            'read-dosen', 'create-dosen', 'update-dosen', 'delete-dosen',
            'read-jurusan', 'create-jurusan', 'update-jurusan', 'delete-jurusan',
            'read-program-studi', 'create-program-studi', 'update-program-studi', 'delete-program-studi',
        ]);

        $kaprodi->givePermissionTo([
            'read-dashboard',
        ]);
        $dosen->givePermissionTo([
            'read-dashboard',
        ]);
        $mahasiswa->givePermissionTo([
            'read-dashboard',
        ]);

    }
}
