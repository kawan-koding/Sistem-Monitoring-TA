<?php

namespace App\Http\Controllers\Administrator\Profile;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProfileController extends Controller
{
    public function index()
    {
        // $user = Auth::user();
        
        // if($user->userable_type == Mahasiswa::class) {
        //     $profile = Mahasiswa::find($user->userable_id);
        //     // dd($profile);
        // } 

        // if($user->userable_type == Dosen::class) {
        //     $profile = Dosen::find($user->userable_id);
        // }

        $data = [
            'title' => 'Profile',
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => route('apps.dashboard')
                ],
                [
                    'title' => 'Profile',
                    'is_active' => true
                ]
            ],
            'profile' => Auth::user(),
        ];

        // dd(Auth::user());

        return view('administrator.profile.index', $data);
    }

    public function update(User $user, Request $request)
    {
        try {
            if($request->hasFile('fileImage')) {
                $file = $request->file('fileImage');
                $filename = 'Users_'. rand(0, 999999999) .'_'. rand(0, 999999999) .'.'. $file->getClientOriginalExtension();
                $file->move(public_path('storage/images/users'), $filename);
                if($user->image) {
                    File::delete(public_path('storage/images/users/'. $user->image));
                }
            } else {
                $filename = $user->image;
            }
            $user->image = $filename;

            if($user->hasRole('Mahasiswa')) {
                $jenisKelamin = [
                    'L' => 'Laki-laki',
                    'P' => 'Perempuan',
                ];
                $request->validate([
                    'name' => 'required',
                    'telp' => 'required',
                    'jenis_kelamin' => 'required',
                ],
                [
                    'name.required' => 'Nama harus diisi',
                    'telp.required' => 'Telp harus diisi',
                    'jenis_kelamin.required' => 'Jenis Kelamin harus diisi',
                ]);
                
                $user->name = $request->name;
                $user->userable->nama_mhs = $request->name;
                $user->userable->telp = $request->telp;
                $user->userable->jenis_kelamin = $jenisKelamin[$request->jenis_kelamin];
            } else if($user->hasRole(['Dosen', 'Admin', 'Kaprodi'])) {
                $request->validate([
                    'name' => 'required',
                    'telp' => 'required',
                    'jenis_kelamin' => 'required',
                    'file' => 'nullable|mimes:png,jpg,jpeg',
                ],
                [
                    'name.required' => 'Nama harus diisi',
                    'telp.required' => 'Telp harus diisi',
                    'jenis_kelamin.required' => 'Jenis Kelamin harus diisi',
                    'file.mimes' => 'File harus berupa png, jpg, atau jpeg',
                ]);

                $user->name = $request->name;
                $user->userable->name = $request->name;
                $user->userable->telp = $request->telp;
                $user->userable->jenis_kelamin = $request->jenis_kelamin;
                if($request->hasFile('file')) {
                    $file = $request->file('file');
                    $filename = 'Dosen_'. rand(0, 999999999) .'_'. rand(0, 999999999) .'.'. $file->getClientOriginalExtension();
                    $file->move(public_path('storage/images/dosen'), $filename);
                    if($user->userable->ttd) {
                        File::delete(public_path('storage/images/dosen/'. $user->userable->ttd));
                    }
                } else {
                    $filename = $user->userable->ttd;
                }
                $user->userable->ttd = $filename;
            }
            $user->save();
            $user->userable->save();

            return redirect()->route('apps.profile')->with('success', 'Data berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->route('apps.profile')->with('error', $e->getMessage());
        }
    }
}
