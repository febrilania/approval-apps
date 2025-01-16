<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ItemController extends Controller
{
    public function admin()
    {
        $items = Item::get();
        $categories = Category::all();

        return view('admin/item', compact('items', 'categories'));
    }
    public function sarpras()
    {
        $items = Item::get();
        $categories = Category::all();
        return view('sarpras/item', compact('items', 'categories'));
    }
    public function perencanaan()
    {
        $items = Item::get();
        $categories = Category::all();
        return view('perencanaan/item', compact('items', 'categories'));
    }
    public function pengadaan()
    {
        $items = Item::get();
        $categories = Category::all();
        return view('pengadaan/item', compact('items', 'categories'));
    }
    public function warek()
    {
        $items = Item::get();
        $categories = Category::all();
        return view('warek/item', compact('items', 'categories'));
    }
    public function user()
    {
        $items = Item::get();
        $categories = Category::all();
        return view('user/item', compact('items', 'categories'));
    }

    public function createItem()
    {
        $categories = Category::all();
        if (Auth::user()->role_id == 1) {
            return view('admin/createItem', compact('categories'));
        } elseif (Auth::user()->role_id == 2) {
            return view('user/createItem', compact('categories'));
        } elseif (Auth::user()->role_id == 3) {
            return view('sarpras/createItem', compact('categories'));
        } elseif (Auth::user()->role_id == 4) {
            return view('perencanaan/createItem', compact('categories'));
        } elseif (Auth::user()->role_id == 5) {
            return view('pengadaan/createItem', compact('categories'));
        } else {
            return view('wakilRektor2/createItem', compact('categories'));
        }
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'item_name' => 'required',
            'category_id' => 'required',
            'description' => 'required',
            'unit_price' => 'required',
            'image' => 'required|image|mimes:jpeg, jpg, png,|max:2048'
        ]);

        if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        $image = $request->file('image');
        $imagePath = $image->storeAs('public/items', $image->hashName());

        $data['item_name'] = $request->item_name;
        $data['category_id'] = $request->category_id;
        $data['description'] = $request->description;
        $data['unit_price'] = $request->unit_price;
        $data['image'] = $request->image->hashName();

        Item::create($data);

        if (Auth::user()->role_id == 1) {
            return redirect('admin/item')->with(['success' => 'Data berhasil ditambahkan']);
        } elseif (Auth::user()->role_id == 2) {
            return redirect('user/item')->with(['success' => 'Data berhasil ditambahkan']);
        } elseif (Auth::user()->role_id == 3) {
            return redirect('sarpras/item')->with(['success' => 'Data berhasil ditambahkan']);
        } elseif (Auth::user()->role_id == 4) {
            return redirect('perencanaan/item')->with(['success' => 'Data berhasil ditambahkan']);
        } elseif (Auth::user()->role_id == 5) {
            return redirect('pengadaan/item')->with(['success' => 'Data berhasil ditambahkan']);
        } else {
            return redirect('wakilRektor2/item')->with(['success' => 'Data berhasil ditambahkan']);
        }
    }

    public function destroy($id)
    {
        $item = Item::findOrFail($id);
        if ($item->image) {
            Storage::delete('public/items' . $item->image);
        }
        $item->delete();
        return redirect()->back()->with("success", "data berhasil dihapus");
    }

    public function detailItem($id)
    {
        $item = Item::findOrFail($id);
        $roleId = Auth::user()->role_id;
        if ($roleId === 1) {
            return view('admin/detailItem', compact('item'));
        } else if ($roleId === 2) {
            return view('user/detailItem', compact('item'));
        } else if ($roleId === 3) {
            return view('sarpras/detailItem', compact('item'));
        } else if ($roleId === 4) {
            return view('perencanaan/detailItem', compact('item'));
        } else if ($roleId === 5) {
            return view('pengadaan/detailItem', compact('item'));
        } else if ($roleId === 6) {
            return view('warek/detailItem', compact('item'));
        }
    }

    public function editItem(Request $request, $id)
    {
        // Temukan item berdasarkan ID
        $item = Item::findOrFail($id);

        // Validasi input
        $validatedData = $request->validate([
            'item_name' => 'required',
            'category_id' => 'required|integer',
            'description' => 'required',
            'unit_price' => 'required|numeric', // Pastikan unit_price adalah angka
            'image' => 'nullable|image|mimes:jpeg,jpg,png|max:2048' // Gambar tidak harus diisi
        ]);

        // Simpan data yang telah divalidasi ke model
        $item->item_name = $validatedData['item_name'];
        $item->category_id = $validatedData['category_id'];
        $item->description = $validatedData['description'];
        $item->unit_price = $validatedData['unit_price'];

        // Jika ada file gambar baru yang diunggah
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($item->image) {
                Storage::delete('public/items/' . $item->image);
            }

            // Upload gambar baru
            $image = $request->file('image');
            $imagePath = $image->storeAs('public/items', $image->hashName());
            $item->image = basename($imagePath); // Simpan nama file
        }

        // Simpan perubahan ke database
        $item->save();

        // Redirect kembali ke halaman admin/item dengan pesan sukses
        return redirect()->back()->with('success', 'Data item berhasil diubah');
    }
}
