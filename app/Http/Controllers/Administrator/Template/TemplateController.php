<?php

namespace App\Http\Controllers\Administrator\Template;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Template',
            // 'mods' => 'setting',
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => route('apps.dashboard')
                ],
                [
                    'title' => 'Pengaturan',
                    'is_active' => true
                ],
                [
                    'title' => 'Aplikasi',
                    'is_active' => true
                ],
            ],
            // 'data' => Setting::all(),
        ];
    }
    public function lembarPenilaian()
    {
        $data = [
            'title' => 'Cetak Lembar Penilaian',
        ];

        return view('administrator.template.lembar-penilaian');
    }
}
