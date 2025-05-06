<?php

namespace App\Http\Controllers\Administrator\Panduan;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PanduanController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Panduan',
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => route('apps.dashboard')
                ],
                [
                    'title' => 'Panduan',
                    'is_active' => true
                ]
            ],
            'guide' => Setting::where('key','app_guide')->first(),
        ];

        return view('administrator.panduan.index', $data);
    }
}
