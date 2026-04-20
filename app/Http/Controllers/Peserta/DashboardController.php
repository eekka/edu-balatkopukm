<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Kelas;
use App\Models\KelasEnrollment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
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
                ->visibleTo(auth()->user())
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
            ->with('kelas.mentor', 'kelas.program')
            ->get();

        return view('peserta.jadwal', compact('enrolledClasses'));
    }

    public function joinByCode(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'kode_kelas' => ['required', 'string', 'max:20'],
        ]);

        $kodeKelas = Str::upper(trim($validated['kode_kelas']));
        $kelas = Kelas::where('kode_kelas', $kodeKelas)->first();

        if (! $kelas) {
            return back()->withErrors([
                'kode_kelas' => 'Kode kelas tidak ditemukan.',
            ])->withInput();
        }

        if ($kelas->status !== 'aktif') {
            return back()->withErrors([
                'kode_kelas' => 'Kelas belum dibuka untuk pendaftaran.',
            ])->withInput();
        }

        $enrollment = KelasEnrollment::firstOrCreate(
            [
                'peserta_id' => auth()->id(),
                'kelas_id' => $kelas->id,
            ],
            [
                'terdaftar_pada' => now(),
                'status' => 'aktif',
            ],
        );

        if (! $enrollment->wasRecentlyCreated) {
            return back()->with('status', 'Anda sudah terdaftar di kelas ini.');
        }

        return back()->with('status', 'Berhasil bergabung ke kelas '.$kelas->nama.'.');
    }
}
