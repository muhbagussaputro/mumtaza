<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\MemorizationEntry;
use App\Models\Program;
use App\Models\StudentProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (! in_array(Auth::user()->role, ['siswa', 'orang_tua'])) {
                abort(403, 'Unauthorized');
            }

            return $next($request);
        });
    }

    public function dashboard()
    {
        $user = Auth::user();

        // Get student (if orang_tua, get their child)
        $student = $user->role === 'siswa' ? $user : $user->children()->first();

        if (! $student) {
            return redirect()->back()->with('error', 'Data siswa tidak ditemukan');
        }

        // Get student programs with progress
        $programs = StudentProgram::where('student_id', $student->id)
            ->with(['program.juzTargets'])
            ->get()
            ->map(function ($studentProgram) {
                $totalJuz = $studentProgram->program->juzTargets->count();
                $completedJuz = $this->getCompletedJuzCount($studentProgram->student_id, $studentProgram->program_id);
                $progress = $totalJuz > 0 ? round(($completedJuz / $totalJuz) * 100, 1) : 0;

                $studentProgram->progress = $progress;

                return $studentProgram;
            });

        // Recent memorization entries
        $recentEntries = MemorizationEntry::where('student_id', $student->id)
            ->with(['surah', 'guru', 'program'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('siswa.dashboard', compact('student', 'programs', 'recentEntries'));
    }

    public function hafalan()
    {
        $user = Auth::user();
        $student = $user->role === 'siswa' ? $user : $user->children()->first();

        if (! $student) {
            return redirect()->back()->with('error', 'Data siswa tidak ditemukan');
        }

        // Get all student programs with detailed progress
        $programs = StudentProgram::where('student_id', $student->id)
            ->with(['program.juzTargets'])
            ->get()
            ->map(function ($studentProgram) {
                $program = $studentProgram->program;
                $juzTargets = $program->juzTargets;

                $juzProgress = [];
                foreach ($juzTargets as $juzTarget) {
                    $completed = $this->isJuzCompleted($studentProgram->student_id, $program->id, $juzTarget->juz_number);
                    $juzProgress[] = [
                        'juz_number' => $juzTarget->juz_number,
                        'completed' => $completed,
                    ];
                }

                $totalJuz = count($juzProgress);
                $completedJuz = collect($juzProgress)->where('completed', true)->count();
                $progress = $totalJuz > 0 ? round(($completedJuz / $totalJuz) * 100, 1) : 0;

                $studentProgram->juz_progress = $juzProgress;
                $studentProgram->progress = $progress;
                $studentProgram->status = $progress >= 100 ? 'selesai' : 'berjalan';

                return $studentProgram;
            });

        return view('siswa.hafalan', compact('student', 'programs'));
    }

    public function hafalanIndex(Request $request)
    {
        $user = Auth::user();
        $student = $user->role === 'siswa' ? $user : $user->children()->first();

        if (! $student) {
            return redirect()->back()->with('error', 'Data siswa tidak ditemukan');
        }

        $query = MemorizationEntry::where('student_id', $student->id)
            ->with(['surah', 'guru', 'program']);

        // Apply filters
        if ($request->filled('status')) {
            $query->where('keterangan', $request->status);
        }

        if ($request->filled('program_id')) {
            $query->where('program_id', $request->program_id);
        }

        $memorizations = $query->orderBy('created_at', 'desc')->get();

        // Get student programs for filter
        $programs = StudentProgram::where('student_id', $student->id)
            ->with('program')
            ->get()
            ->pluck('program');

        return view('siswa.hafalan.index', compact('student', 'memorizations', 'programs'));
    }

    public function hafalanDetail(Program $program)
    {
        $user = Auth::user();
        $student = $user->role === 'siswa' ? $user : $user->children()->first();

        if (! $student) {
            return redirect()->back()->with('error', 'Data siswa tidak ditemukan');
        }

        // Check if student is enrolled in this program
        $studentProgram = StudentProgram::where('student_id', $student->id)
            ->where('program_id', $program->id)
            ->first();

        if (! $studentProgram) {
            abort(404, 'Program tidak ditemukan');
        }

        // Get detailed juz progress with surah breakdown
        $juzTargets = $program->juzTargets;
        $juzDetails = [];

        foreach ($juzTargets as $juzTarget) {
            $entries = MemorizationEntry::where('student_id', $student->id)
                ->where('program_id', $program->id)
                ->where('juz_number', $juzTarget->juz_number)
                ->with(['surah'])
                ->orderBy('created_at', 'desc')
                ->get();

            $completed = $this->isJuzCompleted($student->id, $program->id, $juzTarget->juz_number);

            $juzDetails[] = [
                'juz_number' => $juzTarget->juz_number,
                'completed' => $completed,
                'entries' => $entries,
                'total_entries' => $entries->count(),
                'last_entry' => $entries->first(),
            ];
        }

        return view('siswa.hafalan-detail', compact('student', 'program', 'juzDetails'));
    }

    public function laporan(Request $request)
    {
        $user = Auth::user();
        $student = $user->role === 'siswa' ? $user : $user->children()->first();

        if (! $student) {
            return redirect()->back()->with('error', 'Data siswa tidak ditemukan');
        }

        $query = MemorizationEntry::where('student_id', $student->id)
            ->with(['surah', 'guru', 'program', 'violations.violation']);

        // Apply filters
        if ($request->filled('program_id')) {
            $query->where('program_id', $request->program_id);
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

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $entries = $query->orderBy('created_at', 'desc')->get();

        // Get filter options
        $programs = StudentProgram::where('student_id', $student->id)
            ->with('program')
            ->get()
            ->pluck('program');

        return view('siswa.laporan', compact('student', 'entries', 'programs'));
    }

    public function laporanDetail(MemorizationEntry $entry)
    {
        $user = Auth::user();
        $student = $user->role === 'siswa' ? $user : $user->children()->first();

        if (! $student || $entry->student_id !== $student->id) {
            abort(404, 'Data tidak ditemukan');
        }

        $entry->load(['surah', 'guru', 'program', 'violations.violation']);

        return view('siswa.laporan-detail', compact('student', 'entry'));
    }

    public function progress()
    {
        $user = Auth::user();
        $student = $user->role === 'siswa' ? $user : $user->children()->first();

        if (! $student) {
            return redirect()->back()->with('error', 'Data siswa tidak ditemukan');
        }

        // Get detailed progress for all programs
        $programs = StudentProgram::where('student_id', $student->id)
            ->with(['program.juzTargets'])
            ->get()
            ->map(function ($studentProgram) {
                $program = $studentProgram->program;
                $juzTargets = $program->juzTargets;

                $totalJuz = $juzTargets->count();
                $completedJuz = 0;
                $juzProgress = [];

                foreach ($juzTargets as $juzTarget) {
                    $completed = $this->isJuzCompleted($studentProgram->student_id, $program->id, $juzTarget->juz_number);
                    if ($completed) {
                        $completedJuz++;
                    }

                    $juzProgress[] = [
                        'juz_number' => $juzTarget->juz_number,
                        'completed' => $completed,
                    ];
                }

                $progress = $totalJuz > 0 ? round(($completedJuz / $totalJuz) * 100, 1) : 0;

                // Get recent activity
                $recentEntries = MemorizationEntry::where('student_id', $studentProgram->student_id)
                    ->where('program_id', $program->id)
                    ->orderBy('created_at', 'desc')
                    ->limit(3)
                    ->get();

                $studentProgram->total_juz = $totalJuz;
                $studentProgram->completed_juz = $completedJuz;
                $studentProgram->progress = $progress;
                $studentProgram->juz_progress = $juzProgress;
                $studentProgram->recent_entries = $recentEntries;
                $studentProgram->status = $progress >= 100 ? 'selesai' : 'berjalan';

                return $studentProgram;
            });

        // Overall statistics
        $totalPrograms = $programs->count();
        $completedPrograms = $programs->where('progress', '>=', 100)->count();
        $overallProgress = $totalPrograms > 0 ? round(($completedPrograms / $totalPrograms) * 100, 1) : 0;

        $stats = [
            'total_programs' => $totalPrograms,
            'completed_programs' => $completedPrograms,
            'active_programs' => $totalPrograms - $completedPrograms,
            'overall_progress' => $overallProgress,
        ];

        return view('siswa.progress', compact('student', 'programs', 'stats'));
    }

    private function getCompletedJuzCount($studentId, $programId)
    {
        $program = Program::find($programId);
        if (! $program) {
            return 0;
        }

        $completedCount = 0;
        foreach ($program->juzTargets as $juzTarget) {
            if ($this->isJuzCompleted($studentId, $programId, $juzTarget->juz_number)) {
                $completedCount++;
            }
        }

        return $completedCount;
    }

    private function isJuzCompleted($studentId, $programId, $juzNumber)
    {
        // Check if there are any successful memorization entries for this juz
        return MemorizationEntry::where('student_id', $studentId)
            ->where('program_id', $programId)
            ->where('juz_number', $juzNumber)
            ->where('klasifikasi', 'tercapai')
            ->exists();
    }
}
