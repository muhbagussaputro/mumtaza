<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\MemorizationEntry;
use App\Models\MemorizationEntryViolation;
use App\Models\Program;
use App\Models\StudentProgram;
use App\Models\Surah;
use App\Models\User;
use App\Models\Violation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MemorizationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(User $student, $programId = null)
    {
        $guru = Auth::user();

        // Get student programs
        $studentPrograms = StudentProgram::where('student_id', $student->id)
            ->with(['program.juzTargets'])
            ->get();

        // If program specified, get that program
        $selectedProgram = null;
        if ($programId) {
            $selectedProgram = $studentPrograms->where('program_id', $programId)->first();
        }

        $surahs = Surah::all();
        $violations = Violation::all();

        return view('guru.memorization.create', compact('student', 'studentPrograms', 'selectedProgram', 'surahs', 'violations'));
    }

    public function store(Request $request)
    {
        $guru = Auth::user();

        $request->validate([
            'student_id' => 'required|exists:users,id',
            'program_id' => 'required|exists:programs,id',
            'juz_number' => 'required|integer|between:1,30',
            'surah_id' => 'required|exists:surahs,id',
            'start_ayah' => 'required|integer|min:1',
            'end_ayah' => 'required|integer|min:1|gte:start_ayah',
            'halaman' => 'nullable|integer|min:1',
            'jadwal_setoran' => 'required|in:pagi,siang,malam',
            'keterangan' => 'required|in:lancar,tidak_lancar',
            'klasifikasi' => 'required|in:tercapai,tidak_tercapai',
            'jenis_setoran' => 'required|in:tambah_hafalan,murojaah_qorib,murojaah_bid',
            'hadir' => 'required|boolean',
            'has_violation' => 'nullable|boolean',
            'violations' => 'nullable|array',
            'violations.*' => 'exists:violations,id',
            'notes' => 'nullable|string|max:1000',
        ]);

        DB::beginTransaction();

        try {
            // Create memorization entry
            $entryData = [
                'student_id' => $request->student_id,
                'program_id' => $request->program_id,
                'guru_id' => $guru->id,
                'juz_number' => $request->juz_number,
                'surah_id' => $request->surah_id,
                'halaman' => $request->halaman,
                'ayat' => $request->start_ayah, // Gunakan start_ayah sebagai ayat
                'jadwal_setoran' => $request->jadwal_setoran,
                'keterangan' => $request->keterangan,
                'klasifikasi' => $request->klasifikasi,
                'jenis_setoran' => $request->jenis_setoran,
                'hadir' => $request->hadir ?? true,
                'notes' => $request->notes,
            ];

            $entry = MemorizationEntry::create($entryData);

            // Add violations if any
            if ($request->has_violation && $request->violations) {
                foreach ($request->violations as $violationId) {
                    MemorizationEntryViolation::create([
                        'entry_id' => $entry->id,
                        'violation_id' => $violationId,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('guru.data-hafalan')->with('success', 'Setoran berhasil ditambahkan');

        } catch (\Exception $e) {
            DB::rollback();

            return back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data: '.$e->getMessage()]);
        }
    }

    public function show(MemorizationEntry $entry)
    {
        $guru = Auth::user();

        // Check if this entry belongs to the current guru
        if ($entry->guru_id !== $guru->id) {
            abort(403, 'Unauthorized');
        }

        $entry->load(['student', 'program', 'surah', 'violations.violation']);

        return view('guru.hafalan.show', compact('entry'));
    }

    public function edit(MemorizationEntry $entry)
    {
        $guru = Auth::user();

        // Check if this entry belongs to the current guru
        if ($entry->guru_id !== $guru->id) {
            abort(403, 'Unauthorized');
        }

        $entry->load(['student', 'program', 'surah', 'violations.violation']);

        $studentPrograms = StudentProgram::where('student_id', $entry->student_id)
            ->with(['program.juzTargets'])
            ->get();

        $surahs = Surah::all();
        $violations = Violation::all();

        return view('guru.memorization.edit', compact('entry', 'studentPrograms', 'surahs', 'violations'));
    }

    public function update(Request $request, MemorizationEntry $entry)
    {
        $guru = Auth::user();

        // Check if this entry belongs to the current guru
        if ($entry->guru_id !== $guru->id) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'juz_number' => 'required|integer|between:1,30',
            'surah_id' => 'required|exists:surahs,id',
            'halaman' => 'nullable|integer|min:1',
            'ayat' => 'nullable|integer|min:1',
            'jadwal_setoran' => 'required|in:pagi,siang,malam',
            'keterangan' => 'required|in:lancar,tidak_lancar',
            'klasifikasi' => 'required|in:tercapai,tidak_tercapai',
            'jenis_setoran' => 'required|in:tambah_hafalan,murojaah_qorib,murojaah_bid',
            'hadir' => 'required|boolean',
            'has_violation' => 'boolean',
            'violations' => 'nullable|array',
            'violations.*' => 'exists:violations,id',
            'notes' => 'nullable|string|max:1000',
        ]);

        DB::beginTransaction();

        try {
            // Update memorization entry
            $entry->update([
                'juz_number' => $validated['juz_number'],
                'surah_id' => $validated['surah_id'],
                'halaman' => $validated['halaman'],
                'ayat' => $validated['ayat'],
                'jadwal_setoran' => $validated['jadwal_setoran'],
                'keterangan' => $validated['keterangan'],
                'klasifikasi' => $validated['klasifikasi'],
                'jenis_setoran' => $validated['jenis_setoran'],
                'hadir' => $validated['hadir'],
                'notes' => $validated['notes'],
            ]);

            // Update violations
            $entry->violations()->delete();
            if (! empty($validated['has_violation']) && ! empty($validated['violations'])) {
                foreach ($validated['violations'] as $violationId) {
                    MemorizationEntryViolation::create([
                        'entry_id' => $entry->id,
                        'violation_id' => $violationId,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('guru.data-hafalan')
                ->with('success', 'Setoran berhasil diupdate');

        } catch (\Exception $e) {
            DB::rollback();

            return back()->withErrors(['error' => 'Terjadi kesalahan saat mengupdate data: '.$e->getMessage()])
                ->withInput();
        }
    }

    public function destroy(MemorizationEntry $entry)
    {
        $guru = Auth::user();

        // Check if this entry belongs to the current guru
        if ($entry->guru_id !== $guru->id) {
            abort(403, 'Unauthorized');
        }

        $entry->delete();

        return back()->with('success', 'Setoran berhasil dihapus');
    }
}
