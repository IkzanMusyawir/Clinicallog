<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function destroy(User $user)
    {
        if ($user->is_admin) {
            return request()->ajax() || request()->wantsJson()
                ? response()->json(['success' => false, 'message' => 'Admin tidak bisa dihapus.'], 403)
                : redirect()->route('admin.users.index')->with('error', 'Admin tidak bisa dihapus.');
        }
        $user->delete();
        return request()->ajax() || request()->wantsJson()
            ? response()->json(['success' => true, 'message' => 'Pengguna berhasil dihapus.'])
            : redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
