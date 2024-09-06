<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Permission::insert([
            // Admin
            //Dashboard
            [
                'name' => 'read-dashboard',
                'label' => 'Lihat Dashboard',
                'guard_name' => 'web',
                'group' => 'admin',
            ],
            // Topik
            [
                'name' => 'read-topik',
                'label' => 'Lihat Topik',
                'guard_name' => 'web',
                'group' => 'admin',
            ],
            [
                'name' => 'create-topik',
                'label' => 'Tambah Topik',
                'guard_name' => 'web',
                'group' => 'admin',
            ],
            [
                'name' => 'update-topik',
                'label' => 'Ubah Topik',
                'guard_name' => 'web',
                'group' => 'admin',
            ],
            [
                'name' => 'delete-topik',
                'label' => 'Hapus Topik',
                'guard_name' => 'web',
                'group' => 'admin',
            ],

            // Jenis
            [
                'name' => 'read-jenis',
                'label' => 'Lihat Jenis',
                'guard_name' => 'web',
                'group' => 'admin',
            ],
            [
                'name' => 'create-jenis',
                'label' => 'Tambah Jenis',
                'guard_name' => 'web',
                'group' => 'admin',
            ],
            [
                'name' => 'update-jenis',
                'label' => 'Ubah Jenis',
                'guard_name' => 'web',
                'group' => 'admin',
            ],
            [
                'name' => 'delete-jenis',
                'label' => 'Hapus Jenis',
                'guard_name' => 'web',
                'group' => 'admin',
            ],

            // periode
            [
                'name' => 'read-periode',
                'label' => 'Lihat periode',
                'guard_name' => 'web',
                'group' => 'admin',
            ],
            [
                'name' => 'create-periode',
                'label' => 'Tambah periode',
                'guard_name' => 'web',
                'group' => 'admin',
            ],
            [
                'name' => 'update-periode',
                'label' => 'Ubah periode',
                'guard_name' => 'web',
                'group' => 'admin',
            ],
            [
                'name' => 'delete-periode',
                'label' => 'Hapus periode',
                'guard_name' => 'web',
                'group' => 'admin',
            ],

            // Dosen
            [
                'name' => 'read-dosen',
                'label' => 'Lihat Dosen',
                'guard_name' => 'web',
                'group' => 'admin',
            ],
            [
                'name' => 'create-dosen',
                'label' => 'Tambah Dosen',
                'guard_name' => 'web',
                'group' => 'admin',
            ],
            [
                'name' => 'update-dosen',
                'label' => 'Ubah Dosen',
                'guard_name' => 'web',
                'group' => 'admin',
            ],
            [
                'name' => 'delete-dosen',
                'label' => 'Hapus Dosen',
                'guard_name' => 'web',
                'group' => 'admin',
            ],

            // Mahasiswa
            [
                'name' => 'read-mahasiswa',
                'label' => 'Lihat Mahasiswa',
                'guard_name' => 'web',
                'group' => 'admin',
            ],
            [
                'name' => 'create-mahasiswa',
                'label' => 'Tambah Mahasiswa',
                'guard_name' => 'web',
                'group' => 'admin',
            ],
            [
                'name' => 'update-mahasiswa',
                'label' => 'Ubah Mahasiswa',
                'guard_name' => 'web',
                'group' => 'admin',
            ],
            [
                'name' => 'delete-mahasiswa',
                'label' => 'Hapus Mahasiswa',
                'guard_name' => 'web',
                'group' => 'admin',
            ],

            // Ruangan
            [
                'name' => 'read-ruangan',
                'label' => 'Lihat Ruangan',
                'guard_name' => 'web',
                'group' => 'admin',
            ],
            [
                'name' => 'create-ruangan',
                'label' => 'Tambah Ruangan',
                'guard_name' => 'web',
                'group' => 'admin',
            ],
            [
                'name' => 'update-ruangan',
                'label' => 'Ubah Ruangan',
                'guard_name' => 'web',
                'group' => 'admin',
            ],
            [
                'name' => 'delete-ruangan',
                'label' => 'Hapus Ruangan',
                'guard_name' => 'web',
                'group' => 'admin',
            ],

            // Users
            [
                'name' => 'read-users',
                'label' => 'Lihat Users',
                'guard_name' => 'web',
                'group' => 'admin',
            ],
            [
                'name' => 'create-users',
                'label' => 'Tambah Users',
                'guard_name' => 'web',
                'group' => 'admin',
            ],
            [
                'name' => 'update-users',
                'label' => 'Ubah Users',
                'guard_name' => 'web',
                'group' => 'admin',
            ],
            [
                'name' => 'delete-users',
                'label' => 'Hapus Users',
                'guard_name' => 'web',
                'group' => 'admin',
            ],

            // Kuota Dosen
            [
                'name' => 'read-kuota',
                'label' => 'Lihat Kuota',
                'guard_name' => 'web',
                'group' => 'admin',
            ],
            [
                'name' => 'update-kuota',
                'label' => 'Ubah Kuota',
                'guard_name' => 'web',
                'group' => 'admin',
            ],

            //Daftar Ta
            [
                'name' => 'read-daftarta-admin',
                'label' => 'Lihat daftar',
                'guard_name' => 'web',
                'group' => 'admin',
            ],

            //Jadwal Seminar
            [
                'name' => 'read-seminar-admin',
                'label' => 'Lihat daftar',
                'guard_name' => 'web',
                'group' => 'admin',
            ],

            //settings
            [
                'name' => 'read-settings',
                'label' => 'Lihat Pengaturan',
                'guard_name' => 'web',
                'group' => 'admin',
            ],



            // Kaprodi
            // Pengajuan TA
            [
                'name' => 'read-pengajuanta-kaprodi',
                'label' => 'Lihat Pengajuan TA',
                'guard_name' => 'web',
                'group' => 'kaprodi',
            ],

            //Daftar TA
            [
                'name' => 'read-daftarta-kaprodi',
                'label' => 'Lihat Daftar TA',
                'guard_name' => 'web',
                'group' => 'kaprodi',
            ],

            //Pembagian Dosen
            [
                'name' => 'read-bagidosen-kaprodi',
                'label' => 'Lihat Pembagian Dosen',
                'guard_name' => 'web',
                'group' => 'kaprodi',
            ],

            // Dosen
            // daftar bimbingan
            [
                'name' => 'read-daftar-bimbingan',
                'label' => 'Lihat Daftar Bimbingan',
                'guard_name' => 'web',
                'group' => 'dosen',
            ],

            // Jadwal Uji
            [
                'name' => 'read-jadwaluji',
                'label' => 'Lihat Jadwal Uji',
                'guard_name' => 'web',
                'group' => 'dosen',
            ],


            // Mahasiswa
            // Pengajuan TA
            [
                'name' => 'read-pengajuanta-mahasiswa',
                'label' => 'Lihat Pengajuan TA',
                'guard_name' => 'web',
                'group' => 'mahasiswa',
            ],
            //jadwal seminar
            [
                'name' => 'read-jadwalseminar-mahasiswa',
                'label' => 'Lihat Jadwal Seminar',
                'guard_name' => 'web',
                'group' => 'mahasiswa',
            ],
            //rumpun ilmu
            [
                'name' => 'read-rumpunilmu',
                'label' => 'Lihat Rumpun Ilmu',
                'guard_name' => 'web',
                'group' => 'dosen',
            ],
            [
                'name' => 'create-rumpunilmu',
                'label' => 'Lihat Rumpun Ilmu',
                'guard_name' => 'web',
                'group' => 'dosen',
            ],
            [
                'name' => 'update-rumpunilmu',
                'label' => 'Lihat Rumpun Ilmu',
                'guard_name' => 'web',
                'group' => 'dosen',
            ],
            [
                'name' => 'delete-rumpunilmu',
                'label' => 'Lihat Rumpun Ilmu',
                'guard_name' => 'web',
                'group' => 'dosen',
            ],
        ]);
    }
}
