<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $users = User::withCount('loans')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('role', 'LIKE', "%{$search}%");
            })->simplePaginate(10);

        return view('admin.users.index', compact('users', 'search'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|string|in:user,admin',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.user.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|string|in:user,admin',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        if ($request->filled('password')) {
            $request->validate([
                'current_password' => ['required'],
                'password' => 'string|min:8'
            ]);

            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Password lama tidak sesuai']);
            }

            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.user.index')->with('success', 'Pengguna berhasil diperbarui.');
    }


    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.user.index')->with('deleted', 'Pengguna berhasil dihapus.');
    }

    // Untuk User

    public function editProfile()
    {
        return view('user.profile-edit');
    }

    public function updateProfile(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|confirmed',
        ]);

        $user = Auth::user();

        // Update nama dan email
        $user->name = $request->name;
        $user->email = $request->email;

        // Jika password lama diisi, validasi dan update password
        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Password lama tidak sesuai']);
            }

            // Update password jika valid
            $user->password = Hash::make($request->new_password);
        }

        // Simpan perubahan
        $user->save();

        return redirect()->route('user.profile.edit')->with('success', 'Profil berhasil diperbarui.');
    }
}
