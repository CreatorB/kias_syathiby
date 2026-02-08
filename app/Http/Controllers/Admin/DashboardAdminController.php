<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardAdminController extends Controller
{
    public function index() {
        $data = [
            'title' => 'Dashboard Admin PSB',
        ];

        return view('admin.dashboard', $data);
    }
}
