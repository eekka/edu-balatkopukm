<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $mentorId = auth()->id();

        return view('mentor.dashboard', [
            'myClasses' => Kelas::where('mentor_id', $mentorId)
                ->with(['program', 'enrollments'])
                ->latest()
                ->get(),
            'totalClasses' => Kelas::where('mentor_id', $mentorId)->count(),
            'totalPeserta' => Kelas::where('mentor_id', $mentorId)->withCount('enrollments')->get()->sum('enrollments_count'),
            'activeClasses' => Kelas::where('mentor_id', $mentorId)->where('status', 'aktif')->count(),
            'recentClasses' => Kelas::where('mentor_id', $mentorId)
                ->with(['program', 'enrollments'])
                ->latest()
                ->limit(4)
                ->get(),
        ]);
    }
}
