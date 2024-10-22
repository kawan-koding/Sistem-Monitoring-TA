<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Dosen;
use App\Models\ProgramStudi;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class DosenImport implements ToModel, WithHeadingRow, WithMultipleSheets
{

    public function sheets(): array
    {
        // Kembalikan hanya sheet pertama untuk diproses
        return [
            0 => $this, // Index 0 adalah sheet pertama
        ];
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $nidn = isset($row['nidn']) && !empty(trim($row['nidn'])) ? $row['nidn'] : (isset($row['nip']) ? $row['nip'] : null);
        if (!$nidn) {
            return null;
        }
        
        $gender = isset($row['jenis_kelamin']) && strtoupper($row['jenis_kelamin']) === 'P' ? 'P' : 'L';
        $programStudi = isset($row['kode_prodi']) ? ProgramStudi::where('kode', strval($row['kode_prodi']))->first() : null;
        $programStudiId = $programStudi ? $programStudi->id : null;
        $dosen = isset($row['nidn']) ? Dosen::where('nidn', $row['nidn'])->first() : null;
        if ($dosen) {
            $dosen->update([
                'nip' => isset($row['nip']) ? $row['nip'] : null,
                'name' => isset($row['nama_dosen']) ? $row['nama_dosen'] : null,
                'email' => isset($row['email']) ? $row['email'] : null,
                'jenis_kelamin' => $gender,
                'telp' => isset($row['telp']) ? $row['telp'] : null,
                'alamat' => isset($row['alamat']) ? $row['alamat'] : null,
                'program_studi_id' => $programStudiId
            ]);
        } else {
            $dosen = new Dosen([
                'nip' => isset($row['nip']) ? $row['nip'] : null,
                'nidn' => $nidn,
                'name' => isset($row['nama_dosen']) ? $row['nama_dosen'] : null,
                'email' => isset($row['email']) ? $row['email'] : null,
                'jenis_kelamin' => $gender,
                'telp' => isset($row['telp']) ? $row['telp'] : null,
                'alamat' => isset($row['alamat']) ? $row['alamat'] : null,
                'program_studi_id' => $programStudiId
            ]);
            $dosen->save();
        }

        $existingUser = User::where('username', $dosen->nidn)->first();
        if ($existingUser) {
            if (is_null($existingUser->userable_type) && is_null($existingUser->userable_id)) {
                $existingUser->update([
                    'userable_type' => Dosen::class,
                    'userable_id' => $dosen->id
                ]);
            }
        } else {
            $user = User::create([
                'name' => $dosen->name,
                'username' => $dosen->nidn,
                'email' => $dosen->email,
                'password' => Hash::make($dosen->nidn),
                'userable_type' => Dosen::class,
                'userable_id' => $dosen->id
            ]);
            $user->assignRole('Dosen');
        }

        return $dosen;
    }
}
