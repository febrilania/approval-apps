<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PengadaanController extends Controller
{
    public function index()
    {
        return view('pengadaan/dashboard');
    }
}
