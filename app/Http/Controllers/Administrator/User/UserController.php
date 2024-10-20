<?php

namespace App\Http\Controllers\Administrator\User;

use File;
use App\Models\Role;
use App\Models\User;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\User\UserRequest;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with(['roles'])->whereHas('roles', function($q) {
            $q->whereNotIn('name', ['Developer']);
        })->get();
        $roles = Role::whereNotIn('name', ['Developer'])->get();
        
        $data = [
            'title' => 'Pengguna',
            'mods' => 'user',
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => route('apps.dashboard'),
                ],
                [
                    'title' => 'Pengguna',
                    'is_active' => true
                ],
            ],
            'users' => $users,
            'roles' => $roles,
        ];

        return view('administrator.user.index', $data);
    }

    public function store(UserRequest $request)
    {
        try {
            if($request->hasFile('picture')) {
                $file = $request->file('picture');
                $filename = 'Users_'. rand(0, 999999999) .'_'. rand(0, 999999999) .'.'. $file->getClientOriginalExtension();
                $file->move(public_path('storage/images/users'), $filename);
            } else {
                $filename = 'default.jpg';
            }

            $request->merge(['password' => Hash::make($request->password), 'image' => $filename]);
            $user = User::create($request->only('name', 'username', 'email', 'password', 'image'));
            $user->assignRole($request->roles);

            return redirect()->route('apps.users')->with('success', 'Data berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->route('apps.users')->with('error', $e->getMessage());
        }
    }

    public function show(User $user)
    {
        $remappedUser = clone $user;
        $remappedUser->roles = $user->roles->map(function($item) {
            return $item->name;
        });
        return response()->json($remappedUser);
    }

    public function update(UserRequest $request, User $user)
    {
        try {
            if($request->hasFile('picture')) {
                $file = $request->file('picture');
                $filename = 'Users_'. rand(0, 999999999) .'_'. rand(0, 999999999) .'.'. $file->getClientOriginalExtension();
                $file->move(public_path('storage/images/users'), $filename);
                if($user->image !== 'default.png') {
                    File::delete(public_path('storage/images/users/'. $user->image));
                }
            } else {
                $filename = $user->image;
            }

            $request->merge(['image' => $filename]);
            if ($request->filled('password')) {
                $request->merge(['password' => Hash::make($request->password)]);
                $user->update($request->only(['name', 'username', 'email', 'image', 'password']));
            } else {
                $user->update($request->only(['name', 'username', 'email', 'image']));
            }
            $user->syncRoles($request->roles);
            $mahasiswa = $user->userable;
            $mahasiswa->update(['nama_mhs' => $user->name,'email' => $user->email,'nim' => $user->username]);
            
            return redirect()->route('apps.users')->with('success', 'Data berhasil diupdate');
        } catch (\Exception $e) {
            return redirect()->route('apps.users')->with('error', $e->getMessage());
        }
    }

    public function destroy(User $user)
    {
        try {
            if ($user->userable_type === Mahasiswa::class) {
                $mahasiswa = $user->userable;
                $mahasiswa->delete();
            }
            $user->delete();
            return $this->successResponse('Data berhasil di hapus');
        } catch (\Exception $e) {
            return $this->exceptionResponse($e);
        }
    }
}
