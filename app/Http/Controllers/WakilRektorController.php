<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WakilRektorController extends Controller
{
    public function index()
    {
        return view('warek/dashboard');
    }
}
