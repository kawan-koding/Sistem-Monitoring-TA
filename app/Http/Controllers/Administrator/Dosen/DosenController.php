<?php

namespace App\Http\Controllers\Administrator\Dosen;

use App\Models\User;
use App\Models\Dosen;

use App\Models\Jurusan;
use App\Exports\DosenExport;
use App\Imports\DosenImport;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\Dosen\DosenRequest;

class DosenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'title' => 'Dosen',
            'mods' => 'dosen',
            'breadscrumb' => [
                [
                    'title' => 'Dashboard',
                    'url' => route('apps.dashboard')
                ],
                [
                    'title' => 'Master Data',
                    'is_active' => true
                ],
                [
                    'title' => 'Dosen',
                    'is_active' => true
                ],
            ],
            'dataDosen' => Dosen::with(['programStudi', 'user'])->get(),
            'jurusan' => Jurusan::all(),
            'studyPrograms' => ProgramStudi::all(),
        ];
        // dd(Jurusan::all());
        
        return view('administrator.dosen.index', $data);
    }
    
    public function store(DosenRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = User::where('username', $request->nidn)->first();
            if(isset($user->id)){
                return redirect()->route('apps.dosen')->with('error', 'Username telah terpakai');
            }
            if($request->hasFile('file')) {
                $file = $request->file('file');
                $filename = 'Dosen_'. rand(0, 999999999) .'_'. rand(0, 999999999) .'.'. $file->getClientOriginalExtension();
                $file->move(public_path('storage/images/dosen'), $filename);
            } else {
                $filename = null;
            }

            $request->merge(['ttd' => $filename]);
            $dosen = Dosen::create($request->only(['nip', 'nidn', 'name', 'email', 'jenis_kelamin', 'telp', 'ttd', 'program_studi_id', 'bidang_keahlian', 'alamat']));
            $existingUser = User::where('username', $dosen->nidn)->orWhere('email', $dosen->email)->first();
            if(!$existingUser) {
                $dsnNew = User::create([
                    'name' => $request->name,
                    'username' => $request->nidn,
                    'email' => $request->email,
                    'password' => Hash::make($request->nidn),
                    'image' => 'default.jpg',
                    'is_active' => 1,
                    'userable_type' => Dosen::class,
                    'userable_id' => $dosen->id
                ]);
                $dsnNew->assignRole('Dosen');
            } else {
                if(is_null($existingUser->userable_id) && is_null($existingUser->userable_type)) {
                    $existingUser->update([
                        'userable_id' => $dosen->id,
                        'userable_type' => Dosen::class,
                    ]);
                }
            }
            DB::commit();
            return redirect()->route('apps.dosen')->with('success', 'Data berhasil ditambahkan');
        } catch(\Exception $e) {
            return redirect()->route('apps.dosen')->with('error', $e->getMessage());
        }
    }

    public function show(Dosen $dosen)
    {
        return response()->json($dosen);
        // $topik = Dosen::find($id);

        // echo json_encode($topik);
    }

    public function update(DosenRequest $request, Dosen $dosen)
    {
        //
        try {
            if($request->hasFile('file')) {
                $file = $request->file('file');
                $filename = 'Dosen_'. rand(0, 999999999) .'_'. rand(0, 999999999) .'.'. $file->getClientOriginalExtension();
                $file->move(public_path('storage/images/dosen'), $filename);
                if($dosen->ttd) {
                    File::delete(public_path('storage/images/dosen/'. $dosen->ttd));
                }
            } else {
                $filename = $dosen->ttd;
            }

            $request->merge(['ttd' => $filename]);
            $oldEmail = $dosen->email;
            $dosen->update($request->only(['nip', 'nidn', 'name', 'email', 'jenis_kelamin', 'telp', 'ttd', 'bidang_keahlian', 'program_studi_id','alamat']));
            $user = $dosen->user;
            $existingUser = User::where('username', $dosen->nidn)->where('id', '!=', $user->id)->first();
            if(is_null($existingUser)) {
                $request->merge(['username' => $dosen->nidn, 'password' => Hash::make($dosen->nidn)]);
                $dosen->user->update($request->only(['name', 'username', 'email', 'password']));
            }
            return redirect()->route('apps.dosen')->with('success', 'Data berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->route('apps.dosen')->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dosen $dosen)
    {
        //
        try {
            $dosen->user()->delete();
            $dosen->delete();

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
                // $filename = 'Dosen_'. rand(0, 999999999) .'_'. rand(0, 999999999) .'.'. $file->getClientOriginalExtension();
                // $file->move(public_path('storage/files/dosen'), $filename);
            }
            
            // Excel::import(new DosenImport, public_path('storage/files/dosen/'. $filename));
            Excel::import(new DosenImport, $file);
            
            return redirect()->route('apps.dosen')->with('success', 'Berhasil import dosen');
        } catch (\Exception $e) {
            return redirect()->route('apps.dosen')->with('error', $e->getMessage());
        }
    }

    public function exportExcel() {
        return Excel::download(new DosenExport, 'Data Dosen.xlsx');
    }
    
    // public function tarikData(){
    //     try{
    //         //dd($response);
    //         $token = env("KEY_BEARER_TOKEN");
    //         if (!isset($token)) {
    //             return redirect()->route('apps.dosen')->with('error', 'Set token bearer terlebih dahulu');
    //         }
            
    //         $response = Http::withoutVerifying()
    //         ->withHeaders([
    //             'Accept' => 'application/json',
    //             'Authorization' => 'Bearer ' . env('KEY_BEARER_TOKEN'),
    //         ])
    //         ->get('https://sit.poliwangi.ac.id/v2/api/v1/sitapi/pegawai', [
    //             'prodi' => 4,
    //         ]);
    //         $data = $response->json()['data']; 
    //         // dd($data);
    //         foreach ($data as $key) {
                
    //             $cek_user = User::where('username', $key['username'])->first();
    //             if(!isset($cek_user->id) && isset($key['username'])){
    //                 $dsnNew = User::create([
    //                     'name' => $key['nama'],
    //                     'username' => $key['username'],
    //                     // 'email' => $request->email,
    //                     'password' => password_hash($key['username'], PASSWORD_DEFAULT),
    //                     'picture' => 'default.jpg',
    //                     'is_active' => 1,
    //                 ]);
    //                 $dsnNew->assignRole('dosen');
    //                 $user = User::where('username', $key['username'])->first();
    //                 // Potensi kode yang dapat menyebabkan pengecualian
    //                 $result = Dosen::create([
    //                     'user_id' => $user->id,
    //                     'nip' => $key['nip'],
    //                     'nidn' => $key['nip'],
    //                     'name' => $key['nama'],
    //                     'email' => null,
    //                     'jenis_kelamin' => $key['jenis_kelamin'],
    //                     'telp' => '081',
    //                     'ttd' => null,
    //                 ]);
    //             }
    //         }

    //         return redirect()->route('apps.dosen')->with('success', 'Data berhasil ditarik!');
    //     }catch(\Exception $e){
    //         return redirect()->route('apps.dosen')->with('error', $e->getMessage());
    //     }
    // }
}
