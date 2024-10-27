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
                    session(['program_studi' => $psd]);
                } else {
                    session(['program_studi' => '-']);
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

if(!function_exists('grade')) {
    function grade($value) {
        $grade = 'E';

        if($value > 80) {
            $grade = 'A';
        } else if($value > 75) {
            $grade = 'AB';
        } else if($value > 65) {
            $grade = 'B';
        } else if($value > 60) {
            $grade = 'BC';
        } else if($value > 50) {
            $grade = 'C';
        } else if($value > 40) {
            $grade = 'D';
        }

        return $grade;
    }
}