<?php

namespace App\Http\Controllers\Administrator\Mahasiswa;

use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use App\Imports\MahasiswaImport;
use App\Http\Controllers\Controller;
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
            'mods' => 'mahasiswa',
            'breadcrumbs' => [
                [
                    'title' => "Dashboard",
                    'url' => route('apps.dashboard') 
                ],
                [
                    'title' => "Master Data",
                    'is_active' => true
                ],
                [
                    'title' => "Mahasiswa",
                    'is_active' => true
                ],
            ],
            'mhs' => Mahasiswa::all(),
            'prodi' => ProgramStudi::all(),
        ];

        return view('administrator.mahasiswa.index', $data);
    }

    public function store(MahasiswaRequest $request)
    {
        try {
            $check = Mahasiswa::where('nim', $request->nim)->first();
            if(isset($user->id)){
                return redirect()->route('apps.mahasiswa')->with('error', 'Nim sudah digunakan');
            }
            $mhs = Mahasiswa::create($request->only(['kelas','email','nim','nama_mhs','program_studi_id','jenis_kelamin','telp']));
            $existingUser = User::where('username', $mhs->nim)->orWhere('email', $mhs->email)->first();
            if(!$existingUser) {
                $request->merge(['name' => $mhs->nama_mhs,'username' => $mhs->nim,'password' => Hash::make($mhs->nim),'userable_type' => Mahasiswa::class, 'userable_id' => $mhs->id]);
                $user = User::create($request->only(['name', 'username', 'email', 'password', 'userable_type', 'userable_id']));
                $user->assignRole('Mahasiswa');
            }  else {
                if (is_null($existingUser->userable_id) && is_null($existingUser->userable_type)) {
                    $existingUser->update([
                        'userable_id' => $mhs->id,
                        'userable_type' => Mahasiswa::class,
                    ]);
                }
            }
            return redirect()->route('apps.mahasiswa')->with('success', 'Data berhasil ditambahkan');
        } catch (\Exception $e) {
             return redirect()->route('apps.mahasiswa')->with('error', $e->getMessage());
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
            return redirect()->route('apps.mahasiswa')->with('success', 'Data berhasil diupdate');
        } catch (\Exception $e) {
            return redirect()->route('apps.mahasiswa')->with('error', $e->getMessage());
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
            return redirect()->route('apps.mahasiswa')->with('error', $e->getMessage());
        }
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx,csv'
        ],[
            'file.required' => 'File harus diisi',
            'file.mimes' => 'File harus berupa xls, xlsx, atau csv'
        ]);

        try {
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $filename = 'Mahasiswa_'. rand(0, 999999999) .'_'. rand(0, 999999999) .'.'. $file->getClientOriginalExtension();
                $file->move(public_path('storage/files/mahasiswa'), $filename);
            }
            
            Excel::import(new MahasiswaImport, public_path('storage/files/mahasiswa/'. $filename));
            
            return redirect()->route('apps.mahasiswa')->with('success', 'Berhasil import mahasiswa');
        } catch (\Exception $e) {
            return redirect()->route('apps.mahasiswa')->with('error', $e->getMessage());
        }

    }
}
