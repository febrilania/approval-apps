<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::get();
        if (Auth::user()->role_id === 1) {
            return view('admin/category', compact('categories'));
        } else if (Auth::user()->role_id === 2) {
            return view('user/category', compact('categories'));
        } else if (Auth::user()->role_id === 3) {
            return view('sarpras/category', compact('categories'));
        } else if (Auth::user()->role_id === 4) {
            return view('perencanaan/category', compact('categories'));
        } else if (Auth::user()->role_id === 5) {
            return view('pengadaan/category', compact('categories'));
        } else if (Auth::user()->role_id === 6) {
            return view('warek/category', compact('categories'));
        }
    }

    public function addCategory(Request $request)
    {
        $roleId = Auth::user()->role_id;
        $validated = Validator::make($request->all(), [
            'category_name' => 'required'
        ]);

        if ($validated->fails()) return redirect()->back()->withInput()->withErrors($validated);

        $data['category_name'] = $request->category_name;

        Category::create($data);
        if($roleId === 1) {
            return redirect('admin/category')->with(['success' => 'Berhasil menambahkan Kategori']);
        } else if($roleId === 2) {
            return redirect('user/category')->with(['success' => 'Berhasil menambahkan Kategori']);
        } else if($roleId === 3) {
            return redirect('sarpras/category')->with(['success' => 'Berhasil menambahkan Kategori']);
        } else if($roleId === 4) {
            return redirect('perencanaan/category')->with(['success' => 'Berhasil menambahkan Kategori']);
        } else if($roleId === 5) {
            return redirect('pengadaan/category')->with(['success' => 'Berhasil menambahkan Kategori']);
        } else if($roleId === 6) {
            return redirect('warek/category')->with(['success' => 'Berhasil menambahkan Kategori']);
        }
    }

    public function deleteCategory($id)
    {
        $roleId = Auth::user()->role_id;
        $category = Category::findOrFail($id);
        $category->delete();
        if($roleId === 1) {
            return redirect('admin/category')->with(['danger' => 'kategori berhasil dihapus']);
        } else if($roleId === 2) {
            return redirect('user/category')->with(['danger' => 'kategori berhasil dihapus']);
        } else if($roleId === 3) {
            return redirect('sarpras/category')->with(['danger' => 'kategori berhasil dihapus']);
        } else if($roleId === 4) {
            return redirect('perencanaan/category')->with(['danger' => 'kategori berhasil dihapus']);
        } else if($roleId === 5) {
            return redirect('pengadaan/category')->with(['danger' => 'kategori berhasil dihapus']);
        } else if($roleId === 6) {
            return redirect('warek/category')->with(['danger' => 'kategori berhasil dihapus']);
        }
    }

    public function editCategory(Request $request, $id)
    {
        $roleId = Auth::user()->role_id;
        $validatedData = $request->validate([
            'category_name' => 'required'
        ]);
        $category = Category::findOrFail($id);
        $category->category_name = $validatedData['category_name'];

        $category->save();

        if($roleId === 1) {
            return redirect('admin/category')->with(['success' => 'Data berhasil diperbarui']);
        } else if($roleId === 2) {
            return redirect('user/category')->with(['success' => 'Data berhasil diperbarui']);
        } else if($roleId === 3) {
            return redirect('sarpras/category')->with(['success' => 'Data berhasil diperbarui']);
        } else if($roleId === 4) {
            return redirect('perencanaan/category')->with(['success' => 'Data berhasil diperbarui']);
        } else if($roleId === 5) {
            return redirect('pengadaan/category')->with(['success' => 'Data berhasil diperbarui']);
        } else if($roleId === 6) {
            return redirect('warek/category')->with(['success' => 'Data berhasil diperbarui']);
        }
    }
}
