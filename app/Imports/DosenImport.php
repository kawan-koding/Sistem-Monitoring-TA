<?php

namespace App\Imports;

use App\Models\Dosen;
use App\Models\User;
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
        // dd($row['name']);
        // dd($row);
        if (empty($row['nidn']) || empty($row['name'])) {
            return null; // Skip row if essential fields are empty
        }
        $user = User::create([
            'name' => $row['name'],
            'username' => $row['nidn'],
            // 'email' => $row['email'],
            'password' => password_hash($row['nidn'], PASSWORD_DEFAULT),
            'picture' => 'default.jpg',
            'is_active' => 1
        ]);
        $user->assignRole('dosen');

        $dosen = new Dosen([
            //
            'user_id' => $user->id,
            'nip' => $row['nip'],
            'nidn' => $row['nidn'],
            'name' => $row['name'],
            'jenis_kelamin' => $row['jenis_kelamin'],
            'email' => $row['email'],
            'telp' => $row['telp'],
            // 'alamat' => $row['alamat'],
        ]);

        return $dosen;
    }
}
