<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\KelasEnrollment;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $pesertaId = auth()->id();

        return view('peserta.dashboard', [
            'enrolledClasses' => KelasEnrollment::where('peserta_id', $pesertaId)
                ->with('kelas.mentor')
                ->get(),
            'totalClasses' => KelasEnrollment::where('peserta_id', $pesertaId)->count(),
            'activeClasses' => KelasEnrollment::where('peserta_id', $pesertaId)
                ->where('status', 'aktif')
                ->with('kelas')
                ->count(),
            'completedClasses' => KelasEnrollment::where('peserta_id', $pesertaId)
                ->where('status', 'selesai')
                ->with('kelas')
                ->count(),
            'recentAnnouncements' => Announcement::with('creator')
                ->whereIn('target', ['all', 'peserta'])
                ->latest()
                ->limit(4)
                ->get(),
        ]);
    }
}
