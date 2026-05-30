<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
 public function index()
{
    $users = User::with('roles')->whereHas('roles', function($q) {
        $q->where('name', 'petugas');
    })->get();
    return view('admin.user.index', compact('users'));
}
    public function create()
    {
        $roles = Role::whereIn('name', ['admin', 'petugas'])->get();
        return view('admin.user.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role'     => 'required|in:admin,petugas',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($request->role);

        return redirect()->route('admin.user.index')->with('success', 'User berhasil ditambahkan!');
    }

    public function edit(User $user)
    {
        $roles = Role::whereIn('name', ['admin', 'petugas'])->get();
        return view('admin.user.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'role'     => 'required|in:admin,petugas',
            'password' => 'nullable|min:6|confirmed',
        ]);

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        $user->syncRoles($request->role);

        return redirect()->route('admin.user.index')->with('success', 'User berhasil diupdate!');
    }

    public function destroy(User $user)
    {
        if ($user->id == auth()->id()) {
            return redirect()->route('admin.user.index')->with('error', 'Tidak bisa menghapus akun sendiri!');
        }
        $user->delete();
        return redirect()->route('admin.user.index')->with('success', 'User berhasil dihapus!');
    }
    public function show(User $user)
{
    return view('admin.user.show', compact('user'));
}
public function resetPassword(Request $request, User $user)
{
    $request->validate([
        'new_password'              => 'required|min:6|confirmed',
        'new_password_confirmation' => 'required',
    ]);

    $user->update([
        'password' => Hash::make($request->new_password),
    ]);

    return redirect()->route('admin.user.show', $user)->with('success', 'Password berhasil direset!');
}
}