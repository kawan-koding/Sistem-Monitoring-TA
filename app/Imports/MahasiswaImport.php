<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Mahasiswa;
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
        $existingStudent = Mahasiswa::where('nim', $row['nim'])->orWhere('email', $row['email'])->first();
        if($existingStudent) { return null; }
        $gender = strtoupper($row['jenis_kelamin']) === 'L' ? 'Laki-laki' : (strtoupper($row['jenis_kelamin']) === 'P' ? 'Perempuan' : 'Lainnya');
        $student = new Mahasiswa(['kelas' => $row['kelas'],'nim' => $row['nim'],'nama_mhs' => $row['nama_mahasiswa'],'email' => $row['email'],'jenis_kelamin' => $gender,'telp' => $row['telp'],]);
        $student->save();
        $existingUser = User::where('email', $row['email'])->orWhere('username', $row['nim'])->first();
        if ($existingUser) {
            if (is_null($existingUser->userable_type) && is_null($existingUser->userable_id)) {
                $existingUser->update(['userable_type' => Mahasiswa::class,'userable_id' => $student->id]);
            }
        } else {
            $user = User::create(['name' => $row['nama_mahasiswa'],'username' => $row['nim'],'email' => $row['email'],'password' => Hash::make($row['nim']),'userable_type' => Mahasiswa::class,'userable_id' => $student->id]);
            $user->assignRole('Mahasiswa');
        }
        return $student;
    }
}
