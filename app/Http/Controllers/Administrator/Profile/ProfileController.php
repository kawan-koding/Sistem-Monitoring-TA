<?php

namespace App\Http\Controllers\Administrator\Profile;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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
                    'urel' => route('apps.dashboard')
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

    public function update()
    {
        // try {
        //     $user = Auth::user();
            
        //     $user->update($request->only(['nama']))
        // }
    }
}
