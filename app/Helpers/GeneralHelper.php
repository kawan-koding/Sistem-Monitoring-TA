<?php

use App\Models\Role;
use App\Models\Dosen;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;

if (!function_exists('getInfoLogin')) {
    function getInfoLogin()
    {
        return Auth::user();
    }
}

if (!function_exists('getAvailableRoles')) {
    function getAvailableRoles()
    {
        $user = Auth::user();
        $roles = $user->roles->pluck('name')->toArray();
        
        if($user) {
            if (in_array('Kaprodi', $roles)) {
                $dsn = Dosen::where('id', $user->userable_id)->first();
                if ($dsn && $dsn->programStudi) {
                    $psd = $dsn->programStudi->nama;
                    session(['program_studi' => $psd]); // Simpan program studi ke session
                } else {
                    session(['program_studi' => '-']); // Jika tidak ada, simpan '-' sebagai placeholder
                }
            }
        }

        return $roles;
    }
}

if (!function_exists('userHasRole')) {
    function userHasRole($role)
    {
        $availableRoles = getAvailableRoles();
        if (!in_array($role, $availableRoles)) {
            return false;
        }

        $userRoles = Auth::user()->roles->pluck('name')->toArray();
        return in_array($role, $userRoles);
    }
}


if (!function_exists('getSetting')) {
    function getSetting($key) {
        $q = Setting::where('key', $key)->first();
        return $q->value;
    }
}