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
                    <p class="text-xs uppercase tracking-[0.32em] text-sky-700">Program</p>
                    <p class="mt-3 text-xl font-semibold text-slate-900">{{ $kelas->program?->nama ?? '-' }}</p>
                </div>

                <div class="rounded-[28px] border border-slate-200 bg-sky-50/90 p-6 shadow-lg shadow-sky-200/30">
                    <p class="text-xs uppercase tracking-[0.32em] text-sky-700">Peserta Terdaftar</p>
                    <p class="mt-3 text-xl font-semibold text-slate-900">{{ $kelas->enrollments->count() }} / {{ $kelas->kapasitas }}</p>
                </div>

                <div class="rounded-[28px] border border-slate-200 bg-white p-6 shadow-lg shadow-slate-300/20">
                    <p class="text-xs uppercase tracking-[0.32em] text-sky-700">Status</p>
                    <p class="mt-3 text-xl font-semibold text-slate-900">{{ ucfirst($kelas->status) }}</p>
                </div>
            </div>

            <div class="mt-6 grid gap-6 lg:grid-cols-2">
                <div class="rounded-[28px] border border-slate-200 bg-white p-6 shadow-lg shadow-slate-300/20">
                    <h4 class="text-lg font-semibold text-slate-900">Deskripsi Kelas</h4>
                    <p class="mt-4 text-sm leading-7 text-slate-600">{{ $kelas->deskripsi }}</p>
                    <dl class="mt-6 grid gap-3 text-sm text-slate-600">
                        <div class="rounded-3xl bg-slate-50 p-4">
                            <dt class="font-semibold text-slate-900">Kode Kelas</dt>
                            <dd class="mt-1">{{ $kelas->kode_kelas }}</dd>
                        </div>
                        <div class="rounded-3xl bg-slate-50 p-4">
                            <dt class="font-semibold text-slate-900">Tanggal Mulai</dt>
                            <dd class="mt-1">{{ $kelas->mulai?->format('d M Y') ?? 'Belum diatur' }}</dd>
                        </div>
                        <div class="rounded-3xl bg-slate-50 p-4">
                            <dt class="font-semibold text-slate-900">Tanggal Selesai</dt>
                            <dd class="mt-1">{{ $kelas->selesai?->format('d M Y') ?? 'Belum diatur' }}</dd>
                        </div>
                    </dl>
                </div>

                <div class="rounded-[28px] border border-slate-200 bg-sky-50/90 p-6 shadow-lg shadow-sky-200/30">
                    <h4 class="text-lg font-semibold text-slate-900">Aksi Cepat</h4>
                    <p class="mt-4 text-sm leading-7 text-slate-600">Gunakan tombol ini untuk kembali ke daftar kelas Anda dan melihat semua kelas mentor.</p>
                    <a href="{{ route('mentor.kelas.index') }}" class="mt-6 inline-flex items-center justify-center rounded-2xl bg-sky-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-sky-700">
                        Kembali ke Kelas Saya
                    </a>
                </div>
            </div>

            <div class="mt-10 grid gap-6 lg:grid-cols-2">
                <section class="rounded-[32px] border border-slate-200 bg-white p-6 shadow-lg shadow-slate-300/20">
                    <div class="mb-6 flex items-center justify-between gap-3">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-sky-700">Peserta Kelas</p>
                            <h3 class="text-2xl font-bold text-slate-900">{{ $kelas->enrollments->count() }}</h3>
                        </div>
                    </div>

                    @if($kelas->enrollments->isNotEmpty())
                        <div class="space-y-3">
                            @foreach($kelas->enrollments as $enrollment)
                                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4">
                                    <p class="font-semibold text-slate-900">{{ $enrollment->peserta?->name ?? 'Peserta tidak ditemukan' }}</p>
                                    <p class="text-sm text-slate-600">Status: {{ ucfirst($enrollment->status) }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-slate-600">Belum ada peserta terdaftar.</p>
                    @endif
                </section>

                <section class="rounded-[32px] border border-slate-200 bg-white p-6 shadow-lg shadow-slate-300/20">
                    <div class="mb-6">
                        <p class="text-xs font-semibold uppercase tracking-[0.28em] text-sky-700">Materi Kelas</p>
                        <h3 class="text-2xl font-bold text-slate-900">{{ $kelas->materis->count() }}</h3>
                    </div>

                    @if($kelas->materis->isNotEmpty())
                        <div class="space-y-4">
                            @foreach($kelas->materis as $materi)
                                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4">
                                    <p class="font-semibold text-slate-900">{{ $materi->judul }}</p>
                                    <p class="mt-1 text-sm text-slate-600">{{ \Illuminate\Support\Str::limit($materi->deskripsi, 100) }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-slate-600">Belum ada materi untuk kelas ini.</p>
                    @endif
                </section>
            </div>
        </div>
    </div>
</x-layouts.app>