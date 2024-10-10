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
            'read-jurusan', 'create-jurusan', 'update-jurusan', 'delete-jurusan',
            'read-program-studi', 'create-program-studi', 'update-program-studi', 'delete-program-studi',
            'read-dosen', 'create-dosen', 'update-dosen', 'delete-dosen',
            'read-mahasiswa', 'create-mahasiswa', 'update-mahasiswa', 'delete-mahasiswa','import-mahasiswa',
            'read-topik', 'create-topik', 'update-topik', 'delete-topik',
            'read-jenis', 'create-jenis', 'update-jenis', 'delete-jenis',
            'read-ruangan', 'create-ruangan', 'update-ruangan', 'delete-ruangan',
            'read-periode', 'create-periode', 'update-periode', 'delete-periode','change-periode',
            'read-users', 'create-users', 'update-users', 'delete-users',
            'read-kuota', 'update-kuota',
            'read-setting', 'update-setting',
            'read-tugas-akhir'
        ]);

        $kaprodi->givePermissionTo([
            'read-dashboard',
            'read-pembagian-dosen','update-pembagian-dosen',
            'read-tugas-akhir', 'acc-tugas-akhir', 'reject-tugas-akhir'
        ]);
        
        $dosen->givePermissionTo([
            'read-dashboard',
            'read-rekomendasi-topik','create-rekomendasi-topik','update-rekomendasi-topik','delete-rekomendasi-topik',
        ]);

        $mahasiswa->givePermissionTo([
            'read-dashboard',
            'read-rekomendasi-topik','take-rekomendasi-topik',
            'read-topik-yang-diambil','cancel-topik-yang-diambil',
            'read-tugas-akhir', 'create-tugas-akhir', 'update-tugas-akhir',
        ]);

    }
}
