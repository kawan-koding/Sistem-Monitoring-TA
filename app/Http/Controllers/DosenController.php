<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dosen;
use App\Models\User;
use App\Imports\DosenImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Http;

class DosenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('dosen.index', [
            "title" => "Dosen",
            "breadcrumb1" => "Dosen",
            "breadcrumb2" => "Index",
            'dataDosen'   => Dosen::all(),
            'jsInit'      => 'js_dosen.js',
        ]);
    }


    public function store(Request $request)
    {
        //
        try {

            $user = User::where('username', $request->nidn)->first();

            if(isset($user->id)){
                return redirect()->route('admin.dosen')->with('error', 'Username telah terpakai');
            }

            $ttd = null;

            if(isset($request->ttd)){
                $ttd = $request->ttd->getClientOriginalName() . '-' . time() . '.' . $request->ttd->extension();
                $request->ttd->move(public_path('images'), $ttd);
                // dd($ttd);
            }

            $dsnNew = User::create([
                'name' => $request->name,
                'username' => $request->nidn,
                // 'email' => $request->email,
                'password' => password_hash($request->nidn, PASSWORD_DEFAULT),
                'picture' => 'default.jpg',
                'is_active' => 1,
            ]);
            $dsnNew->assignRole('dosen');
            
            $user = User::where('username', $request->nidn)->first();
            // Potensi kode yang dapat menyebabkan pengecualian
            $result = Dosen::create([
                'user_id' => $user->id,
                'nip' => $request->nip,
                'nidn' => $request->nidn,
                'name' => $request->name,
                'email' => $request->email,
                'jenis_kelamin' => $request->jenis_kelamin,
                'telp' => $request->telp,
                'ttd' => $ttd,
            ]);
            return redirect()->route('admin.dosen')->with('success', 'Data berhasil ditambahkan');
        } catch (\Exception $e) {

            //
            return redirect()->route('admin.dosen')->with('error', $e->getMessage());
        }
    }

    public function show(string $id)
    {
        //
        $topik = Dosen::find($id);

        echo json_encode($topik);
    }

    public function update(Request $request)
    {
        //
        try {
            // Potensi kode yang dapat menyebabkan pengecualian
            $dosen = Dosen::find($request->id);
            $ttd = $dosen->ttd;

            if(isset($request->ttd)){
                $ttd = $request->ttd->getClientOriginalName() . '-' . time() . '.' . $request->ttd->extension();
                $request->ttd->move(public_path('images'), $ttd);
                // dd(1);
            }
            User::where('username', $dosen->nidn)->update([
                'name' => $request->name,
                'username' => $request->nidn,
                'password' => password_hash($request->nidn, PASSWORD_DEFAULT),
                'picture' => 'default.jpg',
            ]);

            $result = Dosen::where('id', $request->id)->update([
                // 'user_id' => $user->id,
                'nip' => $request->nip,
                'nidn' => $request->nidn,
                'name' => $request->name,
                'email' => $request->email,
                'jenis_kelamin' => $request->jenis_kelamin,
                'telp' => $request->telp,
                'ttd' => $ttd,
            ]);
            return redirect()->route('admin.dosen')->with('success', 'Data berhasil diupdate');
        } catch (\Exception $e) {


            return redirect()->route('admin.dosen')->with('error', $e->getMessage());
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
            $dos = Dosen::where('id', $id)->first();
            User::where('username', $dos->nidn)->delete();
            Dosen::where('id', $id)->delete();

        } catch (\Exception $e) {


            return redirect()->route('admin.dosen')->with('error', $e->getMessage());
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
            $file->move('file_dosen',$nama_file);

            // import data
            Excel::import(new DosenImport, public_path('file_dosen/'.$nama_file));

            return redirect()->route('admin.dosen')->with('success', 'Berhasil melakukan import');

        } catch (\Exception $e) {
            return redirect()->route('admin.dosen')->with('error', $e->getMessage());
        }
    }
    
    public function tarikData(){
        try{
            //dd($response);
            $token = env("KEY_BEARER_TOKEN");
            if (!isset($token)) {
                return redirect()->route('admin.dosen')->with('error', 'Set token bearer terlebih dahulu');
            }
            
            $response = Http::withoutVerifying()
            ->withHeaders([
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . env('KEY_BEARER_TOKEN'),
            ])
            ->get('https://sit.poliwangi.ac.id/v2/api/v1/sitapi/pegawai', [
                'prodi' => 4,
            ]);
            $data = $response->json()['data']; 
            // dd($data);
            foreach ($data as $key) {
                
                $cek_user = User::where('username', $key['username'])->first();
                if(!isset($cek_user->id) && isset($key['username'])){
                    $dsnNew = User::create([
                        'name' => $key['nama'],
                        'username' => $key['username'],
                        // 'email' => $request->email,
                        'password' => password_hash($key['username'], PASSWORD_DEFAULT),
                        'picture' => 'default.jpg',
                        'is_active' => 1,
                    ]);
                    $dsnNew->assignRole('dosen');
                    $user = User::where('username', $key['username'])->first();
                    // Potensi kode yang dapat menyebabkan pengecualian
                    $result = Dosen::create([
                        'user_id' => $user->id,
                        'nip' => $key['nip'],
                        'nidn' => $key['nip'],
                        'name' => $key['nama'],
                        'email' => null,
                        'jenis_kelamin' => $key['jenis_kelamin'],
                        'telp' => '081',
                        'ttd' => null,
                    ]);
                }
            }

            return redirect()->route('admin.dosen')->with('success', 'Data berhasil ditarik!');
        }catch(\Exception $e){
            return redirect()->route('admin.dosen')->with('error', $e->getMessage());
        }
    }
}
