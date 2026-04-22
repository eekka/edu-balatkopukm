<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Kelas;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $mentorId = auth()->id();
        $calendarDate = now();

        $myClasses = Kelas::where('mentor_id', $mentorId)
            ->with(['program', 'enrollments'])
            ->latest()
            ->get();

        $recentClasses = Kelas::where('mentor_id', $mentorId)
            ->with(['program', 'enrollments'])
            ->latest()
            ->limit(4)
            ->get();

        return view('mentor.dashboard', [
            'myClasses' => $myClasses,
            'totalClasses' => $myClasses->count(),
            'totalPeserta' => $myClasses->sum(fn (Kelas $kelas): int => $kelas->enrollments->count()),
            'activeClasses' => $myClasses->where('status', 'aktif')->count(),
            'recentClasses' => $recentClasses,
            'recentAnnouncements' => Announcement::with('creator')
                ->visibleTo(auth()->user())
                ->latest()
                ->limit(4)
                ->get(),
            'calendarMonthLabel' => $calendarDate->translatedFormat('F Y'),
            'calendarWeeks' => $this->buildCalendarWeeks($calendarDate, $myClasses),
            'calendarPreviousMonthLabel' => $calendarDate->copy()->subMonth()->translatedFormat('F'),
            'calendarNextMonthLabel' => $calendarDate->copy()->addMonth()->translatedFormat('F'),
        ]);
    }

    private function buildCalendarWeeks(Carbon $month, Collection $mentorClasses): array
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

        $scheduledDayNumbers = $mentorClasses
            ->where('status', 'aktif')
            ->pluck('jadwal_hari')
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
}
