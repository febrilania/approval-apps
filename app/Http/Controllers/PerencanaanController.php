<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PerencanaanController extends Controller
{
    public function index()
    {
        return view('perencanaan/dashboard');
    }
}
