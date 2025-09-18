<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ProfilePhotoHelper;
use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class SiswaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin,super_admin,guru');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $siswas = Siswa::with('kelas')
            ->orderBy('nama')
            ->paginate(10)
            ->withQueryString();

        return view('admin.siswas.index', compact('siswas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kelas = ClassRoom::orderBy('nama')->get();

        return view('admin.siswas.create', compact('kelas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            Siswa::validationRules(),
            Siswa::validationMessages()
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

        Siswa::create($data);

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Data siswa berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Siswa $siswa)
    {
        $siswa->load('kelas');

        return view('admin.siswas.show', compact('siswa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Siswa $siswa)
    {
        $kelas = ClassRoom::orderBy('nama')->get();
        $siswa->load('kelas');

        return view('admin.siswas.edit', compact('siswa', 'kelas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Siswa $siswa)
    {
        $request->validate(
            Siswa::validationRules($siswa->id),
            Siswa::validationMessages()
        );

        $data = $request->except(['foto_profil']);

        // Handle foto profil
        if ($request->hasFile('foto_profil')) {
            try {
                $data['foto_profil'] = ProfilePhotoHelper::uploadPhoto(
                    $request->file('foto_profil'),
                    $siswa->foto_profil
                );
            } catch (\InvalidArgumentException $e) {
                return back()->withErrors(['foto_profil' => $e->getMessage()])->withInput();
            }
        }

        $siswa->update($data);

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Data siswa berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Siswa $siswa)
    {
        try {
            // Hapus foto profil jika ada
            if ($siswa->foto_profil) {
                ProfilePhotoHelper::deletePhoto($siswa->foto_profil);
            }

            $siswa->delete();

            return redirect()->route('admin.siswa.index')
                ->with('success', 'Data siswa berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.siswa.index')
                ->with('error', 'Gagal menghapus data siswa. '.$e->getMessage());
        }
    }

    /**
     * Search siswa by name, nisn, nis, or email
     */
    public function search(Request $request)
    {
        $query = Siswa::with('kelas');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('nisn', 'like', "%{$search}%")
                    ->orWhere('nis', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('kelas')) {
            $query->where('id_kelas', $request->kelas);
        }

        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        $siswas = $query->orderBy('nama')
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Admin/Siswa/Index', [
            'siswas' => $siswas,
            'filters' => $request->only(['search', 'status', 'kelas', 'jenis']),
        ]);
    }

    /**
     * Toggle siswa status
     */
    public function toggleStatus(Siswa $siswa)
    {
        $newStatus = match ($siswa->status) {
            'active' => 'inactive',
            'inactive' => 'active',
            'graduated' => 'active',
            default => 'active'
        };

        $siswa->update(['status' => $newStatus]);

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Status siswa berhasil diubah.',
            ]);
        }

        return back()->with('success', 'Status siswa berhasil diubah.');
    }

    /**
     * Graduate siswa
     */
    public function graduate(Siswa $siswa)
    {
        $siswa->update(['status' => 'graduated']);

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Siswa berhasil diluluskan.',
            ]);
        }

        return redirect()->back()
            ->with('success', 'Siswa berhasil diluluskan.');
    }

    /**
     * Get siswa by kelas
     */
    public function getByKelas(ClassRoom $kelas)
    {
        $siswas = Siswa::where('id_kelas', $kelas->id)
            ->active()
            ->orderBy('nama')
            ->get();

        return response()->json($siswas);
    }
}
