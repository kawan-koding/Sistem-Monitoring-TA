<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Dosen;
use App\Models\ProgramStudi;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DosenImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $gender = strtoupper($row['jenis_kelamin']) === 'P' ? 'P' : 'L';
        $programStudiName = $row['program_studi'] === 'TRPL' ? 'S1 Terapan Teknologi Rekayasa Perangkat Lunak' : ($row['program_studi'] === 'TRK' ? 'S1 Terapan Teknologi Rekayasa Komputer' : ($row['program_studi'] === 'BD' ? 'S1 Terapan Bisnis Digital' : null));
        $programStudi = $programStudiName ? ProgramStudi::where('nama', $programStudiName)->first() : null;
        $programStudiId = $programStudi ? $programStudi->id : null;
        $dosen = Dosen::where('nidn', $row['nidn'])->first();
        if ($dosen) {
            $dosen->update(['nip' => $row['nip'],'name' => $row['name'],'email' => $row['email'],'jenis_kelamin' => $gender,'telp' => $row['telp'],'alamat' => $row['alamat'],'program_studi_id' => $programStudiId]);
        } else {
            $dosen = new Dosen(['nip' => $row['nip'], 'nidn' => $row['nidn'], 'name' => $row['name'],'email' => $row['email'],'jenis_kelamin' => $gender,'telp' => $row['telp'], 'alamat' => $row['alamat'], 'program_studi_id' => $programStudiId]);
            $dosen->save();
        }
        $existingUser = User::where('email', $row['email'])->orWhere('username', $row['nidn'])->first();
        if ($existingUser) {
            if (is_null($existingUser->userable_type) && is_null($existingUser->userable_id)) {
                $existingUser->update(['userable_type' => Dosen::class, 'userable_id' => $dosen->id]);
            }
        } else {
            $user = User::create(['name' => $row['name'],'username' => $row['nidn'],'email' => $row['email'],'password' => Hash::make($row['nidn']),'userable_type' => Dosen::class,'userable_id' => $dosen->id]);
            $user->assignRole('Dosen');
        }
        return $dosen;
    }
}
