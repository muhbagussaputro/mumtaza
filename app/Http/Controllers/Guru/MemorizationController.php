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
            'halaman_from' => 'required|integer|min:1',
            'halaman_to' => 'required|integer|gte:halaman_from',
            'ayat_from' => 'required|integer|min:1',
            'ayat_to' => 'required|integer|gte:ayat_from',
            'jadwal' => 'required|in:pagi,siang,malam',
            'keterangan' => 'required|in:lancar,tidak_lancar',
            'klasifikasi' => 'required|in:tercapai,tidak_tercapai',
            'jenis_setoran' => 'required|in:tambah,murojaah_qorib,murojaah_bid',
            'has_violation' => 'boolean',
            'violations' => 'array',
            'violations.*' => 'exists:violations,id',
            'notes' => 'nullable|string|max:1000',
        ]);

        DB::beginTransaction();

        try {
            // Create memorization entry
            $entry = MemorizationEntry::create([
                'student_id' => $request->student_id,
                'program_id' => $request->program_id,
                'guru_id' => $guru->id,
                'juz_number' => $request->juz_number,
                'surah_id' => $request->surah_id,
                'halaman_from' => $request->halaman_from,
                'halaman_to' => $request->halaman_to,
                'ayat_from' => $request->ayat_from,
                'ayat_to' => $request->ayat_to,
                'jadwal' => $request->jadwal,
                'keterangan' => $request->keterangan,
                'klasifikasi' => $request->klasifikasi,
                'jenis_setoran' => $request->jenis_setoran,
                'notes' => $request->notes,
            ]);

            // Add violations if any
            if ($request->has_violation && $request->violations) {
                foreach ($request->violations as $violationId) {
                    MemorizationEntryViolation::create([
                        'memorization_entry_id' => $entry->id,
                        'violation_id' => $violationId,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('guru.hafalan.index')->with('success', 'Setoran berhasil ditambahkan');

        } catch (\Exception $e) {
            DB::rollback();

            return back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data']);
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

        $request->validate([
            'juz_number' => 'required|integer|between:1,30',
            'surah_id' => 'required|exists:surahs,id',
            'halaman_from' => 'required|integer|min:1',
            'halaman_to' => 'required|integer|gte:halaman_from',
            'ayat_from' => 'required|integer|min:1',
            'ayat_to' => 'required|integer|gte:ayat_from',
            'jadwal' => 'required|in:pagi,siang,malam',
            'keterangan' => 'required|in:lancar,tidak_lancar',
            'klasifikasi' => 'required|in:tercapai,tidak_tercapai',
            'jenis_setoran' => 'required|in:tambah,murojaah_qorib,murojaah_bid',
            'has_violation' => 'boolean',
            'violations' => 'array',
            'violations.*' => 'exists:violations,id',
            'notes' => 'nullable|string|max:1000',
        ]);

        DB::beginTransaction();

        try {
            // Update memorization entry
            $entry->update([
                'juz_number' => $request->juz_number,
                'surah_id' => $request->surah_id,
                'halaman_from' => $request->halaman_from,
                'halaman_to' => $request->halaman_to,
                'ayat_from' => $request->ayat_from,
                'ayat_to' => $request->ayat_to,
                'jadwal' => $request->jadwal,
                'keterangan' => $request->keterangan,
                'klasifikasi' => $request->klasifikasi,
                'jenis_setoran' => $request->jenis_setoran,
                'notes' => $request->notes,
            ]);

            // Update violations
            $entry->violations()->delete();
            if ($request->has_violation && $request->violations) {
                foreach ($request->violations as $violationId) {
                    MemorizationEntryViolation::create([
                        'memorization_entry_id' => $entry->id,
                        'violation_id' => $violationId,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('guru.data-hafalan')
                ->with('success', 'Setoran berhasil diupdate');

        } catch (\Exception $e) {
            DB::rollback();

            return back()->withErrors(['error' => 'Terjadi kesalahan saat mengupdate data'])
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
