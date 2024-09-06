<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\User;
use App\Imports\MahasiswaImport;
use Maatwebsite\Excel\Facades\Excel;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('Mahasiswa.index', [
            "title" => "Mahasiswa",
            "breadcrumb1" => "Mahasiswa",
            "breadcrumb2" => "Index",
            'dataMhs'   => Mahasiswa::all(),
            'jsInit'      => 'js_mahasiswa.js',
        ]);
    }


    public function store(Request $request)
    {
        //
        try {

            $user = User::where('username', $request->nim)->first();

            if(isset($user->id)){
                return redirect()->route('admin.mahasiswa')->with('error', 'Username telah terpakai');
            }

            $mhsNew = User::create([
                'name' => $request->nama_mhs,
                'username' => $request->nim,
                // 'email' => $request->email,
                'password' => password_hash($request->nim, PASSWORD_DEFAULT),
                'picture' => 'default.jpg',
                'is_active' => 1
            ]);
            $mhsNew->assignRole('mahasiswa');

            $user = User::where('username', $request->nim)->first();
            // Potensi kode yang dapat menyebabkan pengecualian
            $result = Mahasiswa::create([
                'user_id' => $user->id,
                'kelas' => $request->kelas,
                'nim' => $request->nim,
                'nama_mhs' => $request->nama_mhs,
                'email' => $request->email,
                'jenis_kelamin' => $request->jenis_kelamin,
                'telp' => $request->telp,
            ]);
            return redirect()->route('admin.mahasiswa')->with('success', 'Data berhasil ditambahkan');
        } catch (\Exception $e) {

            // dd($e->getMessage());
            return redirect()->route('admin.mahasiswa')->with('error', $e->getMessage());
        }
    }

    public function show(string $id)
    {
        //
        $topik = Mahasiswa::find($id);

        echo json_encode($topik);
    }

    public function update(Request $request)
    {
        //
        try {
            // Potensi kode yang dapat menyebabkan pengecualian
            $mhs = Mahasiswa::find($request->id);

            User::where('username', $mhs->nim)->update([
                'name' => $request->nama_mhs,
                'username' => $request->nim,
                // 'email' => $request->email,
                'password' => password_hash($mhs->nim, PASSWORD_DEFAULT),
                'picture' => 'default.jpg',
            ]);

            $result = Mahasiswa::where('id', $request->id)->update([
                'kelas' => $request->kelas,
                'nim' => $request->nim,
                'nama_mhs' => $request->nama_mhs,
                'email' => $request->email,
                'jenis_kelamin' => $request->jenis_kelamin,
                'telp' => $request->telp,
            ]);
            return redirect()->route('admin.mahasiswa')->with('success', 'Data berhasil diupdate');
        } catch (\Exception $e) {

            dd($e->getMessage());
            return redirect()->route('admin.mahasiswa')->with('error', $e->getMessage());
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
            $dos = Mahasiswa::where('id', $id)->first();
            User::where('id', $dos->user_id)->delete();
            Mahasiswa::where('id', $id)->delete();

        } catch (\Exception $e) {

            dd($e->getMessage());
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
