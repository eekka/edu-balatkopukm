<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Http\Requests\Peserta\StoreTugasSubmissionRequest;
use App\Models\Announcement;
use App\Models\Kelas;
use App\Models\KelasEnrollment;
use App\Models\Tugas;
use App\Models\TugasSubmission;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $pesertaId = auth()->id();

        $enrolledClasses = KelasEnrollment::where('peserta_id', $pesertaId)
            ->with('kelas.mentor', 'kelas.program')
            ->get();

        $recentAnnouncements = Announcement::with('creator')
            ->visibleTo(auth()->user())
            ->latest()
            ->limit(4)
            ->get();

        $calendarDate = now();

        return view('peserta.dashboard', [
            'enrolledClasses' => $enrolledClasses,
            'totalClasses' => $enrolledClasses->count(),
            'activeClasses' => $enrolledClasses->where('status', 'aktif')->count(),
            'completedClasses' => $enrolledClasses->where('status', 'selesai')->count(),
            'recentAnnouncements' => $recentAnnouncements,
            'timelineItems' => $this->buildTimelineItems($recentAnnouncements),
            'calendarMonthLabel' => $calendarDate->translatedFormat('F Y'),
            'calendarWeeks' => $this->buildCalendarWeeks($calendarDate, $enrolledClasses),
            'calendarPreviousMonthLabel' => $calendarDate->copy()->subMonth()->translatedFormat('F'),
            'calendarNextMonthLabel' => $calendarDate->copy()->addMonth()->translatedFormat('F'),
        ]);
    }

    private function buildTimelineItems(Collection $recentAnnouncements): Collection
    {
        return $recentAnnouncements->map(function (Announcement $announcement): array {
            return [
                'type' => 'Pengumuman',
                'title' => $announcement->judul,
                'description' => Str::limit(strip_tags((string) $announcement->isi), 95),
                'date' => $announcement->created_at?->format('d M Y H:i') ?? '-',
                'target' => ucfirst($announcement->target),
            ];
        });
    }

    private function buildCalendarWeeks(Carbon $month, Collection $enrolledClasses): array
    {
        $startOfMonth = $month->copy()->startOfMonth();
        $firstDayOffset = $startOfMonth->dayOfWeekIso - 1;
        $daysInMonth = $startOfMonth->daysInMonth;

        $scheduleDayMap = [
            'senin' => 1,
            'selasa' => 2,
            'rabu' => 3,
            'kamis' => 4,
            'jumat' => 5,
            'sabtu' => 6,
            'minggu' => 7,
        ];

        $scheduledDayNumbers = $enrolledClasses
            ->where('status', 'aktif')
            ->pluck('kelas.jadwal_hari')
            ->filter()
            ->map(fn (?string $day): ?int => $day ? ($scheduleDayMap[strtolower($day)] ?? null) : null)
            ->filter()
            ->unique()
            ->values()
            ->all();

        $totalSlots = (int) ceil(($firstDayOffset + $daysInMonth) / 7) * 7;
        $weeks = [];
        $week = [];
        $currentDay = 1;

        for ($slot = 0; $slot < $totalSlots; $slot++) {
            if ($slot < $firstDayOffset || $currentDay > $daysInMonth) {
                $week[] = null;
            } else {
                $date = $startOfMonth->copy()->day($currentDay);

                $week[] = [
                    'day' => $currentDay,
                    'isToday' => $date->isToday(),
                    'hasClass' => in_array($date->dayOfWeekIso, $scheduledDayNumbers, true),
                ];

                $currentDay++;
            }

            if (count($week) === 7) {
                $weeks[] = $week;
                $week = [];
            }
        }

        return $weeks;
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

        $kelas->load([
            'mentor',
            'program',
            'materis' => fn ($query) => $query->latest(),
            'tugas' => fn ($query) => $query->latest()->with(['submissions' => fn ($submissionQuery) => $submissionQuery->where('peserta_id', auth()->id())->latest()]),
            'quizzes' => fn ($query) => $query->latest(),
        ]);

        $materiPembelajaran = $kelas->materis->reject(function ($materi): bool {
            return str_starts_with(strtolower($materi->judul), 'diskusi:');
        })->values();

        $diskusiKelas = $kelas->materis->filter(function ($materi): bool {
            return str_starts_with(strtolower($materi->judul), 'diskusi:');
        })->values();

        return view('peserta.kelas.show', [
            'kelas' => $kelas,
            'materiPembelajaran' => $materiPembelajaran,
            'diskusiKelas' => $diskusiKelas,
            'enrollment' => $enrollment,
        ]);
    }

    public function submitTugas(StoreTugasSubmissionRequest $request, Kelas $kelas, Tugas $tugas): RedirectResponse
    {
        $enrollment = KelasEnrollment::where('peserta_id', auth()->id())
            ->where('kelas_id', $kelas->id)
            ->first();

        if (! $enrollment) {
            abort(403, 'Anda tidak terdaftar di kelas ini.');
        }

        if ((int) $tugas->kelas_id !== (int) $kelas->id) {
            abort(404);
        }

        $existingSubmission = TugasSubmission::where('tugas_id', $tugas->id)
            ->where('peserta_id', auth()->id())
            ->first();

        if ($existingSubmission?->file) {
            Storage::disk('public')->delete($existingSubmission->file);
        }

        $storedFile = $request->file('file')->store('tugas-submissions', 'public');

        TugasSubmission::updateOrCreate(
            [
                'tugas_id' => $tugas->id,
                'peserta_id' => auth()->id(),
            ],
            [
                'file' => $storedFile,
                'komentar' => $request->validated('komentar'),
                'submitted_at' => now(),
            ]
        );

        return back()->with('status', 'Tugas berhasil dikumpulkan.');
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
