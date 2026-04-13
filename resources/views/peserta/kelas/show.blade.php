<x-layouts.app>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Kelas: ') . $kelas->nama }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 h-full">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-[32px] bg-gradient-to-r from-sky-700 to-sky-600 p-8 shadow-xl shadow-sky-400/20">
                <div class="space-y-3 text-white">
                    <p class="text-xs font-semibold uppercase tracking-[0.32em] text-sky-200/80">Detail Kelas</p>
                    <h3 class="text-3xl font-bold">{{ $kelas->nama }}</h3>
                    <p class="max-w-2xl text-sm text-sky-100/90">{{ $kelas->deskripsi }}</p>
                </div>
            </div>

            <div class="mt-8 grid gap-6 lg:grid-cols-3">
                <div class="rounded-[28px] border border-slate-200 bg-white p-6 shadow-lg shadow-slate-300/20">
                    <p class="text-xs uppercase tracking-[0.32em] text-sky-700">Mentor</p>
                    <p class="mt-3 text-xl font-semibold text-slate-900">{{ $kelas->mentor->name }}</p>
                </div>

                <div class="rounded-[28px] border border-slate-200 bg-sky-50/90 p-6 shadow-lg shadow-sky-200/30">
                    <p class="text-xs uppercase tracking-[0.32em] text-sky-700">Status Pendaftaran</p>
                    <p class="mt-3 text-xl font-semibold text-slate-900">{{ ucfirst($enrollment->status) }}</p>
                </div>

                <div class="rounded-[28px] border border-slate-200 bg-white p-6 shadow-lg shadow-slate-300/20">
                    <p class="text-xs uppercase tracking-[0.32em] text-sky-700">Jumlah Materi</p>
                    <p class="mt-3 text-xl font-semibold text-slate-900">{{ $kelas->materis->count() ?? 0 }}</p>
                </div>
            </div>

            <div class="mt-6 grid gap-6 lg:grid-cols-2">
                <div class="rounded-[28px] border border-slate-200 bg-white p-6 shadow-lg shadow-slate-300/20">
                    <h4 class="text-lg font-semibold text-slate-900">Deskripsi Kelas</h4>
                    <p class="mt-4 text-sm leading-7 text-slate-600">{{ $kelas->deskripsi }}</p>
                </div>

                <div class="rounded-[28px] border border-slate-200 bg-sky-50/90 p-6 shadow-lg shadow-sky-200/30">
                    <h4 class="text-lg font-semibold text-slate-900">Aksi Cepat</h4>
                    <p class="mt-4 text-sm leading-7 text-slate-600">Mulai materi, cek tugas, dan pantau kemajuan kelas Anda dari halaman ini.</p>
                    <a href="{{ route('peserta.kelas.index') }}" class="mt-6 inline-flex items-center justify-center rounded-2xl bg-sky-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-sky-700">
                        Kembali ke Kelas Saya
                    </a>
                </div>
            </div>
        </div>
        <!-- materi -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-10">
            <div class="rounded-[32px] border border-slate-200 bg-white p-6 shadow-lg shadow-slate-300/20">
                <div class="mb-6 flex flex-col gap-2">
                    <p class="text-xs font-semibold uppercase tracking-[0.28em] text-sky-700">Materi Kelas</p>
                    <h3 class="text-2xl font-bold text-slate-900">Daftar Materi</h3>
                    <p class="max-w-2xl text-sm text-slate-600">Klik judul materi untuk menampilkan detail dan lanjut ke halaman materi.</p>
                </div>

                @if($kelas->materis->count() > 0)
                    <div class="space-y-4">
                        @foreach($kelas->materis as $materi)
                            <details class="group overflow-hidden rounded-[28px] border border-slate-200 bg-slate-50 p-4 transition hover:border-sky-300">
                                <summary class="flex cursor-pointer items-center justify-between gap-4 text-left text-lg font-semibold text-slate-900">
                                    <span>{{ $materi->judul }}</span>
                                    <span class="rounded-full border border-slate-300 bg-white px-3 py-1 text-xs font-semibold text-slate-700 transition group-open:border-sky-300 group-open:bg-sky-600 group-open:text-white">Detail</span>
                                </summary>
                                <div class="mt-4 border-t border-slate-200 pt-4 text-sm text-slate-600">
                                    <p>{{ \Illuminate\Support\Str::limit($materi->deskripsi, 200) }}</p>
                                    <div class="mt-4 flex flex-wrap gap-3">
                                        <span class="rounded-full bg-sky-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-sky-700">Materi</span>
                                        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-slate-700">{{ $materi->created_at?->format('d M Y') ?? 'Tanggal belum tersedia' }}</span>
                                    </div>
                                    <a href="#" class="mt-4 inline-flex items-center justify-center rounded-2xl bg-sky-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-sky-700">
                                        Lihat Materi
                                    </a>
                                </div>
                            </details>
                        @endforeach
                    </div>
                @else
                    <p class="text-slate-600">Belum ada materi yang tersedia untuk kelas ini.</p>
                @endif
            </div>
        </div>
    </div>
</x-layouts.app>