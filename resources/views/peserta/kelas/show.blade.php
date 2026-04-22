<x-layouts.app>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Kelas') }}
        </h2>
    </x-slot>

    <div class="h-full bg-slate-50 py-8 sm:py-10" x-data="{ refreshTimer: null }" x-init="refreshTimer = setInterval(() => window.location.reload(), 20000)">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            <section class="overflow-hidden rounded-none border border-sky-700 bg-gradient-to-r from-sky-700 via-sky-700 to-sky-600 px-6 py-8 text-white shadow-lg shadow-sky-300/20 sm:px-8">
                <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                    <div class="max-w-3xl space-y-4">
                        <p class="text-xs font-semibold uppercase tracking-[0.32em] text-sky-200/80">Kelas Aktif</p>
                        <div class="space-y-2">
                            <h3 class="text-3xl font-bold sm:text-4xl">{{ $kelas->nama }}</h3>
                            <p class="max-w-2xl text-sm leading-6 text-sky-100/90">{{ $kelas->deskripsi }}</p>
                        </div>
                        <div class="flex flex-wrap gap-2 text-xs font-semibold uppercase tracking-[0.18em] text-sky-100/90">
                            <span class="rounded-none border border-sky-200/30 bg-white/10 px-3 py-1">Mentor: {{ $kelas->mentor->name }}</span>
                            <span class="rounded-none border border-sky-200/30 bg-white/10 px-3 py-1">Program: {{ $kelas->program?->nama ?? '-' }}</span>
                            <span class="rounded-none border border-sky-200/30 bg-white/10 px-3 py-1">Peserta: {{ $kelas->peserta_terdaftar }}</span>
                            @if ($kelas->jadwal_hari_label || $kelas->jadwal_jam_label)
                                <span class="rounded-none border border-sky-200/30 bg-white/10 px-3 py-1">Jadwal: {{ $kelas->jadwal_hari_label ?? '-' }}{{ $kelas->jadwal_jam_label ? ' · '.$kelas->jadwal_jam_label : '' }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="grid w-full gap-3 sm:grid-cols-3 lg:w-[440px] lg:grid-cols-1 xl:grid-cols-3">
                        <div class="rounded-none border border-white/15 bg-white/10 p-4 text-center backdrop-blur">
                            <p class="text-2xl font-bold">{{ $materiPembelajaran->count() }}</p>
                            <p class="mt-1 text-xs uppercase tracking-[0.18em] text-sky-100/80">Materi</p>
                        </div>
                        <div class="rounded-none border border-white/15 bg-white/10 p-4 text-center backdrop-blur">
                            <p class="text-2xl font-bold">{{ $diskusiKelas->count() }}</p>
                            <p class="mt-1 text-xs uppercase tracking-[0.18em] text-sky-100/80">Diskusi</p>
                        </div>
                        <div class="rounded-none border border-white/15 bg-white/10 p-4 text-center backdrop-blur">
                            <p class="text-2xl font-bold">{{ $kelas->tugas->count() }}</p>
                            <p class="mt-1 text-xs uppercase tracking-[0.18em] text-sky-100/80">Tugas</p>
                        </div>
                    </div>
                </div>
            </section>

            @if (session('status'))
                <div class="rounded-none border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                    {{ session('status') }}
                </div>
            @endif

            <section class="grid gap-6 xl:grid-cols-[1.3fr_0.9fr]">
                <div class="space-y-6">
                    <section class="rounded-none border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                        <div class="flex flex-wrap items-end justify-between gap-3 border-b border-slate-100 pb-4">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-500">Materi</p>
                                <h2 class="mt-2 text-2xl font-semibold text-slate-900">Materi Pembelajaran</h2>
                            </div>
                            <p class="text-sm text-slate-500">File video, PPT, atau PDF yang diunggah mentor.</p>
                        </div>

                        <div class="mt-5 grid gap-4 md:grid-cols-2">
                            @forelse ($materiPembelajaran as $materi)
                                @php
                                    $fileName = $materi->file ? basename($materi->file) : null;
                                @endphp
                                <article class="flex h-full flex-col justify-between rounded-none border border-slate-200 bg-slate-50 p-4">
                                    <div class="space-y-3">
                                        <div class="flex items-start justify-between gap-3">
                                            <h3 class="text-lg font-semibold text-slate-900">{{ $materi->judul }}</h3>
                                            <span class="rounded-none bg-sky-100 px-2 py-1 text-[11px] font-semibold uppercase tracking-[0.18em] text-sky-700">Materi</span>
                                        </div>
                                        <p class="text-sm leading-6 text-slate-600">{{ $materi->deskripsi }}</p>
                                        @if ($materi->file)
                                            <div class="rounded-none border border-dashed border-slate-300 bg-white px-3 py-2 text-sm text-slate-700">
                                                <p class="font-semibold text-slate-900">Lampiran</p>
                                                <p class="mt-1 break-all text-slate-500">{{ $fileName }}</p>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="mt-4 flex items-center justify-between gap-3 text-sm">
                                        <span class="text-slate-500">{{ $materi->created_at?->format('d M Y H:i') ?? '-' }}</span>
                                        @if ($materi->file)
                                            <a href="{{ asset('storage/'.$materi->file) }}" target="_blank" class="inline-flex items-center justify-center rounded-none bg-slate-900 px-3 py-2 text-xs font-semibold uppercase tracking-[0.18em] text-white transition hover:bg-slate-800">Buka File</a>
                                        @endif
                                    </div>
                                </article>
                            @empty
                                <div class="rounded-none border border-dashed border-slate-300 bg-slate-50 p-6 text-center text-slate-500 md:col-span-2">
                                    Belum ada materi yang dibagikan.
                                </div>
                            @endforelse
                        </div>
                    </section>

                    <section class="rounded-none border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                        <div class="flex flex-wrap items-end justify-between gap-3 border-b border-slate-100 pb-4">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-500">Diskusi</p>
                                <h2 class="mt-2 text-2xl font-semibold text-slate-900">Diskusi Kelas</h2>
                            </div>
                            <p class="text-sm text-slate-500">Percakapan dan topik yang dibuka mentor.</p>
                        </div>

                        <div class="mt-5 space-y-4">
                            @forelse ($diskusiKelas as $diskusi)
                                <article class="rounded-none border border-slate-200 bg-white p-4 shadow-sm">
                                    <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">
                                        <div>
                                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-sky-600">Diskusi</p>
                                            <h3 class="mt-1 text-lg font-semibold text-slate-900">{{ str_replace('Diskusi: ', '', $diskusi->judul) }}</h3>
                                        </div>
                                        <span class="rounded-none bg-slate-100 px-2 py-1 text-xs font-semibold uppercase tracking-[0.18em] text-slate-600">{{ $diskusi->created_at?->format('d M Y') ?? '-' }}</span>
                                    </div>
                                    <p class="mt-3 text-sm leading-6 text-slate-600">{{ $diskusi->deskripsi }}</p>
                                </article>
                            @empty
                                <div class="rounded-none border border-dashed border-slate-300 bg-slate-50 p-6 text-center text-slate-500">
                                    Belum ada diskusi di kelas ini.
                                </div>
                            @endforelse
                        </div>
                    </section>
                </div>

                <aside class="space-y-6">
                    <section class="rounded-none border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                        <div class="border-b border-slate-100 pb-4">
                            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-500">Tugas</p>
                            <h2 class="mt-2 text-2xl font-semibold text-slate-900">Pengumpulan Tugas</h2>
                            <p class="mt-1 text-sm text-slate-600">Upload file jawaban untuk setiap tugas yang tersedia.</p>
                        </div>

                        <div class="mt-5 space-y-4">
                            @forelse ($kelas->tugas as $tugas)
                                @php
                                    $submission = $tugas->submissions->first();
                                @endphp
                                <article class="rounded-none border border-slate-200 bg-slate-50 p-4">
                                    <div class="space-y-3">
                                        <div class="flex flex-col gap-2">
                                            <div class="flex items-start justify-between gap-3">
                                                <h3 class="text-lg font-semibold text-slate-900">{{ $tugas->judul }}</h3>
                                                <span class="rounded-none bg-amber-100 px-2 py-1 text-[11px] font-semibold uppercase tracking-[0.18em] text-amber-700">Tugas</span>
                                            </div>
                                            <p class="text-sm leading-6 text-slate-600">{{ $tugas->deskripsi }}</p>
                                        </div>

                                        <div class="grid gap-2 text-sm text-slate-600">
                                            <p><span class="font-semibold text-slate-900">Deadline:</span> {{ $tugas->deadline?->format('d M Y H:i') ?? '-' }}</p>
                                            <p><span class="font-semibold text-slate-900">Nilai Maksimal:</span> {{ $tugas->nilai_maksimal ?? '-' }}</p>
                                            @if ($tugas->file_soal)
                                                <a href="{{ asset('storage/'.$tugas->file_soal) }}" target="_blank" class="inline-flex w-fit items-center rounded-none border border-slate-300 bg-white px-3 py-2 text-xs font-semibold uppercase tracking-[0.18em] text-slate-700 transition hover:border-slate-400 hover:bg-slate-100">Unduh Soal</a>
                                            @endif
                                        </div>

                                        <form method="POST" action="{{ route('peserta.kelas.tugas.submit', [$kelas, $tugas]) }}" enctype="multipart/form-data" class="space-y-3 border-t border-slate-200 pt-4">
                                            @csrf
                                            <div>
                                                <label class="mb-2 block text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Upload Jawaban</label>
                                                <input type="file" name="file" class="block w-full rounded-none border border-slate-300 bg-white px-3 py-2 text-sm text-slate-700 file:mr-4 file:rounded-none file:border-0 file:bg-slate-900 file:px-4 file:py-2 file:text-xs file:font-semibold file:uppercase file:tracking-[0.18em] file:text-white focus:border-sky-500 focus:ring-2 focus:ring-sky-200 focus:outline-none" required>
                                                @error('file')
                                                    <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div>
                                                <label class="mb-2 block text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Catatan</label>
                                                <textarea name="komentar" rows="3" class="block w-full rounded-none border border-slate-300 bg-white px-3 py-2 text-sm text-slate-700 focus:border-sky-500 focus:ring-2 focus:ring-sky-200 focus:outline-none" placeholder="Tambahkan catatan untuk mentor">{{ old('komentar') }}</textarea>
                                                @error('komentar')
                                                    <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <button type="submit" class="inline-flex w-full items-center justify-center rounded-none bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800">
                                                Kumpulkan Tugas
                                            </button>
                                        </form>

                                        <div class="rounded-none border border-dashed border-slate-300 bg-white px-3 py-3 text-sm text-slate-600">
                                            <p class="font-semibold text-slate-900">Status Pengumpulan</p>
                                            @if ($submission)
                                                <p class="mt-1">Sudah dikumpulkan pada {{ $submission->submitted_at?->format('d M Y H:i') ?? '-' }}.</p>
                                                <a href="{{ asset('storage/'.$submission->file) }}" target="_blank" class="mt-2 inline-flex items-center text-sky-700 hover:text-sky-800">Lihat file yang dikumpulkan</a>
                                            @else
                                                <p class="mt-1">Belum ada file yang dikumpulkan untuk tugas ini.</p>
                                            @endif
                                        </div>
                                    </div>
                                </article>
                            @empty
                                <div class="rounded-none border border-dashed border-slate-300 bg-slate-50 p-6 text-center text-slate-500">
                                    Belum ada tugas di kelas ini.
                                </div>
                            @endforelse
                        </div>
                    </section>

                    <section class="rounded-none border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                        <div class="border-b border-slate-100 pb-4">
                            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-500">Quiz</p>
                            <h2 class="mt-2 text-2xl font-semibold text-slate-900">Quiz Kelas</h2>
                        </div>

                        <div class="mt-5 space-y-3">
                            @forelse ($kelas->quizzes as $quiz)
                                <article class="rounded-none border border-slate-200 bg-slate-50 p-4">
                                    <div class="flex items-start justify-between gap-3">
                                        <div>
                                            <h3 class="text-base font-semibold text-slate-900">{{ $quiz->judul }}</h3>
                                            <p class="mt-1 text-sm leading-6 text-slate-600">{{ $quiz->deskripsi }}</p>
                                        </div>
                                        <span class="rounded-none bg-violet-100 px-2 py-1 text-[11px] font-semibold uppercase tracking-[0.18em] text-violet-700">Quiz</span>
                                    </div>
                                </article>
                            @empty
                                <div class="rounded-none border border-dashed border-slate-300 bg-slate-50 p-6 text-center text-slate-500">
                                    Belum ada quiz di kelas ini.
                                </div>
                            @endforelse
                        </div>
                    </section>
                </aside>
            </section>
        </div>
    </div>
</x-layouts.app>
