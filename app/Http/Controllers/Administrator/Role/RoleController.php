<?php

namespace App\Http\Controllers\Administrator\Role;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    public function index()
    {
          $data = [
            'title' => 'Role',
            'roles' => Role::whereNotIn('name', ['Developer'])->get(),
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => route('apps.dashboard')
                ],
                [
                    'title' => 'Manajemen Pengguna',
                    'is_active' => true
                ],
                [
                    'title' => 'Role',
                    'is_active' => true
                ]
            ],   
        ];

        return view('administrator.role.index', $data);
    }

    public function change(Role $role)
    {
        $remappedPermission = [];
        $permissions = Permission::all();
        foreach ($permissions as $permission) {
            $explodePermissions = \explode('-', $permission->name);
            $slicePermissions = array_slice($explodePermissions, 1);
            $implodePermissions = \implode('-', $slicePermissions);
            // $permission['is_checked'] = $role->hasPermissionTo($permission->name);
            if ($role->permissions->contains('name', $permission->name)) {
                $permission['is_checked'] = true;
            } else {
                $permission['is_checked'] = false;
            }

            $remappedPermission[$implodePermissions][] = $permission;
        }

        $data = [
            'title' => "Ubah Hak Akses $role->name",
            'mods' => 'role',
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => route('apps.dashboard'),
                ],
                [
                    'title' => 'Manajemen Pengguna',
                    'is_active' => true
                ],
                [
                    'title' => 'Role',
                    'url' => route('apps.roles')
                ],
                [
                    'title' => 'Change Permission',
                    'is_active' => true
                ]
            ],
            'permissions' => $remappedPermission,
            'role' => $role
        ];

        return view('administrator.role.change', $data);
    }

    public function changePermissions(Request $request, Role $role)
    {
        try {
            $role->syncPermissions($request->permission);
            return redirect()->route('apps.roles')->with('success', 'Hak Akses Berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->route('apps.roles')->with('error', $e->getMessage());
        }
    }
}
