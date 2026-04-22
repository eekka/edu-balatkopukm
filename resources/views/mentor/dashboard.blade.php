<x-layouts.app>
    <div class="min-h-full bg-slate-100">
        <div class="space-y-6 p-4 sm:p-6 lg:p-8">
            <section class="relative overflow-hidden rounded-none border border-blue-900 bg-gradient-to-r from-blue-950 via-blue-900 to-blue-800 px-6 py-8 text-white sm:px-8">
                <div class="absolute -right-20 -top-20 h-52 w-52 rotate-12 rounded-none bg-white/10"></div>
                <div class="absolute right-28 top-4 h-40 w-40 -rotate-12 rounded-none bg-white/5"></div>
                <div class="absolute left-1/2 top-3 h-24 w-44 -translate-x-1/2 rotate-6 rounded-none bg-white/10"></div>

                <div class="relative flex flex-col gap-5 md:flex-row md:items-end md:justify-between">
                    <div>
                        <p class="text-sm font-semibold text-blue-200">Dashboard Mentor</p>
                        <h1 class="mt-1 text-3xl font-extrabold tracking-tight">Dashboard</h1>
                        <p class="mt-2 max-w-2xl text-sm text-blue-100">
                            Kelola kelas, peserta, materi, dan evaluasi belajar dari panel mentor yang lebih rapi.
                        </p>
                    </div>

                    <div class="grid w-full gap-3 text-right sm:w-auto sm:grid-cols-3">
                        <div class="rounded-none bg-white/10 px-4 py-3 backdrop-blur-sm">
                            <p class="text-xs uppercase tracking-[0.2em] text-blue-100">Kelas</p>
                            <p class="mt-1 text-2xl font-bold">{{ $totalClasses }}</p>
                        </div>
                        <div class="rounded-none bg-white/10 px-4 py-3 backdrop-blur-sm">
                            <p class="text-xs uppercase tracking-[0.2em] text-blue-100">Peserta</p>
                            <p class="mt-1 text-2xl font-bold">{{ $totalPeserta }}</p>
                        </div>
                        <div class="rounded-none bg-white/10 px-4 py-3 backdrop-blur-sm">
                            <p class="text-xs uppercase tracking-[0.2em] text-blue-100">Kelas Aktif</p>
                            <p class="mt-1 text-2xl font-bold">{{ $activeClasses }}</p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="grid gap-4 lg:grid-cols-4">
                <article class="rounded-none border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Kelas Dikelola</p>
                    <p class="mt-2 text-3xl font-black tracking-tight text-slate-900">{{ $totalClasses }}</p>
                    <p class="mt-2 text-sm text-slate-500">Semua kelas di bawah mentor Anda</p>
                </article>

                <article class="rounded-none border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Peserta Aktif</p>
                    <p class="mt-2 text-3xl font-black tracking-tight text-slate-900">{{ $totalPeserta }}</p>
                    <p class="mt-2 text-sm text-slate-500">Total peserta pada kelas Anda</p>
                </article>

                <article class="rounded-none border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Materi & Tugas</p>
                    <p class="mt-2 text-3xl font-black tracking-tight text-slate-900">{{ $activeClasses }}</p>
                    <p class="mt-2 text-sm text-slate-500">Kelas aktif untuk pembaruan konten</p>
                </article>

                <article class="rounded-none border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Aksi Cepat</p>
                    <p class="mt-2 text-3xl font-black tracking-tight text-slate-900">3</p>
                    <p class="mt-2 text-sm text-slate-500">Kelas, pengumuman, dan evaluasi</p>
                </article>
            </section>

            <section class="rounded-none border border-slate-200 bg-white p-5 shadow-sm sm:p-6" id="timeline">
                <div class="mb-5 flex items-center justify-between">
                    <h2 class="text-2xl font-semibold text-slate-800">Timeline</h2>
                </div>

                <div class="grid gap-6 lg:grid-cols-2">
                    <div>
                        <h3 class="mb-3 text-sm font-semibold uppercase tracking-[0.16em] text-slate-500">Kelas Terbaru</h3>
                        <div class="space-y-3">
                            @forelse ($recentClasses as $kelas)
                                <article class="rounded-none border border-slate-200 bg-slate-50 p-4">
                                    <div class="flex items-start justify-between gap-3">
                                        <div class="min-w-0">
                                            <p class="truncate text-sm font-semibold text-slate-900">{{ $kelas->nama }}</p>
                                            <p class="truncate text-xs text-slate-500">{{ $kelas->program?->nama ?? '-' }}</p>
                                        </div>
                                        <span class="inline-flex rounded-none px-2 py-1 text-xs font-semibold {{ $kelas->status === 'aktif' ? 'bg-emerald-100 text-emerald-700' : ($kelas->status === 'draft' ? 'bg-amber-100 text-amber-700' : 'bg-slate-200 text-slate-700') }}">
                                            {{ ucfirst($kelas->status) }}
                                        </span>
                                    </div>
                                    <p class="mt-2 text-xs text-slate-500">{{ $kelas->created_at->diffForHumans() }}</p>
                                </article>
                            @empty
                                <div class="rounded-none border border-dashed border-slate-200 bg-slate-50 px-4 py-6 text-center text-sm text-slate-500">
                                    Belum ada kelas terbaru.
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div>
                        <h3 class="mb-3 text-sm font-semibold uppercase tracking-[0.16em] text-slate-500">Pengumuman</h3>
                        <div class="space-y-3">
                            @forelse ($recentAnnouncements as $announcement)
                                <article class="rounded-none border border-slate-200 bg-slate-50 p-4">
                                    <div class="flex items-start justify-between gap-3">
                                        <div class="min-w-0">
                                            <p class="truncate text-sm font-semibold text-slate-900">{{ $announcement->judul }}</p>
                                            <p class="truncate text-xs text-slate-500">{{ $announcement->creator?->name ?? 'Admin' }}</p>
                                        </div>
                                        <span class="inline-flex rounded-none bg-sky-100 px-2 py-1 text-xs font-semibold text-sky-700">{{ ucfirst($announcement->target) }}</span>
                                    </div>
                                    <p class="mt-2 line-clamp-2 text-xs leading-5 text-slate-500">{{ $announcement->isi }}</p>
                                </article>
                            @empty
                                <div class="rounded-none border border-dashed border-slate-200 bg-slate-50 px-4 py-6 text-center text-sm text-slate-500">
                                    Belum ada pengumuman.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </section>

            <section class="rounded-none border border-slate-200 bg-white p-5 shadow-sm sm:p-6" id="calendar">
                <div class="mb-5 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <h2 class="text-2xl font-semibold text-slate-800">Calendar</h2>
                    <a href="{{ route('mentor.kelas.index') }}" class="inline-flex items-center justify-center rounded-none bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-700">
                        New event
                    </a>
                </div>

                <div class="mb-4">
                    <select class="w-full max-w-xs rounded-none border border-slate-300 bg-white px-3 py-2 text-sm text-slate-700" aria-label="Filter kalender mentor">
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

            <section class="grid gap-4 lg:grid-cols-[1.3fr_0.7fr]" id="kelas-saya">
                <div class="rounded-none border border-slate-200 bg-white shadow-sm">
                    <div class="border-b border-slate-200 px-5 py-4 sm:px-6">
                        <h2 class="text-base font-semibold text-slate-900">Kelas Saya</h2>
                        <p class="mt-1 text-sm text-slate-500">Ringkasan kelas yang Anda tangani</p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Nama Kelas</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Program</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Peserta</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200 bg-white">
                                @forelse ($myClasses as $kelas)
                                    <tr class="hover:bg-blue-50/40">
                                        <td class="px-6 py-4">
                                            <p class="font-semibold text-slate-900">{{ $kelas->nama }}</p>
                                            <p class="mt-1 text-xs text-slate-500">{{ $kelas->kapasitas }} kapasitas</p>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-slate-600">{{ $kelas->program?->nama ?? '-' }}</td>
                                        <td class="px-6 py-4 text-sm font-semibold text-slate-900">{{ $kelas->enrollments->count() }} / {{ $kelas->kapasitas }}</td>
                                        <td class="px-6 py-4">
                                            <span class="inline-flex rounded-none px-3 py-1 text-xs font-semibold {{ $kelas->status === 'aktif' ? 'bg-emerald-100 text-emerald-700' : ($kelas->status === 'draft' ? 'bg-amber-100 text-amber-700' : 'bg-slate-100 text-slate-600') }}">
                                                {{ ucfirst($kelas->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-10 text-center text-sm text-slate-500">
                                            Belum ada kelas yang ditangani.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="space-y-4" id="akses-cepat">
                    <a href="{{ route('mentor.kelas.index') }}" class="block rounded-none border border-slate-200 bg-white px-4 py-4 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
                        Manajemen Kelas
                    </a>
                    <a href="{{ route('mentor.announcements.index') }}" class="block rounded-none border border-slate-200 bg-white px-4 py-4 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
                        Pengumuman
                    </a>
                    <a href="{{ route('mentor.dashboard') }}" class="block rounded-none border border-slate-200 bg-white px-4 py-4 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
                        Materi, Tugas, Nilai
                    </a>
                </div>
            </section>
        </div>
    </div>
</x-layouts.app>
