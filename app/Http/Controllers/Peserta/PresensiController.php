<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\KelasEnrollment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PresensiController extends Controller
{
    public function index(): View
    {
        /** @var User $user */
        $user = Auth::user();
        $pesertaId = $user->id;
        
        $enrolledClasses = KelasEnrollment::where('peserta_id', $pesertaId)
            ->with('kelas')
            ->get();

        return view('peserta.presensi.index', compact('enrolledClasses'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'photo' => 'required|string',
        ]);

        /** @var User $user */
        $user = Auth::user();
        $pesertaId = $user->id;
        $enrollment = KelasEnrollment::where('peserta_id', $pesertaId)
            ->where('kelas_id', $request->kelas_id)
            ->first();

        if (!$enrollment) {
            return redirect()->back()->with('error', 'Anda tidak terdaftar di kelas ini.');
        }

        if ($enrollment->sudah_absen) {
            return redirect()->back()->with('error', 'Anda sudah melakukan presensi untuk kelas ini.');
        }

        // Update status presensi
        $enrollment->update(['sudah_absen' => true]);

        // Here you could also save the photo to storage if needed
        // For now, just mark as attended

        return redirect()->route('peserta.presensi.index')->with('success', 'Presensi berhasil dicatat!');
    }
}
