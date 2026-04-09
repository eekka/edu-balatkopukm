<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Kelas;
use App\Models\Program;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'totalUsers' => User::count(),
            'totalAdmins' => User::where('role', 'admin')->count(),
            'totalMentors' => User::where('role', 'mentor')->count(),
            'totalPeserta' => User::where('role', 'peserta')->count(),
            'totalPrograms' => Program::count(),
            'totalClasses' => Kelas::count(),
            'activeClasses' => Kelas::where('status', 'aktif')->count(),
            'totalAnnouncements' => Announcement::count(),
            'recentUsers' => User::latest()->limit(5)->get(),
            'recentClasses' => Kelas::with('program')->latest()->limit(5)->get(),
            'recentAnnouncements' => Announcement::with('creator')->latest()->limit(4)->get(),
        ]);
    }
}
