<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ProfilePhotoHelper;
use App\Http\Controllers\Controller;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GuruController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin,super_admin');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gurus = Guru::orderBy('nama')
            ->paginate(10)
            ->withQueryString();

        return view('admin.gurus.index', compact('gurus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.gurus.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            Guru::validationRules(),
            Guru::validationMessages()
        );

        $data = $request->except(['foto_profil']);

        // Handle foto profil
        if ($request->hasFile('foto_profil')) {
            try {
                $data['foto_profil'] = ProfilePhotoHelper::uploadPhoto($request->file('foto_profil'));
            } catch (\InvalidArgumentException $e) {
                return back()->withErrors(['foto_profil' => $e->getMessage()])->withInput();
            }
        }

        Guru::create($data);

        return redirect()->route('admin.guru.index')
            ->with('success', 'Data guru berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Guru $guru)
    {
        return view('admin.gurus.show', compact('guru'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Guru $guru)
    {
        return view('admin.gurus.edit', compact('guru'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Guru $guru)
    {
        $request->validate(
            Guru::validationRules($guru->id),
            Guru::validationMessages()
        );

        $data = $request->except(['foto_profil']);

        // Handle foto profil
        if ($request->hasFile('foto_profil')) {
            try {
                $data['foto_profil'] = ProfilePhotoHelper::uploadPhoto(
                    $request->file('foto_profil'),
                    $guru->foto_profil
                );
            } catch (\InvalidArgumentException $e) {
                return back()->withErrors(['foto_profil' => $e->getMessage()])->withInput();
            }
        }

        $guru->update($data);

        return redirect()->route('admin.guru.index')
            ->with('success', 'Data guru berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Guru $guru)
    {
        try {
            // Hapus foto profil jika ada
            if ($guru->foto_profil) {
                ProfilePhotoHelper::deletePhoto($guru->foto_profil);
            }

            $guru->delete();

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Data guru berhasil dihapus.',
                ]);
            }

            return redirect()->route('admin.gurus.index')
                ->with('success', 'Data guru berhasil dihapus.');
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus data guru. '.$e->getMessage(),
                ]);
            }

            return redirect()->route('admin.gurus.index')
                ->with('error', 'Gagal menghapus data guru. '.$e->getMessage());
        }
    }

    /**
     * Search guru by name or email
     */
    public function search(Request $request)
    {
        $query = Guru::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $gurus = $query->orderBy('nama')
            ->paginate(10)
            ->withQueryString();

        return view('admin.gurus.index', compact('gurus'));
    }

    /**
     * Toggle guru status
     */
    public function toggleStatus(Guru $guru)
    {
        $guru->update([
            'status' => $guru->status === 'active' ? 'inactive' : 'active',
        ]);

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Status guru berhasil diubah.',
            ]);
        }

        return back()->with('success', 'Status guru berhasil diubah.');
    }
}
