<x-layouts.app>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Jadwal Kelas') }}
        </h2>
    </x-slot>

    @php
        $scheduleDays = [
            'semua' => 'Semua Hari',
            'senin' => 'Senin',
            'selasa' => 'Selasa',
            'rabu' => 'Rabu',
            'kamis' => 'Kamis',
            'jumat' => 'Jumat',
            'sabtu' => 'Sabtu',
            'minggu' => 'Minggu',
        ];

        $selectedDay = request('hari', 'semua');
        $selectedDayLabel = $scheduleDays[$selectedDay] ?? $scheduleDays['semua'];

        $totalClasses = $enrolledClasses->count();
        $scheduledClasses = $enrolledClasses->filter(fn ($enrollment) => $enrollment->kelas->jadwal_hari_label || $enrollment->kelas->jadwal_jam_label);
        $unscheduledClasses = $totalClasses - $scheduledClasses->count();
        $visibleClasses = $selectedDay === 'semua'
            ? $enrolledClasses
            : $enrolledClasses->filter(fn ($enrollment) => $enrollment->kelas->jadwal_hari === $selectedDay);

        $classesByDay = $enrolledClasses
            ->filter(fn ($enrollment) => $enrollment->kelas->jadwal_hari)
            ->groupBy('kelas.jadwal_hari')
            ->map->count();
    @endphp

    <div class="bg-slate-50 py-8 sm:py-10">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            <section class="overflow-hidden rounded-none border border-sky-700 bg-gradient-to-r from-sky-700 via-sky-600 to-cyan-500 p-6 text-white shadow-lg shadow-sky-300/20 sm:p-8">
                <div class="space-y-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.36em] text-sky-200/80">Jadwal Peserta</p>
                    <div class="space-y-2">
                        <h3 class="text-3xl font-bold sm:text-4xl">Jadwal Kelas yang Diikuti</h3>
                        <p class="max-w-2xl text-sm leading-6 text-sky-100/90">Lihat jadwal hari dan jam kelas yang sudah diatur admin. Tampilan ini dibuat lebih rapi agar jadwal setiap kelas mudah dibaca.</p>
                    </div>

                    <div class="flex flex-wrap gap-2 text-xs font-semibold uppercase tracking-[0.16em] text-white/90">
                        <span class="rounded-none border border-white/25 bg-white/10 px-3 py-1">{{ $totalClasses }} Kelas</span>
                        <span class="rounded-none border border-white/25 bg-white/10 px-3 py-1">{{ $scheduledClasses->count() }} Terjadwal</span>
                        <span class="rounded-none border border-white/25 bg-white/10 px-3 py-1">{{ $unscheduledClasses }} Belum Lengkap</span>
                        <span class="rounded-none border border-white/25 bg-white/10 px-3 py-1">{{ $selectedDayLabel }}</span>
                    </div>
                </div>
            </section>

            <section class="rounded-none border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Filter Hari</p>
                        <h4 class="mt-2 text-lg font-bold text-slate-900">Pilih hari untuk melihat kelas yang cocok</h4>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        @foreach ($scheduleDays as $value => $label)
                            <a
                                href="{{ route('peserta.jadwal', $value === 'semua' ? [] : ['hari' => $value]) }}"
                                class="inline-flex items-center gap-2 rounded-none border px-4 py-2 text-sm font-semibold transition {{ $selectedDay === $value ? 'border-sky-700 bg-sky-700 text-white shadow-sm' : 'border-slate-200 bg-slate-50 text-slate-700 hover:border-sky-300 hover:bg-sky-50 hover:text-sky-800' }}"
                            >
                                <span>{{ $label }}</span>
                                @if ($value !== 'semua' && isset($classesByDay[$value]))
                                    <span class="text-xs {{ $selectedDay === $value ? 'text-sky-100' : 'text-slate-500' }}">{{ $classesByDay[$value] }}</span>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>
            </section>

            <section class="grid gap-6 xl:grid-cols-[1.35fr_0.65fr]">
                <div class="rounded-none border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex flex-col gap-2 border-b border-slate-200 pb-4 sm:flex-row sm:items-end sm:justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Daftar Jadwal</p>
                            <h4 class="mt-2 text-2xl font-bold text-slate-900">{{ $selectedDayLabel === 'Semua Hari' ? 'Kelas yang Diikuti' : 'Kelas Hari '.$selectedDayLabel }}</h4>
                        </div>
                        <p class="text-sm text-slate-500">Menampilkan {{ $selectedDayLabel === 'Semua Hari' ? 'semua kelas' : 'kelas hari '.$selectedDayLabel }} yang diatur admin.</p>
                    </div>

                    @if ($visibleClasses->count() > 0)
                        <div class="mt-6 grid gap-4 md:grid-cols-2 xl:grid-cols-1">
                            @foreach ($visibleClasses as $enrollment)
                                <article class="rounded-none border border-slate-200 bg-slate-50 p-5 shadow-sm transition hover:border-sky-300 hover:bg-white">
                                    <div class="flex flex-col gap-4 xl:flex-row xl:items-start xl:justify-between">
                                        <div class="min-w-0 flex-1">
                                            <div class="flex flex-wrap items-center gap-2">
                                                <h5 class="text-lg font-semibold text-slate-900">{{ $enrollment->kelas->nama }}</h5>
                                                <span class="rounded-none border px-2.5 py-1 text-[11px] font-semibold uppercase tracking-[0.18em] {{ $enrollment->status === 'aktif' ? 'border-emerald-200 bg-emerald-50 text-emerald-700' : ($enrollment->status === 'selesai' ? 'border-blue-200 bg-blue-50 text-blue-700' : 'border-slate-200 bg-slate-100 text-slate-600') }}">
                                                    {{ ucfirst($enrollment->status) }}
                                                </span>
                                            </div>
                                            <p class="mt-2 text-sm leading-6 text-slate-600">Mentor: {{ $enrollment->kelas->mentor->name }}</p>
                                            <p class="mt-1 text-sm text-slate-600">Program: {{ $enrollment->kelas->program->nama }}</p>
                                        </div>

                                        <div class="grid min-w-[220px] gap-3 sm:grid-cols-2 xl:w-auto xl:min-w-[280px] xl:grid-cols-1">
                                            <div class="rounded-none border border-slate-200 bg-white px-4 py-3">
                                                <p class="text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-500">Hari</p>
                                                <p class="mt-1 text-base font-semibold text-slate-900">{{ $enrollment->kelas->jadwal_hari_label ?? 'Belum ditentukan' }}</p>
                                            </div>
                                            <div class="rounded-none border border-slate-200 bg-white px-4 py-3">
                                                <p class="text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-500">Jam</p>
                                                <p class="mt-1 text-base font-semibold text-slate-900">{{ $enrollment->kelas->jadwal_jam_label ?? 'Belum ditentukan' }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    @if (! $enrollment->kelas->jadwal_hari_label && ! $enrollment->kelas->jadwal_jam_label)
                                        <div class="mt-4 rounded-none border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800">
                                            Jadwal kelas ini belum diatur admin.
                                        </div>
                                    @endif
                                </article>
                            @endforeach
                        </div>
                    @else
                        <div class="mt-6 rounded-none border border-dashed border-slate-300 bg-slate-50 px-4 py-10 text-center text-slate-600">
                            @if ($enrolledClasses->count() === 0)
                                Anda belum terdaftar di kelas manapun.
                            @else
                                Tidak ada kelas yang dijadwalkan pada hari {{ $selectedDayLabel }}.
                            @endif
                        </div>
                    @endif
                </div>

                <aside class="space-y-6">
                    <div class="rounded-none border border-slate-200 bg-white p-6 shadow-sm">
                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-500">Ringkasan</p>
                        <div class="mt-4 space-y-3 text-sm text-slate-700">
                            <div class="flex items-center justify-between rounded-none border border-slate-200 bg-slate-50 px-4 py-3">
                                <span>Total kelas</span>
                                <span class="font-semibold text-slate-900">{{ $totalClasses }}</span>
                            </div>
                            <div class="flex items-center justify-between rounded-none border border-slate-200 bg-slate-50 px-4 py-3">
                                <span>Jadwal lengkap</span>
                                <span class="font-semibold text-slate-900">{{ $scheduledClasses->count() }}</span>
                            </div>
                            <div class="flex items-center justify-between rounded-none border border-slate-200 bg-slate-50 px-4 py-3">
                                <span>Belum lengkap</span>
                                <span class="font-semibold text-slate-900">{{ $unscheduledClasses }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-none border border-sky-100 bg-blue-950 p-6 text-white shadow-sm">
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-blue-200">Catatan Peserta</p>
                        <p class="mt-3 text-sm leading-6 text-blue-100/90">
                            Pilih hari di atas untuk langsung melihat kelas yang berjalan pada hari tersebut. Jika admin belum mengisi jadwal, kelas tetap muncul sebagai belum ditentukan.
                        </p>
                    </div>
                </aside>
            </section>
        </div>
    </div>
</x-layouts.app>