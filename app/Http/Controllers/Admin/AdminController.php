<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MemorizationEntry;
use App\Models\Program;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
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

    public function dashboard()
    {
        $stats = [
            'total_guru' => User::where('role', 'guru')->count(),
            'total_siswa' => User::where('role', 'siswa')->count(),
            'total_program' => Program::count(),
            'setoran_hari_ini' => MemorizationEntry::whereDate('created_at', Carbon::today())->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function users()
    {
        return view('admin.users.index');
    }

    public function academic()
    {
        return view('admin.academic.index');
    }

    public function tahfidz()
    {
        return view('admin.tahfidz.index');
    }

    public function settings()
    {
        return view('admin.settings.index');
    }
}
