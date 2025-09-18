<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (Auth::user()->role !== 'admin') {
                abort(403, 'Unauthorized');
            }

            return $next($request);
        });
    }

    public function index()
    {
        $users = User::with('classRoom')->where('role', '!=', 'admin')->get();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $classes = ClassRoom::all();

        return view('admin.users.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,guru,siswa,orang_tua',
            'nis' => 'nullable|string|max:20',
            'nisn' => 'nullable|string|max:20',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:L,P',
            'alamat' => 'nullable|string',
            'no_telepon' => 'nullable|string|max:20',
            'parent_name' => 'nullable|string|max:255',
            'orang_tua_telepon' => 'nullable|string|max:20',
            'class_id' => 'nullable|exists:classes,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama maksimal 255 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'role.required' => 'Role wajib dipilih.',
            'role.in' => 'Role harus admin, guru, siswa, atau orang tua.',
            'jenis_kelamin.in' => 'Jenis kelamin harus L atau P.',
            'class_id.exists' => 'Kelas yang dipilih tidak valid.',
            'photo.image' => 'File harus berupa gambar.',
            'photo.mimes' => 'Format gambar harus jpeg, png, atau jpg.',
            'photo.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'nis' => $request->nis,
            'nisn' => $request->nisn,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'telepon' => $request->no_telepon,
            'orang_tua_nama' => $request->parent_name,
            'orang_tua_telepon' => $request->orang_tua_telepon,
            'class_id' => $request->class_id,
            'status_aktif' => true,
        ];

        if ($request->hasFile('photo')) {
            $data['foto_path'] = $request->file('photo')->store('photos', 'public');
        }

        User::create($data);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan');
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $classes = ClassRoom::all();

        return view('admin.users.edit', compact('user', 'classes'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,guru,siswa,orang_tua',
            'nis' => 'nullable|string|max:20',
            'nisn' => 'nullable|string|max:20',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:L,P',
            'alamat' => 'nullable|string',
            'no_telepon' => 'nullable|string|max:20',
            'parent_name' => 'nullable|string|max:255',
            'orang_tua_telepon' => 'nullable|string|max:20',
            'class_id' => 'nullable|exists:classes,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status_aktif' => 'required|boolean',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama maksimal 255 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'role.required' => 'Role wajib dipilih.',
            'role.in' => 'Role harus admin, guru, siswa, atau orang tua.',
            'jenis_kelamin.in' => 'Jenis kelamin harus L atau P.',
            'class_id.exists' => 'Kelas yang dipilih tidak valid.',
            'photo.image' => 'File harus berupa gambar.',
            'photo.mimes' => 'Format gambar harus jpeg, png, atau jpg.',
            'photo.max' => 'Ukuran gambar maksimal 2MB.',
            'status_aktif.required' => 'Status wajib dipilih.',
            'status_aktif.boolean' => 'Status harus aktif atau tidak aktif.',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'nis' => $request->nis,
            'nisn' => $request->nisn,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'telepon' => $request->no_telepon,
            'orang_tua_nama' => $request->parent_name,
            'orang_tua_telepon' => $request->orang_tua_telepon,
            'class_id' => $request->class_id,
            'status_aktif' => $request->status_aktif,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($user->foto_path) {
                Storage::disk('public')->delete($user->foto_path);
            }
            $data['foto_path'] = $request->file('photo')->store('photos', 'public');
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diupdate');
    }

    public function destroy(User $user)
    {
        // Soft delete
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus');
    }

    public function toggleStatus(User $user)
    {
        $user->update([
            'status_aktif' => ! $user->status_aktif,
        ]);

        return back()->with('success', 'Status user berhasil diubah');
    }
}
