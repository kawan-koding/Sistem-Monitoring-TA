<?php

use App\Models\Role;
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
        return Role::pluck('name')->toArray();
    }
}

if (!function_exists('userHasRole')) {
    function userHasRole($role)
    {
        $availableRoles = getAvailableRoles();
        if (!in_array($role, $availableRoles)) {return false;}
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