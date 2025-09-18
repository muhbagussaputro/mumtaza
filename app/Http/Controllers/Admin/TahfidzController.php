<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MemorizationEntry;
use App\Models\Program;
use App\Models\StudentProgram;
use App\Models\Surah;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TahfidzController extends Controller
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

    // Target Program per Siswa
    public function targetPrograms()
    {
        $studentPrograms = StudentProgram::with(['student', 'program.juzTargets'])->get();

        return view('admin.tahfidz.target-programs.index', compact('studentPrograms'));
    }

    public function createTargetProgram()
    {
        $students = User::where('role', 'siswa')->where('status', 'active')->get();
        $programs = Program::with('juzTargets')->get();

        return view('admin.tahfidz.target-programs.create', compact('students', 'programs'));
    }

    public function storeTargetProgram(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'program_id' => 'required|exists:programs,id',
            'start_date' => 'required|date',
            'target_completion_date' => 'nullable|date|after:start_date',
        ]);

        // Check if student already has this program
        $exists = StudentProgram::where('student_id', $request->student_id)
            ->where('program_id', $request->program_id)
            ->exists();

        if ($exists) {
            return back()->withErrors(['student_id' => 'Siswa sudah memiliki program ini']);
        }

        StudentProgram::create($request->all());

        return redirect()->route('admin.tahfidz.target-programs')->with('success', 'Target program berhasil ditambahkan');
    }

    public function editTargetProgram(StudentProgram $studentProgram)
    {
        $students = User::where('role', 'siswa')->where('status', 'active')->get();
        $programs = Program::with('juzTargets')->get();

        return view('admin.tahfidz.target-programs.edit', compact('studentProgram', 'students', 'programs'));
    }

    public function updateTargetProgram(Request $request, StudentProgram $studentProgram)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'program_id' => 'required|exists:programs,id',
            'start_date' => 'required|date',
            'target_completion_date' => 'nullable|date|after:start_date',
            'status' => 'required|in:active,completed,paused',
        ]);

        $studentProgram->update($request->all());

        return redirect()->route('admin.tahfidz.target-programs')->with('success', 'Target program berhasil diupdate');
    }

    public function destroyTargetProgram(StudentProgram $studentProgram)
    {
        $studentProgram->delete();

        return redirect()->route('admin.tahfidz.target-programs')->with('success', 'Target program berhasil dihapus');
    }

    // Rekap Hafalan Siswa
    public function rekapHafalan(Request $request)
    {
        $query = MemorizationEntry::with(['student', 'program', 'guru', 'surah']);

        // Apply filters
        if ($request->filled('juz_number')) {
            $query->where('juz_number', $request->juz_number);
        }

        if ($request->filled('surah_id')) {
            $query->where('surah_id', $request->surah_id);
        }

        if ($request->filled('student_id')) {
            $query->where('student_id', $request->student_id);
        }

        if ($request->filled('guru_id')) {
            $query->where('guru_id', $request->guru_id);
        }

        if ($request->filled('jadwal')) {
            $query->where('jadwal', $request->jadwal);
        }

        if ($request->filled('keterangan')) {
            $query->where('keterangan', $request->keterangan);
        }

        if ($request->filled('klasifikasi')) {
            $query->where('klasifikasi', $request->klasifikasi);
        }

        if ($request->filled('jenis_setoran')) {
            $query->where('jenis_setoran', $request->jenis_setoran);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $entries = $query->orderBy('created_at', 'desc')->get();

        // Data for filters
        $students = User::where('role', 'siswa')->where('status', 'active')->get();
        $gurus = User::where('role', 'guru')->where('status', 'active')->get();
        $surahs = Surah::all();

        return view('admin.tahfidz.rekap-hafalan.index', compact('entries', 'students', 'gurus', 'surahs'));
    }

    public function exportRekapHafalan(Request $request)
    {
        // Implementation for export functionality
        // This can be implemented later with Excel export
        return back()->with('info', 'Fitur export akan segera tersedia');
    }

    // Memorizations Management
    public function memorizations(Request $request)
    {
        $query = MemorizationEntry::with(['student', 'program', 'guru', 'surah']);

        // Apply filters
        if ($request->filled('student_id')) {
            $query->where('student_id', $request->student_id);
        }

        if ($request->filled('program_id')) {
            $query->where('program_id', $request->program_id);
        }

        if ($request->filled('guru_id')) {
            $query->where('guru_id', $request->guru_id);
        }

        if ($request->filled('status')) {
            $query->where('keterangan', $request->status);
        }

        $memorizations = $query->orderBy('created_at', 'desc')->paginate(15);

        // Data for filters
        $students = User::where('role', 'siswa')->where('status_aktif', true)->get();
        $programs = Program::all();
        $gurus = User::where('role', 'guru')->where('status_aktif', true)->get();

        return view('admin.memorizations.index', compact('memorizations', 'students', 'programs', 'gurus'));
    }

    // Reports Management
    public function reports(Request $request)
    {
        $query = MemorizationEntry::with(['student', 'program', 'guru', 'surah']);

        // Apply date filters
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Apply other filters
        if ($request->filled('student_id')) {
            $query->where('student_id', $request->student_id);
        }

        if ($request->filled('program_id')) {
            $query->where('program_id', $request->program_id);
        }

        if ($request->filled('guru_id')) {
            $query->where('guru_id', $request->guru_id);
        }

        $reports = $query->orderBy('created_at', 'desc')->paginate(15);

        // Statistics
        $totalEntries = $query->count();
        $completedEntries = $query->where('keterangan', 'Lulus')->count();
        $pendingEntries = $query->where('keterangan', 'Mengulang')->count();

        // Data for filters
        $students = User::where('role', 'siswa')->where('status_aktif', true)->get();
        $programs = Program::all();
        $gurus = User::where('role', 'guru')->where('status_aktif', true)->get();

        return view('admin.reports.index', compact('reports', 'students', 'programs', 'gurus', 'totalEntries', 'completedEntries', 'pendingEntries'));
    }
}
