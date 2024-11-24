<?php

namespace App\Http\Controllers\Administrator\Mahasiswa;

use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\PeriodeTa;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use App\Exports\MahasiswaExport;
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
    public function index(Request $request)
    {
        $mahasiswa = Mahasiswa::query();
        if ($request->has('program_studi') && !empty($request->program_studi) && $request->program_studi !== 'semua') {
            $mahasiswa->where('program_studi_id', $request->program_studi);
        }

        if ($request->has('periode') && !empty($request->periode) && $request->periode !== 'semua') {
            $mahasiswa->where('periode_ta_id', $request->periode);
        }
        $mahasiswa = $mahasiswa->get();

        $periode = PeriodeTa::query();
        if ($request->has('program_studi') && !empty($request->program_studi) && $request->program_studi !== 'semua') {
            $periode->where('program_studi_id', $request->program_studi);
        }
        $periode = $periode->get();
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
            'mhs' => $mahasiswa,
            'prodi' => ProgramStudi::all(),
            'periode' => $periode,
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
            $mhs = Mahasiswa::create($request->only(['kelas','email','nim','nama_mhs','program_studi_id','jenis_kelamin','telp', 'periode_ta_id']));
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
                    $existingUser->assignRole('Mahasiswa');
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
            $mahasiswa->update($request->only(['kelas','email','nim','nama_mhs','program_studi_id','jenis_kelamin','telp','periode_ta_id']));
            $user = $mahasiswa->user;
            $existingUser = User::where('username', $mahasiswa->nim)->where('id', '!=', $user->id)->first();
            if(is_null($existingUser)) {
                $request->merge(['username' => $mahasiswa->nim, 'name'=> $mahasiswa->nama_mhs, 'email' => $mahasiswa->email, 'password' => Hash::make($mahasiswa->nim)]);
                $mahasiswa->user->update($request->only(['name', 'username', 'email', 'password']));          
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
            return $this->successResponse('Data berhasil di hapus');    
        } catch (\Exception $e) {
            return $this->exceptionResponse($e);
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
            }            
            Excel::import(new MahasiswaImport, $file);
            
            return redirect()->route('apps.mahasiswa')->with('success', 'Berhasil import mahasiswa');
        } catch (\Exception $e) {
            return redirect()->route('apps.mahasiswa')->with('error', $e->getMessage());
        }
    }

   public function exportExcel() {
        return Excel::download(new MahasiswaExport, 'Data Mahasiswa.xlsx');
    }

}
