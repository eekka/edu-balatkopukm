<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Kelas;
use App\Models\KelasEnrollment;
use App\Models\Program;
use App\Models\User;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function index(): View
    {
        return view('admin.reports', [
            'totalUsers' => User::count(),
            'totalMentors' => User::where('role', 'mentor')->count(),
            'totalPeserta' => User::where('role', 'peserta')->count(),
            'totalPrograms' => Program::count(),
            'totalClasses' => Kelas::count(),
            'activeClasses' => Kelas::where('status', 'aktif')->count(),
            'totalEnrollments' => KelasEnrollment::count(),
            'announcements' => Announcement::latest()->limit(5)->get(),
            'classes' => Kelas::with(['program', 'mentor', 'enrollments'])->latest()->get(),
        ]);
    }

    public function exportUsers(): StreamedResponse
    {
        $filename = 'laporan-users-'.now()->format('Y-m-d-His').'.csv';

        return response()->streamDownload(function (): void {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Nama', 'Email', 'Username', 'Role', 'Instansi', 'No HP']);

            User::orderBy('name')->chunk(100, function ($users) use ($handle): void {
                foreach ($users as $user) {
                    fputcsv($handle, [$user->name, $user->email, $user->username, $user->role, $user->instansi, $user->no_hp]);
                }
            });

            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv']);
    }

    public function exportClasses(): StreamedResponse
    {
        $filename = 'laporan-kelas-'.now()->format('Y-m-d-His').'.csv';

        return response()->streamDownload(function (): void {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Kelas', 'Program', 'Mentor', 'Status', 'Peserta', 'Kapasitas']);

            Kelas::with(['program', 'mentor', 'enrollments'])->chunk(100, function ($kelasList) use ($handle): void {
                foreach ($kelasList as $kelas) {
                    fputcsv($handle, [
                        $kelas->nama,
                        $kelas->program?->nama,
                        $kelas->mentor?->name,
                        $kelas->status,
                        $kelas->enrollments->count(),
                        $kelas->kapasitas,
                    ]);
                }
            });

            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv']);
    }
}
