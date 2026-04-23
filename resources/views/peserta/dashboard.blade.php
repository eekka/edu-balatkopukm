<x-layouts.app>
    <div class="min-h-full bg-slate-100">
        <div class="space-y-6 p-4 sm:p-6 lg:p-8">
            <section class="relative overflow-hidden rounded-none border border-blue-900 bg-gradient-to-r from-blue-950 via-blue-900 to-blue-800 px-6 py-8 text-white sm:px-8">
                <div class="absolute -right-20 -top-20 h-52 w-52 rotate-12 rounded-none bg-white/10"></div>
                <div class="absolute right-28 top-4 h-40 w-40 -rotate-12 rounded-none bg-white/5"></div>
                <div class="absolute left-1/2 top-3 h-24 w-44 -translate-x-1/2 rotate-6 rounded-none bg-white/10"></div>

                <div class="relative flex flex-col gap-5 md:flex-row md:items-end md:justify-between">
                    <div>
                        <p class="text-sm font-semibold text-blue-200">Dashboard</p>
                        <h1 class="mt-1 text-3xl font-extrabold tracking-tight">Dashboard</h1>
                    </div>

                    <div class="grid w-full gap-3 text-right sm:w-auto sm:grid-cols-3">
                        <div class="rounded-none bg-white/10 px-4 py-3 backdrop-blur-sm">
                            <p class="text-xs uppercase tracking-[0.2em] text-blue-100">Terdaftar</p>
                            <p class="mt-1 text-2xl font-bold">{{ $totalClasses }}</p>
                        </div>
                        <div class="rounded-none bg-white/10 px-4 py-3 backdrop-blur-sm">
                            <p class="text-xs uppercase tracking-[0.2em] text-blue-100">Aktif</p>
                            <p class="mt-1 text-2xl font-bold">{{ $activeClasses }}</p>
                        </div>
                        <div class="rounded-none bg-white/10 px-4 py-3 backdrop-blur-sm">
                            <p class="text-xs uppercase tracking-[0.2em] text-blue-100">Selesai</p>
                            <p class="mt-1 text-2xl font-bold">{{ $completedClasses }}</p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="rounded-none border border-slate-200 bg-white p-5 shadow-sm sm:p-6" id="timeline">
                <div class="mb-5 flex items-center justify-between">
                    <h2 class="text-2xl font-semibold text-slate-800">Timeline</h2>
                </div>

                <div class="grid gap-3 md:grid-cols-[auto_auto_1fr] md:items-center">
                    <select class="rounded-none border border-slate-300 bg-white px-3 py-2 text-sm text-slate-700" aria-label="Rentang waktu timeline">
                        <option>Next 7 days</option>
                        <option>Today</option>
                        <option>This month</option>
                    </select>

                    <select class="rounded-none border border-slate-300 bg-white px-3 py-2 text-sm text-slate-700" aria-label="Urutkan timeline">
                        <option>Sort by dates</option>
                        <option>Sort by type</option>
                    </select>

                    <input
                        type="search"
                        id="timeline-search"
                        class="rounded-none border border-slate-300 px-3 py-2 text-sm text-slate-700"
                        placeholder="Search by activity type or name"
                    >
                </div>

                <div class="mt-6">
                    @if ($timelineItems->isEmpty())
                        <div class="flex flex-col items-center justify-center gap-2 py-10 text-center text-slate-400">
                            <div class="flex h-12 w-12 items-center justify-center rounded-none bg-slate-100 text-xl font-bold">TL</div>
                            <p class="text-sm font-semibold">No activities require action</p>
                        </div>
                    @else
                        <div class="space-y-3" id="timeline-list">
                            @foreach ($timelineItems as $item)
                                <article data-timeline-item class="rounded-none border border-slate-200 bg-slate-50 p-4">
                                    <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">
                                        <div>
                                            <p class="text-xs font-semibold uppercase tracking-[0.14em] text-blue-700">{{ $item['type'] }}</p>
                                            <h3 class="mt-1 text-base font-semibold text-slate-900">{{ $item['title'] }}</h3>
                                            <p class="mt-1 text-sm text-slate-600">{{ $item['description'] }}</p>
                                        </div>
                                        <div class="text-xs text-slate-500 sm:text-right">
                                            <p>{{ $item['date'] }}</p>
                                            <span class="mt-1 inline-flex rounded-none bg-blue-100 px-2 py-1 font-semibold text-blue-700">{{ $item['target'] }}</span>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>

                        <div id="timeline-empty-search" class="hidden py-8 text-center text-sm text-slate-500">
                            Tidak ada aktivitas yang sesuai dengan pencarian.
                        </div>
                    @endif
                </div>
            </section>

            <!-- Akses Cepat -->
            <section class="grid gap-4 lg:grid-cols-4">
                <a href="{{ route('peserta.presensi.index') }}" class="rounded-none border border-slate-200 bg-white p-4 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
                    Konfirmasi Kehadiran
                </a>
                <a href="{{ route('peserta.kelas.index') }}" class="rounded-none border border-slate-200 bg-white p-4 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
                    Cari Kelas Baru
                </a>
                <a href="{{ route('peserta.progress') }}" class="rounded-none border border-slate-200 bg-white p-4 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
                    Progress Belajar
                </a>
                <a href="{{ route('peserta.announcements.index') }}" class="rounded-none border border-slate-200 bg-white p-4 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
                    Semua Pengumuman
                </a>
            </section>

            <section class="rounded-none border border-slate-200 bg-white p-5 shadow-sm sm:p-6" id="calendar">
                <div class="mb-5 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <h2 class="text-2xl font-semibold text-slate-800">Calendar</h2>
                    <a href="{{ route('peserta.jadwal') }}" class="inline-flex items-center justify-center rounded-none bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-700">
                        New event
                    </a>
                </div>

                <div class="mb-4">
                    <select class="w-full max-w-xs rounded-none border border-slate-300 bg-white px-3 py-2 text-sm text-slate-700" aria-label="Filter kelas kalender">
                        <option>All courses</option>
                    </select>
                </div>

                <div class="mb-3 flex items-center justify-between text-sm text-slate-500">
                    <span>&lsaquo; {{ $calendarPreviousMonthLabel }}</span>
                    <h3 class="text-2xl font-semibold text-slate-800">{{ $calendarMonthLabel }}</h3>
                    <span>{{ $calendarNextMonthLabel }} &rsaquo;</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full min-w-[700px] border-separate border-spacing-0 text-center text-sm">
                        <thead>
                            <tr class="text-slate-700">
                                <th class="border-b border-slate-200 px-2 py-2">Mon</th>
                                <th class="border-b border-slate-200 px-2 py-2">Tue</th>
                                <th class="border-b border-slate-200 px-2 py-2">Wed</th>
                                <th class="border-b border-slate-200 px-2 py-2">Thu</th>
                                <th class="border-b border-slate-200 px-2 py-2">Fri</th>
                                <th class="border-b border-slate-200 px-2 py-2">Sat</th>
                                <th class="border-b border-slate-200 px-2 py-2">Sun</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($calendarWeeks as $week)
                                <tr>
                                    @foreach ($week as $day)
                                        <td class="h-16 border-b border-r border-slate-100 align-top">
                                            @if ($day)
                                                <div class="mx-auto mt-2 flex w-fit items-center justify-center">
                                                    <span class="inline-flex h-7 w-7 items-center justify-center rounded-none text-sm font-semibold {{ $day['isToday'] ? 'bg-blue-600 text-white' : 'text-slate-600' }}">
                                                        {{ $day['day'] }}
                                                    </span>
                                                </div>
                                                @if ($day['hasClass'])
                                                    <div class="mx-auto mt-1 h-1.5 w-1.5 rounded-none bg-blue-500"></div>
                                                @endif
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 flex flex-wrap gap-2 text-xs text-slate-600">
                    <span class="inline-flex items-center gap-1 rounded-none bg-blue-50 px-3 py-1"><span class="h-2 w-2 rounded-none bg-blue-600"></span> Hari ini</span>
                    <span class="inline-flex items-center gap-1 rounded-none bg-slate-100 px-3 py-1"><span class="h-2 w-2 rounded-none bg-blue-500"></span> Jadwal kelas aktif</span>
                </div>
            </section>


        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('timeline-search');
            const items = Array.from(document.querySelectorAll('[data-timeline-item]'));
            const emptySearch = document.getElementById('timeline-empty-search');

            if (!searchInput || items.length === 0 || !emptySearch) {
                return;
            }

            searchInput.addEventListener('input', function () {
                const query = searchInput.value.trim().toLowerCase();
                let visibleCount = 0;

                items.forEach(function (item) {
                    const text = item.textContent.toLowerCase();
                    const isVisible = text.includes(query);
                    item.classList.toggle('hidden', !isVisible);

                    if (isVisible) {
                        visibleCount++;
                    }
                });

                emptySearch.classList.toggle('hidden', visibleCount > 0);
            });
        });
    </script>
</x-layouts.app>
