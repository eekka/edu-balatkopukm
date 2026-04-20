<x-layouts.app>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Kelas: ') . $kelas->nama }}
        </h2>
    </x-slot>

    <div class="h-full bg-slate-50 py-8 sm:py-10">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            <section class="overflow-hidden rounded-none border border-sky-700 bg-gradient-to-r from-sky-700 to-sky-600 px-6 py-7 text-white shadow-lg shadow-sky-300/20 sm:px-8">
                <div class="space-y-3 text-white">
                    <p class="text-xs font-semibold uppercase tracking-[0.32em] text-sky-200/80">Detail Kelas</p>
                    <h3 class="text-3xl font-bold">{{ $kelas->nama }}</h3>
                    <p class="max-w-2xl text-sm text-sky-100/90">{{ $kelas->deskripsi }}</p>
                </div>
            </section>

            <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
                <article class="rounded-none border border-slate-200 bg-white p-6 shadow-sm">
                    <p class="text-xs uppercase tracking-[0.32em] text-sky-700">Mentor</p>
                    <p class="mt-3 text-xl font-semibold text-slate-900">{{ $kelas->mentor->name }}</p>
                </article>

                <article class="rounded-none border border-slate-200 bg-sky-50/90 p-6 shadow-sm">
                    <p class="text-xs uppercase tracking-[0.32em] text-sky-700">Status Pendaftaran</p>
                    <p class="mt-3 text-xl font-semibold text-slate-900">{{ ucfirst($enrollment->status) }}</p>
                </article>

                <article class="rounded-none border border-slate-200 bg-white p-6 shadow-sm sm:col-span-2 xl:col-span-1">
                    <p class="text-xs uppercase tracking-[0.32em] text-sky-700">Jumlah Materi</p>
                    <p class="mt-3 text-xl font-semibold text-slate-900">{{ $kelas->materis->count() ?? 0 }}</p>
                </article>

                <article class="rounded-none border border-slate-200 bg-sky-50/90 p-6 shadow-sm sm:col-span-2 xl:col-span-3">
                    <p class="text-xs uppercase tracking-[0.32em] text-sky-700">Jadwal Kelas</p>
                    <p class="mt-3 text-xl font-semibold text-slate-900">
                        {{ $kelas->jadwal_hari_label ? $kelas->jadwal_hari_label : 'Jadwal belum ditentukan' }}
                        @if ($kelas->jadwal_jam_label)
                            <span class="text-slate-600">· {{ $kelas->jadwal_jam_label }}</span>
                        @endif
                    </p>
                </article>
            </section>

            <section class="grid gap-4 lg:grid-cols-2">
                <article class="rounded-none border border-slate-200 bg-white p-6 shadow-sm">
                    <h4 class="text-lg font-semibold text-slate-900">Deskripsi Kelas</h4>
                    <p class="mt-4 text-sm leading-7 text-slate-600">{{ $kelas->deskripsi }}</p>
                </article>

                <article class="rounded-none border border-slate-200 bg-sky-50/90 p-6 shadow-sm">
                    <h4 class="text-lg font-semibold text-slate-900">Aksi Cepat</h4>
                    <p class="mt-4 text-sm leading-7 text-slate-600">Mulai materi, cek tugas, dan pantau kemajuan kelas Anda dari halaman ini.</p>
                    <a href="{{ route('peserta.kelas.index') }}" class="mt-6 inline-flex items-center justify-center rounded-none bg-sky-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-sky-700">
                        Kembali ke Kelas Saya
                    </a>
                </article>
            </section>

            <section class="rounded-none border border-slate-200 bg-white p-6 shadow-sm">
                <div class="mb-6 flex flex-col gap-2">
                    <p class="text-xs font-semibold uppercase tracking-[0.28em] text-sky-700">Materi Kelas</p>
                    <h3 class="text-2xl font-bold text-slate-900">Daftar Materi</h3>
                    <p class="max-w-2xl text-sm text-slate-600">Klik judul materi untuk menampilkan detail dan lanjut ke halaman materi.</p>
                </div>

                @if ($kelas->materis->count() > 0)
                    <div class="space-y-4">
                        @foreach ($kelas->materis as $materi)
                            <details class="group overflow-hidden rounded-none border border-slate-200 bg-slate-50 p-4 transition hover:border-sky-300">
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
                                    <a href="#" class="mt-4 inline-flex items-center justify-center rounded-none bg-sky-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-sky-700">
                                        Lihat Materi
                                    </a>
                                </div>
                            </details>
                        @endforeach
                    </div>
                @else
                    <div class="rounded-none border border-dashed border-slate-300 bg-slate-50 px-4 py-6 text-center text-slate-600">
                        Belum ada materi yang tersedia untuk kelas ini.
                    </div>
                @endif
            </section>
        </div>
    </div>
</x-layouts.app>