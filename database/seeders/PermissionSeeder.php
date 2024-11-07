<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $permissions = collect([
            ["name" => "read-dashboard", "display_name" => "Lihat Dashboard"],
            ["name" => "read-mahasiswa", "display_name" => "Lihat Mahasiswa"],
            ["name" => "create-mahasiswa", "display_name" => "Tambah Mahasiswa"],
            ["name" => "update-mahasiswa", "display_name" => "Ubah Mahasiswa"],
            ["name" => "delete-mahasiswa", "display_name" => "Hapus Mahasiswa"],
            ["name" => "import-mahasiswa", "display_name" => "Import Mahasiswa"],
            ["name" => "read-topik", "display_name" => "Lihat Topik"],
            ["name" => "create-topik", "display_name" => "Tambah Topik"],
            ["name" => "update-topik", "display_name" => "Ubah Topik"],
            ["name" => "delete-topik", "display_name" => "Hapus Topik"],
            ["name" => "read-jenis", "display_name" => "Lihat Jenis"],
            ["name" => "create-jenis", "display_name" => "Tambah Jenis"],
            ["name" => "update-jenis", "display_name" => "Ubah Jenis"],
            ["name" => "delete-jenis", "display_name" => "Hapus Jenis"],
            ["name" => "read-periode", "display_name" => "Lihat Periode"],
            ["name" => "create-periode", "display_name" => "Tambah Periode"],
            ["name" => "update-periode", "display_name" => "Ubah Periode"],
            ["name" => "delete-periode", "display_name" => "Hapus Periode"],
            ["name" => "change-periode", "display_name" => "Pilih Periode"],
            ["name" => "read-dosen", "display_name" => "Lihat Dosen"],
            ["name" => "create-dosen", "display_name" => "Tambah Dosen"],
            ["name" => "update-dosen", "display_name" => "Ubah Dosen"],
            ["name" => "delete-dosen", "display_name" => "Hapus Dosen"],
            ["name" => "read-ruangan", "display_name" => "Lihat Ruangan"],
            ["name" => "create-ruangan", "display_name" => "Tambah Ruangan"],
            ["name" => "update-ruangan", "display_name" => "Ubah Ruangan"],
            ["name" => "delete-ruangan", "display_name" => "Hapus Ruangan"],
            ["name" => "read-users", "display_name" => "Lihat Users"],
            ["name" => "create-users", "display_name" => "Tambah Users"],
            ["name" => "update-users", "display_name" => "Ubah Users"],
            ["name" => "delete-users", "display_name" => "Hapus Users"],
            ["name" => "read-permissions", "display_name" => "Baca Hak Akses"],
            ["name" => "change-permissions", "display_name" => "Ubah Hak Akses"],
            ["name" => "read-roles", "display_name" => "Lihat Role"],
            ["name" => "create-roles", "display_name" => "Buat Role"],
            ["name" => "update-roles", "display_name" => "Ubah Role"],
            ["name" => "delete-roles", "display_name" => "Hapus Role"],
            ["name" => "read-jurusan", "display_name" => "Lihat Jurusan"],
            ["name" => "create-jurusan", "display_name" => "Buat Jurusan"],
            ["name" => "update-jurusan", "display_name" => "Ubah Jurusan"],
            ["name" => "delete-jurusan", "display_name" => "Hapus Jurusan"],
            ["name" => "read-program-studi", "display_name" => "Lihat Program Studi"],
            ["name" => "create-program-studi", "display_name" => "Buat Program Studi"],
            ["name" => "update-program-studi", "display_name" => "Ubah Program Studi"],
            ["name" => "delete-program-studi", "display_name" => "Hapus Program Studi"],
            ["name" => "read-rekomendasi-topik", "display_name" => "Lihat Rekomendasi Topik"],
            ["name" => "create-rekomendasi-topik", "display_name" => "Buat Rekomendasi Topik"],
            ["name" => "update-rekomendasi-topik", "display_name" => "Ubah Rekomendasi Topik"],
            ["name" => "validate-rekomendasi-topik", "display_name" => "Validasi Rekomendasi Topik"],
            ["name" => "delete-rekomendasi-topik", "display_name" => "Hapus Rekomendasi Topik"],            
            ["name" => "take-rekomendasi-topik", "display_name" => "Mengambil Rekomendasi Topik"],            
            ["name" => "read-topik-yang-diambil", "display_name" => "Lihat Topik Yang Diambil"],
            ["name" => "cancel-topik-yang-diambil", "display_name" => "Batalkan Topik Yang Diambil"],            
            ["name" => "read-kuota", "display_name" => "Lihat Kuota"],
            ["name" => "update-kuota", "display_name" => "Ubah Kuota"],
            ["name" => "read-setting", "display_name" => "Lihat Pengaturan"],
            ["name" => "update-setting", "display_name" => "Ubah Pengaturan"],
            ["name" => "read-pembagian-dosen", "display_name" => "Lihat Pembagian Dosen"],
            ["name" => "update-pembagian-dosen", "display_name" => "Ubah Pembagian Dosen"],
            ["name" => "read-pengajuan-tugas-akhir", "display_name" => "Lihat Pengajuan Tugas Akhir"],
            ["name" => "create-pengajuan-tugas-akhir", "display_name" => "Buat Pengajuan Tugas Akhir"],
            ["name" => "update-pengajuan-tugas-akhir", "display_name" => "Ubah Pengajuan Tugas Akhir"],
            ["name" => "acc-pengajuan-tugas-akhir", "display_name" => "Menyetujui Pengajuan Tugas Akhir"],
            ["name" => "reject-pengajuan-tugas-akhir", "display_name" => "Menolak Pengajuan Tugas Akhir"],
            ["name" => "cancel-pengajuan-tugas-akhir", "display_name" => "Membatalkan Pengajuan Tugas Akhir"],
            ["name" => "read-daftar-ta", "display_name" => "Lihat Daftar Tugas Akhir"],
            ["name" => "update-daftar-ta", "display_name" => "Ubah Daftar Tugas Akhir"],
            ["name" => "delete-daftar-ta", "display_name" => "Hapus Daftar Tugas Akhir"],
            ["name" => "read-jadwal-seminar", "display_name" => "Lihat Jadwal Seminar"],
            ["name" => "update-jadwal-seminar", "display_name" => "Ubah Jadwal Seminar"],
            ["name" => "read-nilai", "display_name" => "Lihat Nilai"],
            ["name" => "create-nilai", "display_name" => "Buat Nilai"],
            ["name" => "read-rekapitulasi-nilai", "display_name" => "Lihat Rekapitulasi Nilai"],
            ["name" => "create-rekapitulasi-nilai", "display_name" => "Buat Rekapitulasi Nilai"],
            ["name" => "read-kategori-nilai", "display_name" => "Lihat Kategori Nilai"],
            ["name" => "create-kategori-nilai", "display_name" => "Buat Kategori Nilai"],
            ["name" => "update-kategori-nilai", "display_name" => "Ubah Kategori Nilai"],
            ["name" => "delete-kategori-nilai", "display_name" => "Hapus Kategori Nilai"],
            ["name" => "read-daftar-bimbingan", "display_name" => "Lihat Daftar Bimbingan"],
            ["name" => "read-jadwal", "display_name" => "Lihat Jadwal"],
            ["name" => "create-revisi", "display_name" => "Buat Revisi"],
            ["name" => "create-penilaian", "display_name" => "Buat Penilaian"],
            ["name" => 'read-jenis-dokumen', 'display_name' => 'Lihat Jenis Dokumen'],
            ["name" => 'create-jenis-dokumen', 'display_name' => 'Buat Jenis Dokumen'],
            ["name" => 'update-jenis-dokumen', 'display_name' => 'Ubah Jenis Dokumen'],
            ["name" => 'delete-jenis-dokumen', 'display_name' => 'Hapus Jenis Dokumen'],
        ]);
        $this->insertPermission($permissions);
    }

    private function insertPermission(Collection $permissions, $guardName = 'web')
    {
        Permission::insert($permissions->map(function ($permission) use ($guardName) {
            return [
                'name' => $permission['name'],
                'guard_name' => $guardName,
                'display_name' => $permission['display_name'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        })->toArray());
    }
}
