<?php

namespace App\Http\Controllers\Administrator\JenisDokumen;

use App\Models\JenisDokumen;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JenisDokumenController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Jenis Dokumen',
            'mods' => 'jenis_dokumen',
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => route('apps.dashboard')
                ],
                [
                    'title' => 'Master Data',
                    'is_active' => true
                ],
                [
                    'title' => 'Jenis Dokumen',
                    'is_active' => true
                ]
            ],
            'data' => JenisDokumen::all(),
        ];

        return view('administrator.jenis-dokumen.index', $data);
    }
}
