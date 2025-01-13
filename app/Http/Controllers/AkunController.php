<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AkunAnggaran;

class AkunController extends Controller
{
    public function index()
    {
        $akun = AkunAnggaran::all();
        return view('admin.akun', compact('akun'));
    }

    public function create(Request $request)
    {
        $validate = $request->validate([
            'nama_akun' => 'required'
        ]);

        $akun = AkunAnggaran::create([
            'nama_akun' => $validate['nama_akun'],
        ]);

        return redirect()->route('akun.index')->with(['success' => 'Data berhasil ditambahkan']);
    }

    public function edit($id)
    {
        $akun = AkunAnggaran::find($id);
        return view('akun.edit', compact('akun'));
    }

    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'nama_akun' => 'required'
        ]);

        $akun = AkunAnggaran::find($id);
        $akun->update([
            'nama_akun' => $validate['nama_akun'],
        ]);

        return redirect()->route('akun.index')->with(['success' => 'Data berhasil diubah']);
    }

    public function delete($id)
    {
        $akun = AkunAnggaran::find($id);
        $akun->delete();

        return redirect()->route('akun.index')->with(['success' => 'Data berhasil dihapus']);
    }
}
