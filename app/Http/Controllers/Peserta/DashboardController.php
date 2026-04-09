<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Kelas;
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

    public function indexKelas(): View
    {
        $enrolledClasses = KelasEnrollment::where('peserta_id', auth()->id())
            ->with('kelas.mentor')
            ->get();

        return view('peserta.kelas.index', compact('enrolledClasses'));
    }

    public function showKelas(Kelas $kelas): View
    {
        $enrollment = KelasEnrollment::where('peserta_id', auth()->id())
            ->where('kelas_id', $kelas->id)
            ->first();

        if (! $enrollment) {
            abort(403, 'Anda tidak terdaftar di kelas ini.');
        }

        return view('peserta.kelas.show', compact('kelas', 'enrollment'));
    }

    public function sertifikat(): View
    {
        $completedEnrollments = KelasEnrollment::where('peserta_id', auth()->id())
            ->where('status', 'selesai')
            ->with('kelas')
            ->get();

        return view('peserta.sertifikat', compact('completedEnrollments'));
    }

    public function progress(): View
    {
        $enrollments = KelasEnrollment::where('peserta_id', auth()->id())
            ->with('kelas')
            ->get();

        return view('peserta.progress', compact('enrollments'));
    }

    public function jadwal(): View
    {
        $enrolledClasses = KelasEnrollment::where('peserta_id', auth()->id())
            ->with('kelas')
            ->get();

        return view('peserta.jadwal', compact('enrolledClasses'));
    }
}
