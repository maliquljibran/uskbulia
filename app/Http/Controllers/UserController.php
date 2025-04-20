<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Dompet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function create()
    {
        return view('admin.add-user');
    }

    public function getUserInfo($id)
{
    $user = User::find($id);

    if (!$user) {
        return response()->json(['exists' => false]);
    }
    
    if ($user->role === 'admin' || $user->role === 'bank') {
        return response()->json(['exists' => false, 'message' => 'User role not allowed']);
    }

    $saldo = Dompet::where('user_id', $user->id)
        ->where('status', 'done')
        ->select(DB::raw('SUM(credit - debit) as saldo'))
        ->value('saldo') ?? 0;

    return response()->json([
        'exists' => true,
        'name' => $user->name,
        'role' => $user->role,
        'saldo' => $saldo
    ]);
}

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'role' => 'required|in:siswa,admin,bank',
        ]);

        
        if (Auth::user()->role === 'bank' && $request->role !== 'siswa') {
            return redirect()->back()->with('status', 'Bank hanya boleh menambahkan role siswa.');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        if ($user) {
            return redirect()->route('home')->with('status', "Menambahkan user berhasil");
        }

        return redirect()->back()->with('status', "Menambahkan user gagal");
    }

    public function edit(User $user)
    {
        return view("admin.edit-user", compact("user"));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|confirmed|min:6',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $updated = $user->update($data);

        if ($updated) {
            return redirect()->route('home')->with("status", "Update Berhasil");
        }

        return redirect()->back()->with("status", "Update gagal");
    }

    public function destroy(User $user)
    {
        $deleted = $user->delete();

        if ($deleted) {
            return redirect()->route('home')->with("status", "Hapus user berhasil");
        }

        return redirect()->back()->with("status", "Hapus user gagal");
    }
}
