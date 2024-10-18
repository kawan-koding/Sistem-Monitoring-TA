<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\ProgramStudi;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
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
        $gender = isset($row['jenis_kelamin']) && strtoupper($row['jenis_kelamin']) === 'L' ? 'Laki-laki' : (isset($row['jenis_kelamin']) && strtoupper($row['jenis_kelamin']) === 'P' ? 'Perempuan' : 'Lainnya');
        $programStudi = isset($row['kode_prodi']) ? ProgramStudi::where('kode', strval($row['kode_prodi']))->first() : null;
        $programStudiId = $programStudi ? $programStudi->id : null;
        $mahasiswa = isset($row['nim']) ? Mahasiswa::where('nim', $row['nim'])->first() : null;
        if ($mahasiswa) {
            $mahasiswa->update([
                'kelas' => isset($row['kelas']) ? $row['kelas'] : null,
                'nim' => isset($row['nim']) ? $row['nim'] : null,
                'nama_mhs' => isset($row['nama_mahasiswa']) ? $row['nama_mahasiswa'] : null,
                'email' => isset($row['email']) ? $row['email'] : null,
                'jenis_kelamin' => $gender,
                'telp' => isset($row['telp']) ? $row['telp'] : null,
                'program_studi_id' => $programStudiId
            ]);
        } else {
            $mahasiswa = Mahasiswa::create([
                'kelas' => isset($row['kelas']) ? $row['kelas'] : null,
                'nim' => isset($row['nim']) ? $row['nim'] : null,
                'nama_mhs' => isset($row['nama_mahasiswa']) ? $row['nama_mahasiswa'] : null,
                'email' => isset($row['email']) ? $row['email'] : null,
                'jenis_kelamin' => $gender,
                'telp' => isset($row['telp']) ? $row['telp'] : null,
                'program_studi_id' => $programStudiId
            ]);
        }
        $existingUser = User::where('username', $mahasiswa->nim)->first();   
        if (is_null($existingUser)) {
            $user = User::create([
                'name' => $mahasiswa->nama_mhs,
                'username' => $mahasiswa->nim,
                'email' => $mahasiswa->email,
                'password' => Hash::make($mahasiswa->nim),
                'userable_type' => Mahasiswa::class,
                'userable_id' => $mahasiswa->id
            ]);
            $user->assignRole('Mahasiswa');
        } else {
            if (is_null($existingUser->userable_type) && is_null($existingUser->userable_id)) {
                $existingUser->update([
                    'userable_type' => Mahasiswa::class,
                    'userable_id' => $mahasiswa->id
                ]);
            }
        }

        return $mahasiswa;
    }

}
