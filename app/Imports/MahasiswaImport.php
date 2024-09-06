<?php

namespace App\Imports;

use App\Models\Mahasiswa;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MahasiswaImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // dd($row);
        if (empty($row['nim']) || empty($row['nama_mhs'])) {
            return null; // Skip row if essential fields are empty
        }

        $user = User::create([
            'name' => $row['nama_mhs'],
            'username' => $row['nim'],
            // 'email' => $row['email'],
            'password' => password_hash($row['nim'], PASSWORD_DEFAULT),
            'picture' => 'default.jpg',
            'is_active' => 1
        ]);
        $user->assignRole('mahasiswa');

        $mhsw = new Mahasiswa([
            //
            'user_id' => $user->id,
            'kelas' => $row['kelas'],
            'nim' => $row['nim'],
            'nama_mhs' => $row['nama_mhs'],
            'jenis_kelamin' => $row['jenis_kelamin'],
            'email' => $row['email'],
            'telp' => $row['telp'],
            // 'tempat_lahir' => $row['tempat_lahir'],
            // 'tanggal_lahir' => date('Y-m-d',strtotime($row['tanggal_lahir'])),
            // 'alamat' => $row['alamat'],
        ]);

        return $mhsw;
    }
}
