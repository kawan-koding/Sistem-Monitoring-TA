<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('user.index', [
            "title" => "User",
            "breadcrumb1" => "User",
            "breadcrumb2" => "Index",
            'dataUser'   => User::all(),
            'jsInit'      => 'js_user.js',
        ]);
    }


    public function store(Request $request)
    {
        //
        try {
            $dataRoles = [$request->role, $request->role_2, $request->role_3, $request->role_4];

            $filteredRoles = array_filter($dataRoles, function($value) {
                return $value !== null && $value !== '';
            });
            if (count($filteredRoles) !== count(array_unique($filteredRoles))) {
                return redirect()->back()->with('error', 'Tidak boleh ada role yang sama!');
            }
            // dd($request->all());
            if(isset($request->picture)){
                $imgName = $request->picture->getClientOriginalName() . '-' . time() . '.' . $request->picture->extension();
                $request->picture->move(public_path('images'), $imgName);
                // dd(1);
            }else{
                $imgName = 'default.jpg';
            }
            $usr = User::where('username', $request->username)->first();
            if(isset($user->id)){
                return redirect()->route('admin.user')->with('error', 'User telah terdaftar!!');
            }
            // Potensi kode yang dapat menyebabkan pengecualian
            $result = User::create([
                'name' => $request->name,
                'username' => $request->username,
                // 'email' => $request->email,
                'password' => password_hash($request->password, PASSWORD_DEFAULT),
                'picture' => $imgName,
                'is_active' => 1
            ]);

            $result->assignRole($request->role);
            $result->assignRole($request->role_2);
            $result->assignRole($request->role_3);
            $result->assignRole($request->role_4);

            if($request->role_2 == 'dosen' || $request->role == 'dosen' || $request->role_3 == 'dosen' || $request->role_4 == 'dosen'){
                $dos = Dosen::where('nidn', $request->username)->first();
                if(!isset($dos->id)){
                    Dosen::create([
                        'user_id' => $result->id,
                        'nip' => $request->username,
                        'nidn' => $request->username,
                        'name' => $request->name,
                        'jenis_kelamin' => 'L',
                        'telp' => '0',
                    ]);
                }

            }
            if($request->role_2 == 'mahasiswa' || $request->role == 'mahasiswa' || $request->role_3 == 'mahasiswa' || $request->role_4 == 'mahasiswa'){
                $mah = Mahasiswa::where('nim', $request->username)->first();
                if(!isset($mah->id)){
                    Mahasiswa::create([
                        'user_id' => $result->id,
                        'kelas' => '-',
                        'nim' => $request->username,
                        'nama_mhs' => $request->name,
                        'jenis_kelamin' => 'L',
                        'telp' => '0',
                    ]);
                }

            }

            return redirect()->route('admin.user')->with('success', 'Data berhasil ditambahkan');
        } catch (\Exception $e) {


            return redirect()->route('admin.user')->with('error', $e->getMessage());
        }
    }

    public function show(string $id)
    {
        //
        $data = User::find($id);
        $user = [
            'id' => $data->id,
            'name' => $data->name,
            'username' => $data->username,
            // 'email' => $data->email,
            'password' => $data->password,
        ];
        $array = [
            'role' => $data->getRoleNames(),
        ];
        $gabungArray = array_merge($user, $array);


        echo json_encode($gabungArray);
    }

    public function update(Request $request)
    {
        //
        try {
            $dataRoles = [$request->role, $request->role_2, $request->role_3, $request->role_4];

            $filteredRoles = array_filter($dataRoles, function($value) {
                return $value !== null && $value !== '';
            });
            if (count($filteredRoles) !== count(array_unique($filteredRoles))) {
                return redirect()->back()->with('error', 'Tidak boleh ada role yang sama!');
            }
            
            $user = User::find($request->id);
            if(isset($request->picture)){
                $imgName = $request->picture->getClientOriginalName() . '-' . time() . '.' . $request->picture->extension();
                $request->picture->move(public_path('images'), $imgName);
            }else{
                $imgName = $user->picture;
            }
            // Potensi kode yang dapat menyebabkan pengecualian
            $result = User::where('id', $request->id)->update([
                'name' => $request->name,
                'username' => $request->username,
                // 'email' => $request->email,
                'picture' => $imgName,
            ]);
            // Sync roles
            $roles = collect([$request->role, $request->role_2, $request->role_3, $request->role_4])->filter();
            $user->syncRoles($roles);
            if($request->role_2 == 'dosen' || $request->role == 'dosen' || $request->role_3 == 'dosen' || $request->role_4 == 'dosen'){
                $dos = Dosen::where('nidn', $request->username)->first();
                // dd($result);
                if(!isset($dos->id)){
                    Dosen::create([
                        'user_id' => $request->id,
                        'nip' => $request->username,
                        'nidn' => $request->username,
                        'name' => $request->name,
                        'jenis_kelamin' => 'L',
                        'telp' => '0',
                    ]);
                }

            }
            
            if($request->role_2 == 'mahasiswa' || $request->role == 'mahasiswa' || $request->role_3 == 'mahasiswa' || $request->role_4 == 'mahasiswa'){
                $mah = Mahasiswa::where('nim', $request->username)->first();
                if(!isset($mah->id)){
                    Mahasiswa::create([
                        'user_id' => $request->id,
                        'kelas' => '-',
                        'nim' => $request->username,
                        'nama_mhs' => $request->name,
                        'jenis_kelamin' => 'L',
                        'telp' => '0',
                    ]);
                }

            }
            
            return redirect()->route('admin.user')->with('success', 'Data berhasil diupdate');
        } catch (\Exception $e) {


            return redirect()->route('admin.user')->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        try {
            // Potensi kode yang dapat menyebabkan pengecualian
            User::where('id', $id)->delete();

        } catch (\Exception $e) {


            return redirect()->route('admin.user')->with('error', $e->getMessage());
        }
    }
}

