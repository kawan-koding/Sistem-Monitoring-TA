<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use App\Imports\MahasiswaImport;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\Mahasiswa\MahasiswaRequest;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            "title" => "Mahasiswa",
            "breadcrumb1" => "Mahasiswa",
            "breadcrumb2" => "Index",
            'dataMhs'   => Mahasiswa::all(),
            'jsInit'      => 'js_mahasiswa.js',
            'prodi' => ProgramStudi::all(),
        ];

        return view('Mahasiswa.index', $data);
    }


    public function store(MahasiswaRequest $request)
    {
        try {
            $check = Mahasiswa::where('nim', $request->nim)->first();
            if(isset($user->id)){
                return redirect()->route('admin.mahasiswa')->with('error', 'Nim sudah digunakan');
            }
            $mhs = Mahasiswa::create($request->only(['kelas','email','nim','nama_mhs','program_studi_id','jenis_kelamin','telp']));
            $existingUser = User::where('username', $mhs->nim)->orWhere('email', $mhs->email)->first();
            if(!$existingUser) {
                $request->merge(['name' => $mhs->nama_mhs,'username' => $mhs->nim,'password' => Hash::make($mhs->nim),'userable_type' => Mahasiswa::class, 'userable_id' => $mhs->id]);
                $user = User::create($request->only(['name', 'username', 'email', 'password', 'userable_type', 'userable_id']));
                $user->assignRole('mahasiswa');
            }  else {
                if (is_null($existingUser->userable_id) && is_null($existingUser->userable_type)) {
                    $existingUser->update([
                        'userable_id' => $mhs->id,
                        'userable_type' => Mahasiswa::class,
                    ]);
                }
            }
            return redirect()->route('admin.mahasiswa')->with('success', 'Data berhasil ditambahkan');
        } catch (\Exception $e) {
             return redirect()->route('admin.mahasiswa')->with('error', $e->getMessage());
        }
    }

    public function show(Mahasiswa $mahasiswa)
    {
        return response()->json($mahasiswa);
    }

    public function update(MahasiswaRequest $request, Mahasiswa $mahasiswa)
    {
        try {
            $oldEmail = $mahasiswa->email;
            $oldNim = $mahasiswa->nim;
            $mahasiswa->update($request->only(['kelas','email','nim','nama_mhs','program_studi_id','jenis_kelamin','telp']));
            if ($oldEmail !== $mahasiswa->email || $oldNim !== $mahasiswa->nim) {
                $user = $mahasiswa->user;
                $existingUser = User::where('username', $mahasiswa->nim)->orWhere('email', $mahasiswa->email)->where('id', '!=', $user->id)->first();
                if(!$existingUser) {
                    $request->merge(['username' => $mahasiswa->nim,'password' => Hash::make($mahasiswa->nim)]);
                    $mahasiswa->user->update($request->only(['name', 'username', 'email', 'password']));          
                }
            }            
            return redirect()->route('admin.mahasiswa')->with('success', 'Data berhasil diupdate');
        } catch (\Exception $e) {
            return redirect()->route('admin.mahasiswa')->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mahasiswa $mahasiswa)
    {
        try {
            $mahasiswa->user()->delete();
            $mahasiswa->delete();       
        } catch (\Exception $e) {
            return redirect()->route('admin.mahasiswa')->with('error', $e->getMessage());
        }
    }

    public function import(Request $request)
    {
        try {
            // validasi
            $this->validate($request, [
                'file' => 'required|mimes:csv,xls,xlsx'
            ]);

            // menangkap file excel
            $file = $request->file('file');

            // membuat nama file unik
            $nama_file = rand().$file->getClientOriginalName();

            // upload ke folder file_dosen di dalam folder public
            $file->move('file_mahasiswa',$nama_file);

            // import data
            Excel::import(new MahasiswaImport, public_path('file_mahasiswa/'.$nama_file));

            return redirect()->route('admin.mahasiswa')->with('success', 'Berhasil melakukan import');

        } catch (\Exception $e) {
            return redirect()->route('admin.mahasiswa')->with('error', $e->getMessage());
        }
    }
}
