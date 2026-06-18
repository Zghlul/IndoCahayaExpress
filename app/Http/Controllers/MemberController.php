<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class MemberController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('dev'); // hanya dev yang boleh akses
    }

    /**
     * Daftar member dengan filter dan pencarian.
     */
    public function index(Request $request)
    {
        $search = $request->get('q', '');
        $filter_role = $request->get('role', '');

        $query = User::query();
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }
        if ($filter_role) {
            $query->where('role', $filter_role);
        }

        $users = $query->orderBy('id', 'desc')->paginate(15);
        $users->appends($request->query());

        $stats = [
            'total'       => User::count(),
            'admins'      => User::where('role', 'admin')->count(),
            'devs'        => User::where('role', 'dev')->count(),
            'users_count' => User::where('role', 'user')->count(),
        ];

        $editUser = null;
        $showForm = false;
        if ($request->has('edit')) {
            $editUser = User::find($request->edit);
            if ($editUser) $showForm = true;
        }
        if ($request->get('action') === 'add') {
            $showForm = true;
        }

        return view('d-e-v.members', compact('users', 'stats', 'editUser', 'showForm'));
    }

    /**
     * Simpan member baru atau update existing.
     */
    public function save(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $request->edit_id,
            'password' => $request->edit_id ? 'nullable|min:6' : 'required|min:6',
            'role'     => 'required|in:user,admin,dev,owner',
        ]);

        if ($request->edit_id) {
            $user = User::findOrFail($request->edit_id);
            $user->name  = $request->name;
            $user->email = $request->email;
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
            $user->role = $request->role;
            $user->save();
            return redirect()->route('d-e-v.members')->with('flash_members', 'Member berhasil diupdate!');
        } else {
            User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role'     => $request->role,
            ]);
            return redirect()->route('d-e-v.members')->with('flash_members', 'Member baru berhasil ditambahkan!');
        }
    }

    /**
     * Hapus member (tidak bisa hapus diri sendiri).
     */
    public function delete($id)
    {
        if ($id == auth()->id()) {
            return redirect()->route('d-e-v.members')->with('flash_members_err', 'Tidak dapat menghapus akun sendiri.');
        }
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('d-e-v.members')->with('flash_members', 'Member berhasil dihapus.');
    }

    /**
     * Hapus banyak member sekaligus.
     */
    public function bulkDelete(Request $request)
    {
        $ids = $request->input('selected_ids', []);
        $myId = auth()->id();
        $ids = array_filter($ids, fn($id) => $id != $myId);
        if (!empty($ids)) {
            User::whereIn('id', $ids)->delete();
            return redirect()->route('d-e-v.members')->with('flash_members', count($ids) . ' member berhasil dihapus.');
        }
        return redirect()->route('d-e-v.members')->with('flash_members_err', 'Tidak ada data dipilih atau tidak bisa hapus sendiri.');
    }

    /**
     * Redirect ke halaman index dengan parameter edit (digunakan dari link edit).
     */
    public function edit($id)
    {
        return redirect()->route('d-e-v.members', ['edit' => $id]);
    }
}