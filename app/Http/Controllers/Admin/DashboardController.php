<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Kelas;
use App\Models\Program;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $calendarDate = now();
        $recentClasses = Kelas::with('program')->latest()->limit(5)->get();

        return view('admin.dashboard', [
            'totalUsers' => User::count(),
            'totalAdmins' => User::where('role', 'admin')->count(),
            'totalMentors' => User::where('role', 'mentor')->count(),
            'totalPeserta' => User::where('role', 'peserta')->count(),
            'totalPrograms' => Program::count(),
            'totalClasses' => Kelas::count(),
            'activeClasses' => Kelas::where('status', 'aktif')->count(),
            'totalAnnouncements' => Announcement::count(),
            'recentClasses' => $recentClasses,
            'recentAnnouncements' => Announcement::with('creator')->latest()->limit(4)->get(),
            'calendarMonthLabel' => $calendarDate->translatedFormat('F Y'),
            'calendarWeeks' => $this->buildCalendarWeeks($calendarDate),
            'calendarPreviousMonthLabel' => $calendarDate->copy()->subMonth()->translatedFormat('F'),
            'calendarNextMonthLabel' => $calendarDate->copy()->addMonth()->translatedFormat('F'),
        ]);
    }

    private function buildCalendarWeeks(Carbon $month): array
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

        $scheduledDayNumbers = Kelas::query()
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
