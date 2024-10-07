<?php

namespace App\Imports;

use App\Models\Dosen;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;

class DosenImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $dosen = Dosen::where('nidn', $row['nidn'])->first();
        if($dosen) {
            return null;
        }
        $gender = strtoupper($row['jenis_kelamin']) === 'P' ? 'P' : 'L';
        $dsn = new Dosen(['nip' => $row['nip'], 'nidn' => $row['nidn'], 'name' => $row['name'],'email' => $row['email'],'jenis_kelamin' => $gender,'telp' => $row['telp'], 'alamat' => $row['alamat']]);
        $dsn->save();
        $existingUser = User::where('email', $row['email'])->orWhere('username', $row['nidn'])->first();
        if ($existingUser) {
            if (is_null($existingUser->userable_type) && is_null($existingUser->userable_id)) {
                $existingUser->update(['userable_type' => Dosen::class, 'userable_id' => $dsn->id]);
            }
        } else {
            $user = User::create(['name' => $row['name'],'username' => $row['nidn'],'email' => $row['email'],'password' => Hash::make($row['nidn']),'userable_type' => Dosen::class,'userable_id' => $dsn->id]);
            $user->assignRole('Dosen');
        }
        return $dsn;
    }
}
