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
        $validated = Validator::make($request->all(), [
            'category_name' => 'required'
        ]);

        if ($validated->fails()) return redirect()->back()->withInput()->withErrors($validated);

        $data['category_name'] = $request->category_name;

        Category::create($data);

        return redirect('admin/category')->with(['success' => 'Berhasil menambahkan Kategori']);
    }

    public function deleteCategory($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect('admin/category')->with(['danger' => 'kategori berhasil dihapus']);
    }

    public function editCategory(Request $request, $id)
    {
        $validatedData = $request->validate([
            'category_name' => 'required'
        ]);
        $category = Category::findOrFail($id);
        $category->category_name = $validatedData['category_name'];

        $category->save();
        return redirect('admin/category')->with(['success' => 'Data berhasil diperbarui']);
    }
}
