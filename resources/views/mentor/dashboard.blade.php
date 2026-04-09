<x-layouts.app>
    <div class="min-h-full bg-slate-100">
        <div class="space-y-6 p-4 sm:p-6 lg:p-8">
            <section class="overflow-hidden rounded-[2rem] border border-blue-100 bg-white shadow-[0_24px_60px_-30px_rgba(37,99,235,0.45)]">
                <div class="grid lg:grid-cols-[1.15fr_0.85fr]">
                    <div class="bg-gradient-to-br from-blue-700 via-blue-600 to-sky-500 px-6 py-7 text-white sm:px-8 sm:py-8">
                        <div class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.22em] text-blue-50">
                            Mentor Control Panel
                        </div>

                        <div class="mt-5 max-w-2xl space-y-4">
                            <div>
                                <h1 class="text-3xl font-black tracking-tight sm:text-4xl">Dashboard Mentor</h1>
                                <p class="mt-3 max-w-xl text-sm leading-7 text-blue-50/90 sm:text-base">
                                    Kelola kelas, pantau peserta, dan atur pembelajaran dari satu panel yang rapi dan fokus.
                                </p>
                            </div>

                            <div class="flex flex-wrap gap-3">
                                <a href="#kelas-saya" class="inline-flex items-center justify-center rounded-2xl bg-white px-4 py-3 text-sm font-semibold text-blue-700 shadow-sm transition hover:bg-blue-50">
                                    Lihat Kelas
                                </a>
                                <a href="#akses-cepat" class="inline-flex items-center justify-center rounded-2xl border border-white/20 bg-white/10 px-4 py-3 text-sm font-semibold text-white transition hover:bg-white/15">
                                    Akses Cepat
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-50 px-6 py-7 sm:px-8 sm:py-8">
                        <div class="grid gap-3 sm:grid-cols-2">
                            <div class="rounded-3xl border border-slate-200 bg-white p-4 shadow-sm">
                                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-500">Kelas Saya</p>
                                <p class="mt-2 text-3xl font-black tracking-tight text-slate-900">{{ $totalClasses }}</p>
                                <p class="mt-2 text-sm text-slate-500">Semua kelas yang Anda kelola</p>
                            </div>

                            <div class="rounded-3xl border border-slate-200 bg-white p-4 shadow-sm">
                                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-500">Peserta</p>
                                <p class="mt-2 text-3xl font-black tracking-tight text-slate-900">{{ $totalPeserta }}</p>
                                <p class="mt-2 text-sm text-slate-500">Total peserta aktif di kelas</p>
                            </div>

                            <div class="rounded-3xl border border-blue-100 bg-blue-50 p-4 shadow-sm">
                                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-blue-600">Kelas Aktif</p>
                                <p class="mt-2 text-3xl font-black tracking-tight text-blue-900">{{ $activeClasses }}</p>
                                <p class="mt-2 text-sm text-blue-700/80">Sedang berjalan sekarang</p>
                            </div>

                            <div class="rounded-3xl border border-blue-100 bg-sky-50 p-4 shadow-sm">
                                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-sky-600">Aksi Mentor</p>
                                <p class="mt-2 text-3xl font-black tracking-tight text-sky-900">3</p>
                                <p class="mt-2 text-sm text-sky-700/80">Materi, tugas, dan nilai</p>
                            </div>
                        </div>

                        <div class="mt-4 rounded-3xl bg-blue-950 px-5 py-5 text-white shadow-[0_20px_40px_-24px_rgba(15,23,42,0.9)]">
                            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-blue-200">Fokus Utama</p>
                            <p class="mt-2 text-sm leading-6 text-blue-100">
                                Pantau kapasitas kelas, sebar materi, kelola tugas, dan nilai peserta dengan alur yang ringkas.
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
                            <p class="mt-2 text-sm text-slate-500">Kelola materi per kelas</p>
                        </div>
                        <div class="flex size-14 items-center justify-center rounded-2xl bg-blue-600 text-2xl text-white shadow-sm">
                            M
                        </div>
                    </div>
                </article>

                <article class="rounded-3xl border border-blue-100 bg-white p-5 shadow-sm">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Tugas</p>
                            <p class="mt-2 text-3xl font-black tracking-tight text-slate-900">{{ $totalClasses }}</p>
                            <p class="mt-2 text-sm text-slate-500">Rilis dan pantau penugasan</p>
                        </div>
                        <div class="flex size-14 items-center justify-center rounded-2xl bg-sky-500 text-2xl text-white shadow-sm">
                            T
                        </div>
                    </div>
                </article>

                <article class="rounded-3xl border border-blue-100 bg-white p-5 shadow-sm">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Nilai</p>
                            <p class="mt-2 text-3xl font-black tracking-tight text-slate-900">{{ $totalPeserta }}</p>
                            <p class="mt-2 text-sm text-slate-500">Rekap capaian peserta</p>
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
                            <p class="mt-1 text-sm text-slate-500">Daftar kelas yang Anda kelola dan jumlah peserta di dalamnya</p>
                        </div>
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
                                            <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $kelas->status === 'aktif' ? 'bg-emerald-100 text-emerald-700' : ($kelas->status === 'draft' ? 'bg-amber-100 text-amber-700' : 'bg-slate-100 text-slate-600') }}">
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

                <div id="akses-cepat" class="space-y-6">
                    <div class="overflow-hidden rounded-[2rem] border border-blue-100 bg-blue-950 text-white shadow-sm">
                        <div class="border-b border-white/10 px-5 py-4 sm:px-6">
                            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-blue-200">Akses Cepat</p>
                            <h2 class="mt-2 text-xl font-semibold">Kelola pembelajaran dengan cepat.</h2>
                        </div>

                        <div class="space-y-3 p-5 sm:p-6">
                            <a href="#" class="flex items-center justify-between rounded-2xl bg-white/10 px-4 py-3 text-sm font-semibold transition hover:bg-white/15">
                                <span>Materi Pembelajaran</span>
                                <span>→</span>
                            </a>
                            <a href="#" class="flex items-center justify-between rounded-2xl bg-white/10 px-4 py-3 text-sm font-semibold transition hover:bg-white/15">
                                <span>Tugas & Kuis</span>
                                <span>→</span>
                            </a>
                            <a href="#" class="flex items-center justify-between rounded-2xl bg-white/10 px-4 py-3 text-sm font-semibold transition hover:bg-white/15">
                                <span>Nilai Peserta</span>
                                <span>→</span>
                            </a>
                        </div>
                    </div>

                    <div class="rounded-[2rem] border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Catatan Cepat</p>
                        <div class="mt-4 space-y-3 text-sm text-slate-600">
                            <div class="rounded-2xl bg-slate-50 px-4 py-3">Periksa kapasitas kelas sebelum membuka pendaftaran baru.</div>
                            <div class="rounded-2xl bg-slate-50 px-4 py-3">Gunakan materi dan kuis untuk menjaga alur belajar tetap terarah.</div>
                            <div class="rounded-2xl bg-slate-50 px-4 py-3">Nilai peserta secara berkala agar progres mudah dipantau.</div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-layouts.app>
