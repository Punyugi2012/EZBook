<?php

namespace App\Http\Controllers\web\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function onLogin() {
        return view('web.admin.adminLogin');
    }
    public function onDashboard() {
        return view('web.admin.adminDashboard');
    }
}
