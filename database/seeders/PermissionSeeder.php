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
            ["name" => "read-daftarta-admin", "display_name" => "Lihat Daftar TA Admin"],
            ["name" => "read-seminar-admin", "display_name" => "Lihat Jadwal Seminar Admin"],
            ["name" => "read-settings", "display_name" => "Lihat Pengaturan"],
            ["name" => "read-pengajuanta-kaprodi", "display_name" => "Lihat Pengajuan TA Kaprodi"],
            ["name" => "read-daftarta-kaprodi", "display_name" => "Lihat Daftar TA Kaprodi"],
            ["name" => "read-bagidosen-kaprodi", "display_name" => "Lihat Pembagian Dosen Kaprodi"],
            ["name" => "read-daftar-bimbingan", "display_name" => "Lihat Daftar Bimbingan"],
            ["name" => "read-jadwaluji", "display_name" => "Lihat Jadwal Uji"],
            ["name" => "read-pengajuanta-mahasiswa", "display_name" => "Lihat Pengajuan TA Mahasiswa"],
            ["name" => "read-jadwalseminar-mahasiswa", "display_name" => "Lihat Jadwal Seminar Mahasiswa"],
            ["name" => "read-rumpunilmu", "display_name" => "Lihat Rumpun Ilmu"],
            ["name" => "create-rumpunilmu", "display_name" => "Tambah Rumpun Ilmu"],
            ["name" => "update-rumpunilmu", "display_name" => "Ubah Rumpun Ilmu"],
            ["name" => "delete-rumpunilmu", "display_name" => "Hapus Rumpun Ilmu"],
            
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
            ["name" => "delete-rekomendasi-topik", "display_name" => "Hapus Rekomendasi Topik"],            
            ["name" => "take-rekomendasi-topik", "display_name" => "Mengambil Rekomendasi Topik"],            
            ["name" => "read-topik-yang-diambil", "display_name" => "Lihat Topik Yang Diambil"],
            ["name" => "cancel-topik-yang-diambil", "display_name" => "Batalkan Topik Yang Diambil"],            
            ["name" => "read-kuota", "display_name" => "Lihat Kuota"],
            ["name" => "update-kuota", "display_name" => "Ubah Kuota"],
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
