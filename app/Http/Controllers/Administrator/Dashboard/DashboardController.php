<?php

namespace App\Http\Controllers\Administrator\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Dashboard',
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'is_active' => true
                ],
            ],
        ];

        return view('administrator.dashboard.index', $data);
    }
}
