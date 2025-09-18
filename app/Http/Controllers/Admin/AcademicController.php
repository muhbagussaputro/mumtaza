<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\Program;
use App\Models\ProgramJuzTarget;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AcademicController extends Controller
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

    // Kelas Management
    public function classes()
    {
        $classes = ClassRoom::withCount('students')->get();

        return view('admin.academic.classes.index', compact('classes'));
    }

    public function createClass()
    {
        return view('admin.academic.classes.create');
    }

    public function storeClass(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'academic_year' => 'required|string|max:20',
            'description' => 'nullable|string',
        ]);

        ClassRoom::create($request->all());

        return redirect()->route('admin.academic.classes')->with('success', 'Kelas berhasil ditambahkan');
    }

    public function editClass(ClassRoom $class)
    {
        return view('admin.academic.classes.edit', compact('class'));
    }

    public function updateClass(Request $request, ClassRoom $class)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'academic_year' => 'required|string|max:20',
            'description' => 'nullable|string',
        ]);

        $class->update($request->all());

        return redirect()->route('admin.academic.classes')->with('success', 'Kelas berhasil diupdate');
    }

    public function destroyClass(ClassRoom $class)
    {
        $class->delete();

        return redirect()->route('admin.academic.classes')->with('success', 'Kelas berhasil dihapus');
    }

    // Program Management
    public function programs(Request $request)
    {
        $query = Program::withTrashed()
            ->withCount(['studentPrograms', 'juzTargets'])
            ->with(['guru', 'juzTargets']);

        // Apply search filter
        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        // Apply status filter
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->whereNull('deleted_at');
            } elseif ($request->status === 'inactive') {
                $query->whereNotNull('deleted_at');
            }
        }

        // Apply jenis filter
        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        $programs = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        // Calculate statistics
        $stats = [
            'total' => Program::count(),
            'active' => Program::whereNull('deleted_at')->count(),
            'total_students' => DB::table('student_programs')->count(),
            'total_targets' => DB::table('juz_targets')->count(),
        ];

        return view('admin.programs.index', compact('programs', 'stats'));
    }

    public function createProgram()
    {
        $gurus = User::where('role', 'guru')->where('status_aktif', true)->get();
        return view('admin.programs.create', compact('gurus'));
    }

    public function storeProgram(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jenis' => 'required|in:reguler,khusus',
            'guru_id' => 'required|exists:users,id',
            'deskripsi' => 'nullable|string|max:1000',
            'juz_targets' => 'required|array|min:1',
            'juz_targets.*' => 'integer|between:1,30',
        ], [
            'nama.required' => 'Nama program wajib diisi.',
            'nama.max' => 'Nama program maksimal 255 karakter.',
            'jenis.required' => 'Jenis program wajib dipilih.',
            'jenis.in' => 'Jenis program harus reguler atau khusus.',
            'guru_id.required' => 'Guru pembimbing wajib dipilih.',
            'guru_id.exists' => 'Guru yang dipilih tidak valid.',
            'deskripsi.max' => 'Deskripsi maksimal 1000 karakter.',
            'juz_targets.required' => 'Target juz wajib dipilih minimal 1.',
            'juz_targets.*.integer' => 'Target juz harus berupa angka.',
            'juz_targets.*.between' => 'Target juz harus antara 1-30.',
        ]);

        DB::beginTransaction();
        try {
            $program = Program::create([
                'nama' => $request->nama,
                'jenis' => $request->jenis,
                'guru_id' => $request->guru_id,
                'deskripsi' => $request->deskripsi,
            ]);

            // Add juz targets
            foreach ($request->juz_targets as $juz) {
                \App\Models\JuzTarget::create([
                    'program_id' => $program->id,
                    'juz_number' => $juz,
                ]);
            }

            DB::commit();
            return redirect()->route('admin.programs.index')->with('success', 'Program berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withInput()->with('error', 'Gagal menambahkan program: ' . $e->getMessage());
        }
    }

    public function showProgram(Program $program)
    {
        $program->load(['juzTargets', 'guru', 'studentPrograms.student']);

        // Calculate program statistics
        $stats = [
            'total_students' => $program->studentPrograms->count(),
            'active_students' => $program->studentPrograms()->whereHas('student', function($q) {
                $q->where('status_aktif', true);
            })->count(),
            'total_targets' => $program->juzTargets->count(),
            'completed_entries' => $program->memorizationEntries()->where('klasifikasi', 'tercapai')->count(),
        ];

        return view('admin.programs.show', compact('program', 'stats'));
    }

    public function editProgram(Program $program)
    {
        $program->load('juzTargets');
        $gurus = User::where('role', 'guru')->where('status_aktif', true)->get();

        return view('admin.programs.edit', compact('program', 'gurus'));
    }

    public function updateProgram(Request $request, Program $program)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jenis' => 'required|in:reguler,khusus',
            'guru_id' => 'required|exists:users,id',
            'deskripsi' => 'nullable|string|max:1000',
            'juz_targets' => 'required|array|min:1',
            'juz_targets.*' => 'integer|between:1,30',
        ], [
            'nama.required' => 'Nama program wajib diisi.',
            'nama.max' => 'Nama program maksimal 255 karakter.',
            'jenis.required' => 'Jenis program wajib dipilih.',
            'jenis.in' => 'Jenis program harus reguler atau khusus.',
            'guru_id.required' => 'Guru pembimbing wajib dipilih.',
            'guru_id.exists' => 'Guru yang dipilih tidak valid.',
            'deskripsi.max' => 'Deskripsi maksimal 1000 karakter.',
            'juz_targets.required' => 'Target juz wajib dipilih minimal 1.',
            'juz_targets.*.integer' => 'Target juz harus berupa angka.',
            'juz_targets.*.between' => 'Target juz harus antara 1-30.',
        ]);

        DB::beginTransaction();
        try {
            $program->update([
                'nama' => $request->nama,
                'jenis' => $request->jenis,
                'guru_id' => $request->guru_id,
                'deskripsi' => $request->deskripsi,
            ]);

            // Update juz targets
            $program->juzTargets()->delete();
            foreach ($request->juz_targets as $juz) {
                \App\Models\JuzTarget::create([
                    'program_id' => $program->id,
                    'juz_number' => $juz,
                ]);
            }

            DB::commit();
            return redirect()->route('admin.programs.index')->with('success', 'Program berhasil diupdate');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withInput()->with('error', 'Gagal mengupdate program: ' . $e->getMessage());
        }
    }

    public function destroyProgram(Program $program)
    {
        try {
            // Check if program has active students
            $activeStudents = $program->studentPrograms()->whereHas('student', function($q) {
                $q->where('status_aktif', true);
            })->count();

            if ($activeStudents > 0) {
                return back()->with('error', 'Program tidak dapat dihapus karena masih memiliki siswa aktif.');
            }

            $program->delete();
            return redirect()->route('admin.programs.index')->with('success', 'Program berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus program: ' . $e->getMessage());
        }
    }

    public function restoreProgram($id)
    {
        try {
            $program = Program::withTrashed()->findOrFail($id);
            $program->restore();
            return redirect()->route('admin.programs.index')->with('success', 'Program berhasil dipulihkan');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memulihkan program: ' . $e->getMessage());
        }
    }

    public function addStudentToProgram(Request $request, Program $program)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
        ]);

        try {
            // Check if student is already in the program
            $exists = \App\Models\StudentProgram::where('student_id', $request->student_id)
                ->where('program_id', $program->id)
                ->exists();

            if ($exists) {
                return response()->json(['error' => 'Siswa sudah terdaftar dalam program ini'], 400);
            }

            \App\Models\StudentProgram::create([
                'student_id' => $request->student_id,
                'program_id' => $program->id,
            ]);

            return response()->json(['success' => 'Siswa berhasil ditambahkan ke program']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal menambahkan siswa: ' . $e->getMessage()], 500);
        }
    }

    public function removeStudentFromProgram(Program $program, User $student)
    {
        try {
            \App\Models\StudentProgram::where('student_id', $student->id)
                ->where('program_id', $program->id)
                ->delete();

            return response()->json(['success' => 'Siswa berhasil dihapus dari program']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal menghapus siswa: ' . $e->getMessage()], 500);
        }
    }
}
