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

        $kajur = Role::create([
            'name' => 'Kajur',
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
            'read-pengajuan-tugas-akhir',
            'read-daftar-ta','update-daftar-ta', 'delete-daftar-ta',
            'read-jadwal-seminar', 'update-jadwal-seminar',
            'read-kategori-nilai','create-kategori-nilai','update-kategori-nilai','delete-kategori-nilai',
            'read-jenis-dokumen','create-jenis-dokumen','update-jenis-dokumen','delete-jenis-dokumen',
            'read-pemberkasan','create-pemberkasan',
            'read-daftar-sidang','create-daftar-sidang','update-daftar-sidang','delete-daftar-sidang',
        ]);

        $kaprodi->givePermissionTo([
            'read-dashboard',
            'read-pembagian-dosen','update-pembagian-dosen',
            'read-pengajuan-tugas-akhir', 'acc-pengajuan-tugas-akhir', 'reject-pengajuan-tugas-akhir', 'cancel-pengajuan-tugas-akhir',
            'read-pembagian-dosen','update-pembagian-dosen',
            'read-daftar-ta',
            'read-rekomendasi-topik','validate-rekomendasi-topik',
        ]);
        
        $dosen->givePermissionTo([
            'read-dashboard',
            'read-rekomendasi-topik','create-rekomendasi-topik','update-rekomendasi-topik','delete-rekomendasi-topik',
            'read-nilai', 'create-nilai',
            'read-daftar-bimbingan',
            'read-jadwal-seminar',
            'read-daftar-sidang',
            'read-nilai','create-nilai',
            'read-revisi','create-revisi',
            'read-rekapitulasi-nilai',
        ]);

        $kajur->givePermissionTo([
            'read-dashboard',
            'read-rekomendasi-topik',
            'read-daftar-ta',
            'read-mahasiswa',
            'read-dosen',
            'read-jurusan',
            'read-program-studi',
        ]);

        $mahasiswa->givePermissionTo([
            'read-dashboard',
            'read-rekomendasi-topik','take-rekomendasi-topik',
            'read-topik-yang-diambil','cancel-topik-yang-diambil',
            'read-pengajuan-tugas-akhir', 'create-pengajuan-tugas-akhir', 'update-pengajuan-tugas-akhir',
            'read-jadwal-seminar', 
            'read-daftar-sidang', 
            'read-rekapitulasi-nilai',
            'read-nilai',
            'read-revisi',
            'read-pemberkasan','create-pemberkasan',
        ]);
    }
}
