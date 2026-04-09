<x-layouts.app>
    <div class="min-h-full bg-slate-100">
        <div class="space-y-6 p-4 sm:p-6 lg:p-8">
            <section class="overflow-hidden rounded-[2rem] border theme-border-primary-soft bg-white shadow-[0_24px_60px_-30px_rgba(37,99,235,0.45)]">
                <div class="grid lg:grid-cols-[1.15fr_0.85fr]">
                    <div class="px-6 py-7 text-white sm:px-8 sm:py-8" style="background-image: linear-gradient(135deg, var(--primary-dark), var(--primary), var(--primary-light));">
                        <div class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.22em] text-white/90">
                            Learning Control Center
                        </div>

                        <div class="mt-5 max-w-2xl space-y-4">
                            <div>
                                <h1 class="text-3xl font-black tracking-tight sm:text-4xl">Dashboard Belajar</h1>
                                <p class="mt-3 max-w-xl text-sm leading-7 text-blue-50/90 sm:text-base">
                                    Pantau kelas, lihat progress, dan masuk ke materi dengan tampilan yang rapi dan fokus.
                                </p>
                            </div>

                            <div class="flex flex-wrap gap-3">
                                <a href="#kelas-saya" class="inline-flex items-center justify-center rounded-2xl bg-white px-4 py-3 text-sm font-semibold theme-text-primary shadow-sm transition hover:bg-[rgba(var(--primary-light-rgb),0.12)]">
                                    Kelas Saya
                                </a>
                                <a href="#pengumuman" class="inline-flex items-center justify-center rounded-2xl border border-white/20 bg-white/10 px-4 py-3 text-sm font-semibold text-white transition hover:bg-white/15">
                                    Pengumuman
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-50 px-6 py-7 sm:px-8 sm:py-8">
                        <div class="grid gap-3 sm:grid-cols-2">
                            <div class="rounded-3xl border border-slate-200 bg-white p-4 shadow-sm">
                                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-500">Kelas Terdaftar</p>
                                <p class="mt-2 text-3xl font-black tracking-tight text-slate-900">{{ $totalClasses }}</p>
                                <p class="mt-2 text-sm text-slate-500">Semua kelas yang Anda ikuti</p>
                            </div>

                            <div class="rounded-3xl border border-slate-200 bg-white p-4 shadow-sm">
                                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-500">Kelas Aktif</p>
                                <p class="mt-2 text-3xl font-black tracking-tight text-slate-900">{{ $activeClasses }}</p>
                                <p class="mt-2 text-sm text-slate-500">Sedang Anda jalani</p>
                            </div>

                            <div class="rounded-3xl border theme-border-primary-soft theme-card-primary p-4 shadow-sm">
                                <p class="text-xs font-semibold uppercase tracking-[0.22em] theme-text-primary">Selesai</p>
                                <p class="mt-2 text-3xl font-black tracking-tight theme-text-primary">{{ $completedClasses }}</p>
                                <p class="mt-2 text-sm text-slate-600">Kelas yang sudah dituntaskan</p>
                            </div>

                            <div class="rounded-3xl border border-blue-100 bg-sky-50 p-4 shadow-sm">
                                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-sky-600">Progress</p>
                                <p class="mt-2 text-3xl font-black tracking-tight text-sky-900">{{ $enrolledClasses->count() }}</p>
                                <p class="mt-2 text-sm text-sky-700/80">Rincian per kelas tersedia</p>
                            </div>
                        </div>

                        <div class="mt-4 rounded-3xl theme-bg-primary-dark px-5 py-5 text-white shadow-[0_20px_40px_-24px_rgba(15,23,42,0.9)]">
                            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-white/80">Fokus Belajar</p>
                            <p class="mt-2 text-sm leading-6 text-white/80">
                                Gunakan kelas yang tersedia, ikuti arahan mentor, dan pantau pencapaian Anda secara berkala.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="grid gap-4 md:grid-cols-3">
                <article class="rounded-3xl border border-blue-100 bg-white p-5 shadow-sm">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Materi</p>
                            <p class="mt-2 text-3xl font-black tracking-tight text-slate-900">{{ $totalClasses }}</p>
                            <p class="mt-2 text-sm text-slate-500">Akses materi dari kelas aktif</p>
                        </div>
                        <div class="flex size-14 items-center justify-center rounded-2xl bg-blue-600 text-2xl text-white shadow-sm">
                            M
                        </div>
                    </div>
                </article>

                <article class="rounded-3xl border border-blue-100 bg-white p-5 shadow-sm">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Kehadiran</p>
                            <p class="mt-2 text-3xl font-black tracking-tight text-slate-900">{{ $activeClasses }}</p>
                            <p class="mt-2 text-sm text-slate-500">Ikuti sesi yang berjalan</p>
                        </div>
                        <div class="flex size-14 items-center justify-center rounded-2xl bg-sky-500 text-2xl text-white shadow-sm">
                            K
                        </div>
                    </div>
                </article>

                <article class="rounded-3xl border border-blue-100 bg-white p-5 shadow-sm">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Nilai</p>
                            <p class="mt-2 text-3xl font-black tracking-tight text-slate-900">{{ $completedClasses }}</p>
                            <p class="mt-2 text-sm text-slate-500">Pantau hasil akhir kelas</p>
                        </div>
                        <div class="flex size-14 items-center justify-center rounded-2xl bg-blue-400 text-2xl text-white shadow-sm">
                            N
                        </div>
                    </div>
                </article>
            </section>

            <section id="kelas-saya" class="grid gap-6 xl:grid-cols-[1.35fr_0.65fr]">
                <div class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm">
                    <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4 sm:px-6">
                        <div>
                            <h2 class="text-base font-semibold text-slate-900">Kelas Saya</h2>
                            <p class="mt-1 text-sm text-slate-500">Status belajar, mentor, dan capaian singkat</p>
                        </div>
                    </div>

                    <div class="divide-y divide-slate-200">
                        @forelse ($enrolledClasses as $enrollment)
                            <div class="px-5 py-5 sm:px-6 hover:bg-blue-50/30">
                                <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                                    <div class="flex-1">
                                        <h3 class="text-lg font-semibold text-slate-900">{{ $enrollment->kelas->nama }}</h3>
                                        <p class="mt-1 text-sm text-slate-600">Program: {{ $enrollment->kelas->program->nama }}</p>
                                        <p class="mt-1 text-sm text-slate-600">Mentor: {{ $enrollment->kelas->mentor->name }}</p>
                                        <div class="mt-3 flex flex-wrap items-center gap-3">
                                            <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $enrollment->status === 'aktif' ? 'bg-emerald-100 text-emerald-700' : ($enrollment->status === 'selesai' ? 'bg-blue-100 text-blue-700' : 'bg-slate-100 text-slate-600') }}">
                                                {{ ucfirst($enrollment->status) }}
                                            </span>
                                            @if ($enrollment->nilai_akhir)
                                                <span class="inline-flex rounded-full bg-sky-100 px-3 py-1 text-xs font-semibold text-sky-700">
                                                    Nilai: {{ $enrollment->nilai_akhir }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="rounded-3xl bg-slate-50 px-5 py-4 text-left lg:text-right">
                                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Kehadiran</p>
                                        <p class="mt-1 text-3xl font-black tracking-tight text-blue-700">{{ $enrollment->kehadiran }}%</p>
                                        <p class="mt-2 text-xs text-slate-500">Terdaftar sejak {{ $enrollment->terdaftar_pada?->format('d M Y') }}</p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="px-6 py-12 text-center text-slate-500">
                                Belum ada kelas yang diikuti.
                            </div>
                        @endforelse
                    </div>
                </div>

                <div id="pengumuman" class="space-y-6">
                    <div class="overflow-hidden rounded-[2rem] border border-blue-100 bg-blue-950 text-white shadow-sm">
                        <div class="border-b border-white/10 px-5 py-4 sm:px-6">
                            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-blue-200">Pengumuman</p>
                            <h2 class="mt-2 text-xl font-semibold">Info terbaru dari admin.</h2>
                        </div>

                        <div class="space-y-3 p-5 sm:p-6">
                            @forelse ($recentAnnouncements as $announcement)
                                <div class="rounded-2xl bg-white/10 px-4 py-3">
                                    <div class="flex items-start justify-between gap-3">
                                        <div class="min-w-0">
                                            <p class="truncate text-sm font-semibold text-white">{{ $announcement->judul }}</p>
                                            <p class="mt-1 truncate text-xs text-blue-100/80">{{ $announcement->creator?->name ?? 'Admin' }}</p>
                                        </div>
                                        <span class="rounded-full bg-white/15 px-2.5 py-1 text-xs font-semibold text-white">{{ ucfirst($announcement->target) }}</span>
                                    </div>
                                    <p class="mt-2 line-clamp-2 text-xs leading-5 text-blue-100/85">{{ $announcement->isi }}</p>
                                </div>
                            @empty
                                <div class="rounded-2xl bg-white/10 px-4 py-6 text-sm text-blue-100/90">
                                    Belum ada pengumuman untuk peserta.
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div class="rounded-[2rem] border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Akses Cepat</p>
                        <div class="mt-4 grid gap-3">
                            <a href="{{ route('peserta.kelas.index') }}" class="flex items-center justify-between rounded-2xl bg-blue-50 px-4 py-3 text-sm font-semibold text-blue-700 transition hover:bg-blue-100">
                                <span>Cari Kelas Baru</span>
                                <span>→</span>
                            </a>
                            <a href="{{ route('peserta.jadwal') }}" class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-100">
                                <span>Jadwal Kelas</span>
                                <span>→</span>
                            </a>
                            <a href="{{ route('peserta.sertifikat') }}" class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-100">
                                <span>Sertifikat</span>
                                <span>→</span>
                            </a>
                            <a href="{{ route('peserta.progress') }}" class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-100">
                                <span>Progress</span>
                                <span>→</span>
                            </a>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-layouts.app>
