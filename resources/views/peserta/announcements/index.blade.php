<x-layouts.app>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pengumuman') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 h-full">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-[32px] bg-gradient-to-r from-sky-700 to-sky-600 p-8 shadow-xl shadow-sky-400/20">
                <div class="space-y-3 text-white">
                    <p class="text-xs font-semibold uppercase tracking-[0.32em] text-sky-200/80">Pengumuman Peserta</p>
                    <h3 class="text-3xl font-bold">Info Terbaru Untuk Anda</h3>
                    <p class="max-w-2xl text-sm text-sky-100/90">Lihat semua pengumuman yang ditujukan ke peserta dan pengumuman umum untuk seluruh platform.</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('peserta.kelas.index') }}" class="inline-flex items-center justify-center rounded-2xl bg-white px-4 py-3 text-sm font-semibold text-sky-700 transition hover:bg-slate-100">
                        <span>Kelas Saya</span>
                    </a>
                    <a href="{{ route('peserta.jadwal') }}" class="inline-flex items-center justify-center rounded-2xl border border-white/20 bg-white/10 px-4 py-3 text-sm font-semibold text-white transition hover:bg-white/20">
                        Jadwal
                    </a>
                </div>
            </div>

            <div class="mt-8 grid gap-6 lg:grid-cols-[1.2fr_0.8fr]">
                <div class="space-y-6">
                    <div class="rounded-[32px] border border-slate-200 bg-white p-6 shadow-lg shadow-slate-300/20">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-500">Daftar Pengumuman</p>
                                <h3 class="mt-2 text-2xl font-bold text-slate-900">Pengumuman Untuk Peserta</h3>
                            </div>
                            <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.18em] text-slate-700">{{ $announcements->count() }} ditemukan</span>
                        </div>

                        <div class="mt-6 space-y-5">
                            @forelse ($announcements as $announcement)
                                <article class="rounded-[28px] border border-slate-200 bg-slate-50 p-5 shadow-sm transition hover:border-sky-300">
                                    <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
                                        <div class="min-w-0">
                                            <h4 class="text-lg font-semibold text-slate-900">{{ $announcement->judul }}</h4>
                                            <p class="mt-2 text-sm text-slate-600 line-clamp-2">{{ $announcement->isi }}</p>
                                        </div>
                                        <div class="flex flex-wrap items-center gap-2 text-xs text-slate-600">
                                            <span class="rounded-full bg-white px-3 py-1 font-semibold uppercase tracking-[0.16em] text-slate-700">{{ ucfirst($announcement->target) }}</span>
                                            <span class="rounded-full bg-slate-100 px-3 py-1 text-slate-700">{{ $announcement->creator?->name ?? 'Admin' }}</span>
                                            <span class="rounded-full bg-slate-100 px-3 py-1 text-slate-700">{{ $announcement->published_at?->format('d M Y H:i') }}</span>
                                        </div>
                                    </div>
                                </article>
                            @empty
                                <div class="rounded-[28px] border border-slate-200 bg-slate-50 p-8 text-center text-slate-600">
                                    Belum ada pengumuman terbaru. Silakan periksa kembali nanti.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <aside class="space-y-6">
                    <div class="rounded-[32px] border border-slate-200 bg-white p-6 shadow-lg shadow-slate-300/20">
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Akses Cepat</p>
                        <div class="mt-4 grid gap-3">
                            <a href="{{ route('peserta.kelas.index') }}" class="flex items-center justify-between rounded-2xl bg-sky-50 px-4 py-3 text-sm font-semibold text-slate-900 transition hover:bg-sky-100">
                                <span>Kelas Saya</span>
                                <span>→</span>
                            </a>
                            <a href="{{ route('peserta.jadwal') }}" class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-100">
                                <span>Jadwal</span>
                                <span>→</span>
                            </a>
                            <a href="{{ route('peserta.progress') }}" class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-100">
                                <span>Progress</span>
                                <span>→</span>
                            </a>
                            <a href="{{ route('peserta.testimonials.index') }}" class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-100">
                                <span>Kirim Testimoni</span>
                                <span>→</span>
                            </a>
                        </div>
                    </div>

                    <div class="rounded-[32px] border border-blue-100 bg-blue-950 p-6 text-white shadow-lg shadow-sky-500/10">
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-blue-200">Catatan Peserta</p>
                        <p class="mt-3 text-sm leading-6 text-blue-100/90">
                            Semua pengumuman di halaman ini adalah yang ditujukan untuk peserta dan seluruh pengguna. Pastikan melakukan refresh jika Anda tidak melihat update baru.
                        </p>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</x-layouts.app>
