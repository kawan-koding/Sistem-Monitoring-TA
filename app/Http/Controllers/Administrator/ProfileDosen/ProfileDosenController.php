<?php

namespace App\Http\Controllers\Administrator\ProfileDosen;

use App\Models\Dosen;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileDosenController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Profile Dosen',
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => route('apps.dashboard')    
                ],
                [
                    'title' => 'Profile Dosen',
                    'is_active' => true
                ],
            ],
            'data' => Dosen::all(),
        ];

        return view('administrator.profile-dosen.index', $data);
    }
}
