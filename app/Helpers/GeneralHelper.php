<?php

use App\Models\Role;
use Illuminate\Support\Facades\Auth;

if (!function_exists('getInfoLogin')) {
    function getInfoLogin()
    {
        return Auth::user();
    }
}

function getAvailableRoles()
{
    return Role::pluck('name')->toArray();
}

function userHasRole($role)
{
    $availableRoles = getAvailableRoles();
    if (!in_array($role, $availableRoles)) {return false;}
    $userRoles = Auth::user()->roles->pluck('name')->toArray();
    return in_array($role, $userRoles);
}
