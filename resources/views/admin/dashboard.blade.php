<x-layouts.app>
    <div class="min-h-full bg-slate-100">
        <div class="space-y-6 p-4 sm:p-6 lg:p-8">
            <section class="overflow-hidden rounded-[2rem] border theme-border-primary-soft bg-white shadow-[0_24px_60px_-30px_rgba(37,99,235,0.45)]">
                <div class="grid lg:grid-cols-[1.15fr_0.85fr]">
                    <div class="px-6 py-7 text-white sm:px-8 sm:py-8" style="background-image: linear-gradient(135deg, var(--primary-dark), var(--primary), var(--primary-light));">
                        <div class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.22em] text-white/90">
                            Admin Control Center
                        </div>

                        <div class="mt-5 max-w-2xl space-y-4">
                            <div>
                                <h1 class="text-3xl font-black tracking-tight sm:text-4xl">Dashboard Admin</h1>
                                <p class="mt-3 max-w-xl text-sm leading-7 text-blue-50/90 sm:text-base">
                                    Admin memegang kuasa penuh atas sistem untuk menambah, mengubah, dan menghapus data pada akun, program, kelas, pengumuman, serta laporan.
                                </p>
                            </div>

                            <div class="flex flex-wrap gap-3">
                                <a href="{{ route('admin.users.index') }}" class="inline-flex items-center justify-center rounded-2xl bg-white px-4 py-3 text-sm font-semibold theme-text-primary shadow-sm transition hover:bg-[rgba(var(--primary-light-rgb),0.12)]">
                                    Kelola Akun
                                </a>
                                <a href="{{ route('admin.programs.index') }}" class="inline-flex items-center justify-center rounded-2xl border border-white/20 bg-white/10 px-4 py-3 text-sm font-semibold text-white transition hover:bg-white/15">
                                    Program
                                </a>
                                <a href="{{ route('admin.reports.index') }}" class="inline-flex items-center justify-center rounded-2xl border border-white/20 bg-white/10 px-4 py-3 text-sm font-semibold text-white transition hover:bg-white/15">
                                    Laporan
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-50 px-6 py-7 sm:px-8 sm:py-8">
                        <div class="grid gap-3 sm:grid-cols-2">
                            <div class="rounded-3xl border border-slate-200 bg-white p-4 shadow-sm">
                                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-500">Admin</p>
                                <p class="mt-2 text-3xl font-black tracking-tight text-slate-900">{{ $totalAdmins }}</p>
                                <p class="mt-2 text-sm text-slate-500">Akun pemegang kendali sistem</p>
                            </div>

                            <div class="rounded-3xl border border-slate-200 bg-white p-4 shadow-sm">
                                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-500">Mentor</p>
                                <p class="mt-2 text-3xl font-black tracking-tight text-slate-900">{{ $totalMentors }}</p>
                                <p class="mt-2 text-sm text-slate-500">Pengajar dan pengelola kelas</p>
                            </div>

                            <div class="rounded-3xl border border-slate-200 bg-white p-4 shadow-sm">
                                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-500">Peserta</p>
                                <p class="mt-2 text-3xl font-black tracking-tight text-slate-900">{{ $totalPeserta }}</p>
                                <p class="mt-2 text-sm text-slate-500">Akun pembelajaran aktif</p>
                            </div>

                            <div class="rounded-3xl border theme-border-primary-soft theme-card-primary p-4 shadow-sm">
                                <p class="text-xs font-semibold uppercase tracking-[0.22em] theme-text-primary">Total Akun</p>
                                <p class="mt-2 text-3xl font-black tracking-tight theme-text-primary">{{ $totalUsers }}</p>
                                <p class="mt-2 text-sm text-slate-600">Semua user di platform</p>
                            </div>
                        </div>

                        <div class="mt-4 rounded-3xl theme-bg-primary-dark px-5 py-5 text-white shadow-[0_20px_40px_-24px_rgba(15,23,42,0.9)]">
                            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-white/80">Kendali Penuh</p>
                            <p class="mt-2 text-sm leading-6 text-white/80">
                                Gunakan menu di sisi kiri untuk mengelola akun mentor dan peserta, menata program dan kelas, serta menyebarkan pengumuman global.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="grid gap-4 md:grid-cols-3">
                <article class="rounded-3xl border border-blue-100 bg-white p-5 shadow-sm">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Akun Admin</p>
                            <p class="mt-2 text-3xl font-black tracking-tight text-slate-900">{{ $totalAdmins }}</p>
                            <p class="mt-2 text-sm text-slate-500">Mengatur seluruh sistem</p>
                        </div>
                        <div class="flex size-14 items-center justify-center rounded-2xl bg-blue-600 text-2xl text-white shadow-sm">
                            A
                        </div>
                    </div>
                </article>

                <article class="rounded-3xl border border-blue-100 bg-white p-5 shadow-sm">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Akun Mentor</p>
                            <p class="mt-2 text-3xl font-black tracking-tight text-slate-900">{{ $totalMentors }}</p>
                            <p class="mt-2 text-sm text-slate-500">Pengelola kelas dan materi</p>
                        </div>
                        <div class="flex size-14 items-center justify-center rounded-2xl bg-sky-500 text-2xl text-white shadow-sm">
                            M
                        </div>
                    </div>
                </article>

                <article class="rounded-3xl border border-blue-100 bg-white p-5 shadow-sm">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Akun Peserta</p>
                            <p class="mt-2 text-3xl font-black tracking-tight text-slate-900">{{ $totalPeserta }}</p>
                            <p class="mt-2 text-sm text-slate-500">Pengguna pembelajaran aktif</p>
                        </div>
                        <div class="flex size-14 items-center justify-center rounded-2xl bg-blue-400 text-2xl text-white shadow-sm">
                            P
                        </div>
                    </div>
                </article>
            </section>

            <section class="grid gap-4 md:grid-cols-3">
                <article class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Program</p>
                    <p class="mt-2 text-3xl font-black tracking-tight text-slate-900">{{ $totalPrograms }}</p>
                    <p class="mt-2 text-sm text-slate-500">Semua program pelatihan</p>
                </article>

                <article class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Kelas</p>
                    <p class="mt-2 text-3xl font-black tracking-tight text-slate-900">{{ $totalClasses }}</p>
                    <p class="mt-2 text-sm text-slate-500">Termasuk kelas aktif dan draft</p>
                </article>

                <article class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Pengumuman</p>
                    <p class="mt-2 text-3xl font-black tracking-tight text-slate-900">{{ $totalAnnouncements }}</p>
                    <p class="mt-2 text-sm text-slate-500">Broadcast global ke pengguna</p>
                </article>
            </section>

            <section class="grid gap-6 xl:grid-cols-[1.3fr_0.7fr]">
                <div class="space-y-6">
                    <div class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm">
                        <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4 sm:px-6">
                            <div>
                                <h2 class="text-base font-semibold text-slate-900">Aktivitas Terbaru</h2>
                                <p class="mt-1 text-sm text-slate-500">Pengguna, kelas, dan pengumuman yang baru dibuat</p>
                            </div>
                        </div>

                        <div class="grid divide-y divide-slate-200 lg:grid-cols-3 lg:divide-x lg:divide-y-0">
                            <div class="p-5 sm:p-6">
                                <div class="mb-4 flex items-center justify-between">
                                    <h3 class="text-sm font-semibold uppercase tracking-[0.16em] text-slate-500">Pengguna Baru</h3>
                                </div>

                                <div class="space-y-3">
                                    @forelse ($recentUsers as $user)
                                        <div class="rounded-2xl border border-slate-200 px-4 py-3">
                                            <div class="flex items-start justify-between gap-3">
                                                <div class="min-w-0">
                                                    <p class="truncate text-sm font-semibold text-slate-900">{{ $user->name }}</p>
                                                    <p class="truncate text-xs text-slate-500">{{ $user->email }}</p>
                                                </div>
                                                <span class="inline-flex rounded-full bg-blue-100 px-2.5 py-1 text-xs font-semibold text-blue-700">
                                                    {{ ucfirst($user->role) }}
                                                </span>
                                            </div>
                                            <p class="mt-2 text-xs text-slate-500">{{ $user->created_at->diffForHumans() }}</p>
                                        </div>
                                    @empty
                                        <div class="rounded-2xl border border-dashed border-slate-200 bg-slate-50 px-4 py-6 text-center text-sm text-slate-500">
                                            Belum ada pengguna baru.
                                        </div>
                                    @endforelse
                                </div>
                            </div>

                            <div class="p-5 sm:p-6">
                                <div class="mb-4 flex items-center justify-between">
                                    <h3 class="text-sm font-semibold uppercase tracking-[0.16em] text-slate-500">Kelas Baru</h3>
                                </div>

                                <div class="space-y-3">
                                    @forelse ($recentClasses as $kelas)
                                        <div class="rounded-2xl border border-slate-200 px-4 py-3 transition hover:border-blue-200 hover:bg-blue-50/50">
                                            <div class="flex items-start justify-between gap-3">
                                                <div class="min-w-0">
                                                    <p class="truncate text-sm font-semibold text-slate-900">{{ $kelas->nama }}</p>
                                                    <p class="truncate text-xs text-slate-500">{{ $kelas->program?->nama ?? '-' }}</p>
                                                </div>
                                                <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $kelas->status === 'aktif' ? 'bg-emerald-100 text-emerald-700' : ($kelas->status === 'draft' ? 'bg-amber-100 text-amber-700' : 'bg-slate-100 text-slate-600') }}">
                                                    {{ ucfirst($kelas->status) }}
                                                </span>
                                            </div>
                                            <p class="mt-2 text-xs text-slate-500">{{ $kelas->created_at->diffForHumans() }}</p>
                                        </div>
                                    @empty
                                        <div class="rounded-2xl border border-dashed border-slate-200 bg-slate-50 px-4 py-6 text-center text-sm text-slate-500">
                                            Belum ada kelas baru.
                                        </div>
                                    @endforelse
                                </div>
                            </div>

                            <div class="p-5 sm:p-6">
                                <div class="mb-4 flex items-center justify-between">
                                    <h3 class="text-sm font-semibold uppercase tracking-[0.16em] text-slate-500">Pengumuman</h3>
                                </div>

                                <div class="space-y-3">
                                    @forelse ($recentAnnouncements as $announcement)
                                        <div class="rounded-2xl border border-slate-200 px-4 py-3">
                                            <div class="flex items-start justify-between gap-3">
                                                <div class="min-w-0">
                                                    <p class="truncate text-sm font-semibold text-slate-900">{{ $announcement->judul }}</p>
                                                    <p class="truncate text-xs text-slate-500">{{ $announcement->creator?->name ?? 'Admin' }}</p>
                                                </div>
                                                <span class="inline-flex rounded-full bg-sky-100 px-2.5 py-1 text-xs font-semibold text-sky-700">
                                                    {{ ucfirst($announcement->target) }}
                                                </span>
                                            </div>
                                            <p class="mt-2 line-clamp-2 text-xs leading-5 text-slate-500">{{ $announcement->isi }}</p>
                                        </div>
                                    @empty
                                        <div class="rounded-2xl border border-dashed border-slate-200 bg-slate-50 px-4 py-6 text-center text-sm text-slate-500">
                                            Belum ada pengumuman.
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="overflow-hidden rounded-[2rem] border border-blue-100 bg-blue-950 text-white shadow-sm">
                        <div class="border-b border-white/10 px-5 py-4 sm:px-6">
                            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-blue-200">Akses Cepat</p>
                            <h2 class="mt-2 text-xl font-semibold">Pusat kendali untuk seluruh modul.</h2>
                        </div>

                        <div class="space-y-3 p-5 sm:p-6">
                            <a href="{{ route('admin.users.index') }}" class="flex items-center justify-between rounded-2xl bg-white/10 px-4 py-3 text-sm font-semibold transition hover:bg-white/15">
                                <span>Tambah, edit, hapus akun</span>
                                <span>→</span>
                            </a>
                            <a href="{{ route('admin.programs.index') }}" class="flex items-center justify-between rounded-2xl bg-white/10 px-4 py-3 text-sm font-semibold transition hover:bg-white/15">
                                <span>Kelola program pelatihan</span>
                                <span>→</span>
                            </a>
                            <a href="{{ route('admin.kelas.index') }}" class="flex items-center justify-between rounded-2xl bg-white/10 px-4 py-3 text-sm font-semibold transition hover:bg-white/15">
                                <span>Kelola kelas</span>
                                <span>→</span>
                            </a>
                            <a href="{{ route('admin.announcements.index') }}" class="flex items-center justify-between rounded-2xl bg-white/10 px-4 py-3 text-sm font-semibold transition hover:bg-white/15">
                                <span>Pengumuman global</span>
                                <span>→</span>
                            </a>
                            <a href="{{ route('admin.reports.index') }}" class="flex items-center justify-between rounded-2xl bg-white/10 px-4 py-3 text-sm font-semibold transition hover:bg-white/15">
                                <span>Laporan dan statistik</span>
                                <span>→</span>
                            </a>
                        </div>
                    </div>

                    <div class="rounded-[2rem] border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Status Sistem</p>
                                <h2 class="mt-2 text-base font-semibold text-slate-900">Ringkasan operasional</h2>
                            </div>
                            <div class="flex size-12 items-center justify-center rounded-2xl bg-blue-50 text-blue-700">
                                ✓
                            </div>
                        </div>

                        <div class="mt-5 space-y-3">
                            <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3 text-sm">
                                <span class="text-slate-600">Total akun</span>
                                <span class="font-semibold text-slate-900">{{ $totalUsers }}</span>
                            </div>
                            <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3 text-sm">
                                <span class="text-slate-600">Program tersedia</span>
                                <span class="font-semibold text-slate-900">{{ $totalPrograms }}</span>
                            </div>
                            <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3 text-sm">
                                <span class="text-slate-600">Kelas aktif</span>
                                <span class="font-semibold text-slate-900">{{ $activeClasses }}</span>
                            </div>
                            <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3 text-sm">
                                <span class="text-slate-600">Pengumuman</span>
                                <span class="font-semibold text-slate-900">{{ $totalAnnouncements }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-layouts.app>
