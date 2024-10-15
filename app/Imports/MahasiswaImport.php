<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\ProgramStudi;
use Illuminate\Support\Facades\Hash;
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
        $gender = strtoupper($row['jenis_kelamin']) === 'L' ? 'Laki-laki' : (strtoupper($row['jenis_kelamin']) === 'P' ? 'Perempuan' : 'Lainnya');
        $programStudiName = $row['program_studi'] === 'TRPL' ? 'S1 Terapan Teknologi Rekayasa Perangkat Lunak' : ($row['program_studi'] === 'TRK' ? 'S1 Terapan Teknologi Rekayasa Komputer' : ($row['program_studi'] === 'BD' ? 'S1 Terapan Bisnis Digital' : null));
        $programStudi = $programStudiName ? ProgramStudi::where('nama', $programStudiName)->first() : null;
        $programStudiId = $programStudi ? $programStudi->id : null;
        $mahasiswa = Mahasiswa::where('nim', $row['nim'])->orWhere('email', $row['email'])->first();
        if ($mahasiswa) {
            $mahasiswa->update(['kelas' => $row['kelas'],'nim' => $row['nim'],'nama_mhs' => $row['nama_mahasiswa'],'email' => $row['email'],'jenis_kelamin' => $gender,'telp' => $row['telp'], 'program_studi_id' => $programStudiId]);
        } else {
            $mahasiswa = new Mahasiswa(['kelas' => $row['kelas'],'nim' => $row['nim'],'nama_mhs' => $row['nama_mahasiswa'],'email' => $row['email'],'jenis_kelamin' => $gender,'telp' => $row['telp'], 'program_studi_id' => $programStudiId]);
            $mahasiswa->save();
        }
        $existingUser = User::where('email', $row['email'])->orWhere('username', $row['nim'])->first();
        if ($existingUser) {
            if (is_null($existingUser->userable_type) && is_null($existingUser->userable_id)) {
                $existingUser->update(['userable_type' => Mahasiswa::class,'userable_id' => $mahasiswa->id]);
            }
        } else {
            $user = User::create(['name' => $row['nama_mahasiswa'],'username' => $row['nim'],'email' => $row['email'],'password' => Hash::make($row['nim']),'userable_type' => Mahasiswa::class,'userable_id' => $mahasiswa->id]);
            $user->assignRole('Mahasiswa');
        }
        return $mahasiswa;
    }
}
