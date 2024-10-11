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
        if (in_array('Kaprodi', $roles)) {
            $dsn = Dosen::where('id', $user->userable_id)->first();
            dd($dsn);
            $programStudiId = $user->program_studi_id;
            session(['programStudiId' => $programStudiId]);
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