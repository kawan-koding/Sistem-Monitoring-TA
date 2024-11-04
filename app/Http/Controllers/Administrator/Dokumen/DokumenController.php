<?php

namespace App\Http\Controllers\Administrator\Dokumen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DokumenController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Dokumen Pemberkasan',
        ];
    }
}
