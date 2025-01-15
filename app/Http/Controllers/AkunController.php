<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AkunAnggaran;
use Illuminate\Support\Facades\Auth;

class AkunController extends Controller
{
    public function index()
    {
        $akun = AkunAnggaran::all();
        $roleId = Auth::user()->role_id;
        if ($roleId === 1) {
            return view('admin.akun', compact('akun'));
        } else if ($roleId === 2) {
            return view('user.akun', compact('akun'));
        } else if ($roleId === 3) {
            return view('sarpras.akun', compact('akun'));
        } else if ($roleId === 4) {
            return view('perencanaan.akun', compact('akun'));
        } else if ($roleId === 5) {
            return view('pengadaan.akun', compact('akun'));
        } else if ($roleId === 6) {
            return view('warek.akun', compact('akun'));
        }
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
