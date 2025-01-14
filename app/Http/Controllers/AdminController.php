<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\PurchaseRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\returnSelf;

class AdminController extends Controller
{
    public function index()
    {
        $usersCount = User::count();
        $requestCount = PurchaseRequest::count();
        $itemCount = Item::count();
        return view('admin/dashboard', compact('usersCount', 'requestCount', 'itemCount'));
    }

    public function user()
    {
        $users =  User::with('role')->get();
        return view('admin/user', compact('users'));
    }

    public function destroy()
    {
        $users = User::findOrFail();
        if ($users->profile_picture) {
            Storage::delete('public/users' . $users->profile_picture);
        }
        $users->delete();

        return redirect('admin/user')->with(['success' => 'data berhasil berhapus']);
    }

    public function registerUser()
    {
        return view('admin/addUSer');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'username' => 'required',
            'password' => 'required',
            'profile_picture' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'role_id' => 'required',
        ]);

        if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        $profile_picture = $request->file('profile_picture');
        $profile_picturePath = $profile_picture->storeAs('public/items', $profile_picture->hashName());

        $data['name'] = $request->name;
        $data['username'] = $request->username;
        $data['password'] = Hash::make($request->password);
        $data['profile_picture'] = $request->profile_picture->hashName();
        $data['role_id'] = $request->role_id;

        User::create($data);

        return redirect('admin/user')->with(['succes' => 'data berhasil ditambah']);
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin/editUser', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'password' => 'nullable',
            'profile_picture' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'role_id' => 'required|integer|exists:roles,id',
        ]);
        $user = User::findOrFail($id);
        $user->name = $validatedData['name'];
        $user->username = $validatedData['username'];

        if ($request->filled('password')) {
            $user->password = Hash::make($validatedData['password']);
        }

        if ($request->hasFile('profile_picture')) {
            // Hapus gambar profil lama jika ada
            if ($user->profile_picture) {
                Storage::delete('public/items/' . $user->profile_picture);
            }
            $profile_picture = $request->file('profile_picture');
            $profile_picturePath = $profile_picture->storeAs('public/items', $profile_picture->hashName());
            $user->profile_picture = basename($profile_picturePath); // Simpan nama file
        }
        $user->role_id = $validatedData['role_id'];
        $user->save();
        return redirect()->route('user')->with('success', 'Data berhasil diperbarui');
    }
}
