<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class AuthController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ], [
            'username' => 'username nya diisi dulu',
            'password' => 'passwordnya juga'
        ]);
        if (Auth::attempt($credentials)) {
            if (Auth::user()->role_id == 1) {
                return redirect('admin/dashboard');
            } elseif (Auth::user()->role_id == 2) {
                return redirect('user/dashboard');
            } elseif (Auth::user()->role_id == 3) {
                return redirect('sarpras/dashboard');
            } elseif (Auth::user()->role_id == 4) {
                return redirect('perencanaan/dashboard');
            } elseif (Auth::user()->role_id == 5) {
                return redirect('pengadaan/dashboard');
            } else {
                return redirect('wakilRektor2/dashboard');
            }
        }
        return back()->withErrors([
            'loginError' => 'The provided credentials do not match our records.'
        ])->onlyInput('username');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('');
    }

    public function editProfile()
    {
        $user =  Auth::user();
        if ($user->role_id === 1) {
            return view('admin/editProfile', compact('user'));
        } else if ($user->role_id === 2) {
            return view('user/editProfile', compact('user'));
        } else if ($user->role_id === 3) {
            return view('sarpras/editProfile', compact('user'));
        } else if ($user->role_id === 4) {
            return view('perencanaan/editProfile', compact('user'));
        } else if ($user->role_id === 5) {
            return view('pengadaan/editProfile', compact('user'));
        } else if ($user->role_id === 6) {
            return view('warek/editProfile', compact('user'));
        }
    }

    public function updateProfile(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . Auth::id(),
            'password' => 'nullable',
            'profile_picture' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'role_id' => 'required|integer|exists:roles,id',
        ]);

        $user = Auth::user();
        if (!$user instanceof User) {
            return redirect()->back()->with('error', 'User not found.');
        }


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


        $user->name = $validatedData['name'];
        $user->username = $validatedData['username'];


        if (!empty($validatedData['password'])) {
            $user->password = Hash::make($validatedData['password']);
        }

        $user->role_id = $validatedData['role_id'];

        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    public function profile()
    {
        $user = Auth::user();
        if ($user->role_id === 1) {
            return view('admin/profile', compact('user'));
        } else if ($user->role_id === 2) {
            return view('user/profile', compact('user'));
        } else if ($user->role_id === 3) {
            return view('sarpras/profile', compact('user'));
        } else if ($user->role_id === 4) {
            return view('perencanaan/profile', compact('user'));
        } else if ($user->role_id === 5) {
            return view('pengadaan/profile', compact('user'));
        } else if ($user->role_id === 6) {
            return view('warek/profile', compact('user'));
        }
    }
}
