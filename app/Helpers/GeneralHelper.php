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

if(!function_exists('toRoman')) {
    function toRoman($num) {
        $romanNumerals = [
            1000 => 'M',
            900 => 'CM',
            500 => 'D',
            400 => 'CD',
            100 => 'C',
            90 => 'XC',
            50 => 'L',
            40 => 'XL',
            10 => 'X',
            9 => 'IX',
            5 => 'V',
            4 => 'IV',
            1 => 'I',
        ];
    
        $result = '';
        
        foreach ($romanNumerals as $value => $symbol) {
            while ($num >= $value) {
                $result .= $symbol;
                $num -= $value;
            }
        }
        
        return $result;
    }
}
