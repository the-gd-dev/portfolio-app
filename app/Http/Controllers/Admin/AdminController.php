<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $data['title'] = 'Dashboard - Admin';
        return view('admin.dashboard',$data);
    }
}
