<?php

namespace App\Http\Controllers;

use App\Models\PurchaseRequest;
use Illuminate\Http\Request;

class SarprasController extends Controller
{
    public function index()
    {
        return view('sarpras/dashboard');
    }

    public function purchaseRequest()
    {
        $requestor_id = PurchaseRequest::with('user')->get();
        $request = PurchaseRequest::all();
        return view('sarpras/request', compact('request', 'requestor_id'));
    }
}
