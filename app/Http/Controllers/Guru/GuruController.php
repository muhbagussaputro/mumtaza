<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\MemorizationEntry;
use App\Models\Program;
use App\Models\StudentProgram;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuruController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (Auth::user()->role !== 'guru') {
                abort(403, 'Unauthorized');
            }

            return $next($request);
        });
    }

    public function dashboard()
    {
        $guru = Auth::user();

        // Get programs with students and their progress
        $programs = Program::with(['studentPrograms.student'])
            ->whereHas('studentPrograms.student', function ($query) {
                $query->where('status_aktif', true);
            })
            ->get()
            ->map(function ($program) use ($guru) {
                $program->students_with_progress = $program->studentPrograms->map(function ($studentProgram) use ($program, $guru) {
                    $student = $studentProgram->student;

                    // Calculate progress percentage
                    $totalJuz = $program->juzTargets->count();
                    $completedJuz = MemorizationEntry::where('student_id', $student->id)
                        ->where('program_id', $program->id)
                        ->where('guru_id', $guru->id)
                        ->where('klasifikasi', 'tercapai')
                        ->distinct('juz_number')
                        ->count();

                    $progress = $totalJuz > 0 ? round(($completedJuz / $totalJuz) * 100, 1) : 0;

                    return [
                        'student' => $student,
                        'progress' => $progress,
                        'student_program' => $studentProgram,
                    ];
                });

                return $program;
            });

        return view('guru.dashboard', compact('programs'));
    }

    public function dataSiswa(Request $request)
    {
        $guru = Auth::user();
        $programId = $request->get('program_id');

        $query = User::where('role', 'siswa')
            ->where('status_aktif', true)
            ->with(['studentPrograms.program']);

        if ($programId) {
            $query->whereHas('studentPrograms', function ($q) use ($programId) {
                $q->where('program_id', $programId);
            });
        }

        $students = $query->get()->map(function ($student) use ($guru, $programId) {
            $studentPrograms = $student->studentPrograms;

            if ($programId) {
                $studentPrograms = $studentPrograms->where('program_id', $programId);
            }

            $student->programs_with_progress = $studentPrograms->map(function ($studentProgram) use ($guru, $student) {
                $program = $studentProgram->program;

                // Calculate progress
                $totalJuz = $program->juzTargets->count();
                $completedJuz = MemorizationEntry::where('student_id', $student->id)
                    ->where('program_id', $program->id)
                    ->where('guru_id', $guru->id)
                    ->where('klasifikasi', 'tercapai')
                    ->distinct('juz_number')
                    ->count();

                $progress = $totalJuz > 0 ? round(($completedJuz / $totalJuz) * 100, 1) : 0;

                return [
                    'program' => $program,
                    'progress' => $progress,
                    'student_program' => $studentProgram,
                ];
            });

            return $student;
        });

        $programs = Program::all();

        return view('guru.data-siswa', compact('students', 'programs', 'programId'));
    }

    public function lihatHafalan(User $student, $programId = null)
    {
        $guru = Auth::user();

        $query = MemorizationEntry::where('student_id', $student->id)
            ->where('guru_id', $guru->id)
            ->with(['program', 'surah']);

        if ($programId) {
            $query->where('program_id', $programId);
        }

        $entries = $query->orderBy('created_at', 'desc')->get();

        // Get student programs for filter
        $studentPrograms = StudentProgram::where('student_id', $student->id)
            ->with('program')
            ->get();

        return view('guru.lihat-hafalan', compact('student', 'entries', 'studentPrograms', 'programId'));
    }

    public function dataHafalan(Request $request)
    {
        $guru = Auth::user();

        $query = MemorizationEntry::where('guru_id', $guru->id)
            ->with(['student', 'program', 'surah']);

        // Apply filters
        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }

        if ($request->filled('jadwal')) {
            $query->where('jadwal', $request->jadwal);
        }

        if ($request->filled('jenis_setoran')) {
            $query->where('jenis_setoran', $request->jenis_setoran);
        }

        if ($request->filled('klasifikasi')) {
            $query->where('klasifikasi', $request->klasifikasi);
        }

        $entries = $query->orderBy('created_at', 'desc')->get();

        return view('guru.data-hafalan', compact('entries'));
    }

    public function siswaIndex()
    {
        $guru = Auth::user();

        $students = User::where('role', 'siswa')
            ->where('status_aktif', true)
            ->with(['studentPrograms.program'])
            ->paginate(15);

        $programs = Program::all();

        return view('guru.siswa.index', compact('students', 'programs'));
    }

    public function siswaShow(User $student)
    {
        $guru = Auth::user();

        // Get student with programs and progress
        $student->load(['studentPrograms.program']);

        // Calculate progress for each program
        $student->programs_with_progress = $student->studentPrograms->map(function ($studentProgram) use ($guru, $student) {
            $program = $studentProgram->program;

            // Calculate progress
            $totalJuz = $program->juzTargets->count();
            $completedJuz = MemorizationEntry::where('student_id', $student->id)
                ->where('program_id', $program->id)
                ->where('guru_id', $guru->id)
                ->where('klasifikasi', 'tercapai')
                ->distinct('juz_number')
                ->count();

            $progress = $totalJuz > 0 ? round(($completedJuz / $totalJuz) * 100, 1) : 0;

            return [
                'program' => $program,
                'progress' => $progress,
                'student_program' => $studentProgram,
            ];
        });

        // Get recent memorization entries
        $recentEntries = MemorizationEntry::where('student_id', $student->id)
            ->where('guru_id', $guru->id)
            ->with(['program', 'surah'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('guru.siswa.show', compact('student', 'recentEntries'));
    }

    public function hafalanIndex(Request $request)
    {
        $guru = Auth::user();

        $query = MemorizationEntry::where('guru_id', $guru->id)
            ->with(['student', 'program', 'surah']);

        // Apply filters
        if ($request->filled('student_id')) {
            $query->where('student_id', $request->student_id);
        }

        if ($request->filled('program_id')) {
            $query->where('program_id', $request->program_id);
        }

        if ($request->filled('juz_number')) {
            $query->where('juz_number', $request->juz_number);
        }

        if ($request->filled('klasifikasi')) {
            $query->where('klasifikasi', $request->klasifikasi);
        }

        $entries = $query->orderBy('created_at', 'desc')->paginate(20);

        // Get filter options
        $students = User::where('role', 'siswa')->where('status_aktif', true)->get();
        $programs = Program::all();

        return view('guru.hafalan.index', compact('entries', 'students', 'programs'));
    }

    public function laporanIndex(Request $request)
    {
        $guru = Auth::user();

        $query = MemorizationEntry::where('guru_id', $guru->id)
            ->with(['student', 'program', 'surah']);

        // Apply date filter
        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
            $query->whereBetween('created_at', [$request->tanggal_mulai, $request->tanggal_selesai]);
        }

        if ($request->filled('program_id')) {
            $query->where('program_id', $request->program_id);
        }

        $entries = $query->orderBy('created_at', 'desc')->get();

        // Calculate statistics
        $totalEntries = $entries->count();
        $tercapai = $entries->where('klasifikasi', 'tercapai')->count();
        $belumTercapai = $entries->where('klasifikasi', 'belum_tercapai')->count();

        $programs = Program::all();

        return view('guru.laporan.index', compact('entries', 'programs', 'totalEntries', 'tercapai', 'belumTercapai'));
    }
}
