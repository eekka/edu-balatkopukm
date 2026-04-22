<x-layouts.app>
    <div class="h-full bg-slate-50 py-8 sm:py-10">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="rounded-none border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="rounded-none border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                    <p class="font-semibold">Periksa input berikut:</p>
                    <ul class="mt-2 list-disc space-y-1 pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <section class="overflow-hidden rounded-none bg-gradient-to-r from-sky-700 to-sky-600 p-8 shadow-xl shadow-sky-400/20">
                <div class="space-y-3 text-white">
                    <p class="text-xs font-semibold uppercase tracking-[0.32em] text-sky-200/80">Detail Kelas</p>
                    <h3 class="text-3xl font-bold">{{ $kelas->nama }}</h3>
                    <p class="max-w-2xl text-sm text-sky-100/90">{{ $kelas->deskripsi }}</p>
                </div>
            </section>

            <section class="grid gap-6 lg:grid-cols-3">
                <div class="rounded-none border border-slate-200 bg-white p-6 shadow-sm">
                    <p class="text-xs uppercase tracking-[0.32em] text-sky-700">Program</p>
                    <p class="mt-3 text-4xl font-bold text-slate-900">{{ $kelas->program?->nama ?? '-' }}</p>
                </div>

                <div class="rounded-none border border-slate-200 bg-sky-50/90 p-6 shadow-sm">
                    <p class="text-xs uppercase tracking-[0.32em] text-sky-700">Peserta Terdaftar</p>
                    <p class="mt-3 text-4xl font-bold text-slate-900">{{ $kelas->enrollments->count() }} / {{ $kelas->kapasitas }}</p>
                </div>

                <div class="rounded-none border border-slate-200 bg-white p-6 shadow-sm">
                    <p class="text-xs uppercase tracking-[0.32em] text-sky-700">Status</p>
                    <p class="mt-3 text-4xl font-bold text-slate-900">{{ ucfirst($kelas->status) }}</p>
                </div>
            </section>

            <section class="grid gap-6 lg:grid-cols-2">
                <article class="rounded-none border border-slate-200 bg-white p-6 shadow-sm">
                    <h4 class="text-3xl font-semibold text-slate-900">Deskripsi Kelas</h4>
                    <p class="mt-4 text-sm leading-7 text-slate-600">{{ $kelas->deskripsi }}</p>
                    <dl class="mt-6 grid gap-3 text-sm text-slate-600">
                        <div class="rounded-none bg-slate-50 p-4">
                            <dt class="font-semibold text-slate-900">Kode Kelas</dt>
                            <dd class="mt-1">{{ $kelas->kode_kelas }}</dd>
                        </div>
                        <div class="rounded-none bg-slate-50 p-4">
                            <dt class="font-semibold text-slate-900">Tanggal Mulai</dt>
                            <dd class="mt-1">{{ $kelas->mulai?->format('d M Y') ?? 'Belum diatur' }}</dd>
                        </div>
                        <div class="rounded-none bg-slate-50 p-4">
                            <dt class="font-semibold text-slate-900">Tanggal Selesai</dt>
                            <dd class="mt-1">{{ $kelas->selesai?->format('d M Y') ?? 'Belum diatur' }}</dd>
                        </div>
                    </dl>
                </article>

                <article class="rounded-none border border-slate-200 bg-sky-50/90 p-6 shadow-sm" id="akses-cepat">
                    <h4 class="text-3xl font-semibold text-slate-900">Aksi Cepat</h4>
                    <p class="mt-4 text-sm leading-7 text-slate-600">Tambah konten kelas dari form di bawah. Peserta yang terdaftar akan melihat pembaruan konten ini secara langsung pada halaman kelas mereka.</p>
                    <a href="{{ route('mentor.kelas.index') }}" class="mt-6 inline-flex items-center justify-center rounded-none bg-sky-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-sky-700">
                        Kembali ke Kelas Saya
                    </a>
                </article>
            </section>

            <section class="grid gap-6 lg:grid-cols-2">
                <article class="rounded-none border border-slate-200 bg-white p-6 shadow-sm">
                    <h4 class="text-xl font-semibold text-slate-900">Tambah Materi</h4>
                    <form method="POST" action="{{ route('mentor.kelas.materi.store', $kelas) }}" enctype="multipart/form-data" class="mt-4 grid gap-3 [&_input]:bg-white [&_input]:text-slate-900 [&_input]:placeholder:text-slate-400 [&_textarea]:bg-white [&_textarea]:text-slate-900 [&_textarea]:placeholder:text-slate-400 [&_select]:bg-white [&_select]:text-slate-900">
                        @csrf
                        <input type="text" name="judul" class="rounded-none border border-slate-300 px-3 py-2 text-sm" placeholder="Judul materi" required>
                        <textarea name="isi" rows="3" class="rounded-none border border-slate-300 px-3 py-2 text-sm" placeholder="Isi materi"></textarea>
                        <div class="grid gap-3 sm:grid-cols-3">
                            <input type="number" name="pertemuan" min="1" class="rounded-none border border-slate-300 px-3 py-2 text-sm" placeholder="Pertemuan" required>
                            <select name="tipe" class="rounded-none border border-slate-300 px-3 py-2 text-sm" required>
                                <option value="artikel">Artikel</option>
                                <option value="link">Link</option>
                                <option value="video">Video</option>
                                <option value="pdf">PDF</option>
                                <option value="ppt">PPT</option>
                            </select>
                            <input type="url" name="url" class="rounded-none border border-slate-300 px-3 py-2 text-sm" placeholder="URL (opsional)">
                        </div>
                        <input type="file" name="file" class="rounded-none border border-slate-300 px-3 py-2 text-sm" accept=".pdf,.ppt,.pptx,.mp4,.mov,.avi,.wmv,.mkv">
                        <p class="text-xs text-slate-500">Upload file untuk materi PDF, PPT, atau video. Jika memilih tipe link/artikel, file bisa dikosongkan.</p>
                        <button type="submit" class="rounded-none bg-sky-600 px-4 py-2 text-sm font-semibold text-white hover:bg-sky-700">Simpan Materi</button>
                    </form>
                </article>

                <article class="rounded-none border border-slate-200 bg-white p-6 shadow-sm">
                    <h4 class="text-xl font-semibold text-slate-900">Tambah Tugas</h4>
                    <form method="POST" action="{{ route('mentor.kelas.tugas.store', $kelas) }}" class="mt-4 grid gap-3 [&_input]:bg-white [&_input]:text-slate-900 [&_input]:placeholder:text-slate-400 [&_textarea]:bg-white [&_textarea]:text-slate-900 [&_textarea]:placeholder:text-slate-400 [&_select]:bg-white [&_select]:text-slate-900">
                        @csrf
                        <input type="text" name="judul" class="rounded-none border border-slate-300 px-3 py-2 text-sm" placeholder="Judul tugas" required>
                        <textarea name="deskripsi" rows="3" class="rounded-none border border-slate-300 px-3 py-2 text-sm" placeholder="Deskripsi tugas"></textarea>
                        <div class="grid gap-3 sm:grid-cols-3">
                            <input type="datetime-local" name="deadline" class="rounded-none border border-slate-300 px-3 py-2 text-sm" required>
                            <input type="number" name="nilai_maksimal" min="1" max="1000" value="100" class="rounded-none border border-slate-300 px-3 py-2 text-sm" required>
                            <select name="status" class="rounded-none border border-slate-300 px-3 py-2 text-sm" required>
                                <option value="draft">Draft</option>
                                <option value="aktif">Aktif</option>
                                <option value="selesai">Selesai</option>
                            </select>
                        </div>
                        <button type="submit" class="rounded-none bg-sky-600 px-4 py-2 text-sm font-semibold text-white hover:bg-sky-700">Simpan Tugas</button>
                    </form>
                </article>

                <article class="rounded-none border border-slate-200 bg-white p-6 shadow-sm">
                    <h4 class="text-xl font-semibold text-slate-900">Tambah Quiz</h4>
                    <form method="POST" action="{{ route('mentor.kelas.quiz.store', $kelas) }}" class="mt-4 grid gap-3 [&_input]:bg-white [&_input]:text-slate-900 [&_input]:placeholder:text-slate-400 [&_textarea]:bg-white [&_textarea]:text-slate-900 [&_textarea]:placeholder:text-slate-400 [&_select]:bg-white [&_select]:text-slate-900">
                        @csrf
                        <input type="text" name="judul" class="rounded-none border border-slate-300 px-3 py-2 text-sm" placeholder="Judul quiz" required>
                        <textarea name="deskripsi" rows="3" class="rounded-none border border-slate-300 px-3 py-2 text-sm" placeholder="Deskripsi quiz"></textarea>
                        <div class="grid gap-3 sm:grid-cols-2">
                            <input type="number" name="waktu_pengerjaan" min="5" max="300" value="60" class="rounded-none border border-slate-300 px-3 py-2 text-sm" placeholder="Durasi (menit)" required>
                            <input type="number" name="nilai_maksimal" min="1" max="1000" value="100" class="rounded-none border border-slate-300 px-3 py-2 text-sm" placeholder="Nilai maksimal" required>
                        </div>
                        <div class="grid gap-3 sm:grid-cols-3">
                            <input type="datetime-local" name="mulai" class="rounded-none border border-slate-300 px-3 py-2 text-sm">
                            <input type="datetime-local" name="selesai" class="rounded-none border border-slate-300 px-3 py-2 text-sm">
                            <select name="status" class="rounded-none border border-slate-300 px-3 py-2 text-sm" required>
                                <option value="draft">Draft</option>
                                <option value="aktif">Aktif</option>
                                <option value="selesai">Selesai</option>
                            </select>
                        </div>
                        <button type="submit" class="rounded-none bg-sky-600 px-4 py-2 text-sm font-semibold text-white hover:bg-sky-700">Simpan Quiz</button>
                    </form>
                </article>

                <article class="rounded-none border border-slate-200 bg-white p-6 shadow-sm">
                    <h4 class="text-xl font-semibold text-slate-900">Tambah Diskusi</h4>
                    <form method="POST" action="{{ route('mentor.kelas.diskusi.store', $kelas) }}" class="mt-4 grid gap-3 [&_input]:bg-white [&_input]:text-slate-900 [&_input]:placeholder:text-slate-400 [&_textarea]:bg-white [&_textarea]:text-slate-900 [&_textarea]:placeholder:text-slate-400 [&_select]:bg-white [&_select]:text-slate-900">
                        @csrf
                        <input type="text" name="topik" class="rounded-none border border-slate-300 px-3 py-2 text-sm" placeholder="Topik diskusi" required>
                        <textarea name="isi" rows="4" class="rounded-none border border-slate-300 px-3 py-2 text-sm" placeholder="Pertanyaan pemantik diskusi" required></textarea>
                        <input type="number" name="pertemuan" min="1" class="rounded-none border border-slate-300 px-3 py-2 text-sm" placeholder="Pertemuan" required>
                        <button type="submit" class="rounded-none bg-sky-600 px-4 py-2 text-sm font-semibold text-white hover:bg-sky-700">Publikasikan Diskusi</button>
                    </form>
                </article>
            </section>

            <section class="grid gap-6 lg:grid-cols-2">
                <section class="rounded-none border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="text-xl font-semibold text-slate-900">Peserta Kelas ({{ $kelas->enrollments->count() }})</h3>
                    <div class="mt-4 space-y-3">
                        @forelse ($kelas->enrollments as $enrollment)
                            <div class="rounded-none border border-slate-200 bg-slate-50 p-4">
                                <p class="font-semibold text-slate-900">{{ $enrollment->peserta?->name ?? 'Peserta tidak ditemukan' }}</p>
                                <p class="text-sm text-slate-600">Status: {{ ucfirst($enrollment->status) }}</p>
                            </div>
                        @empty
                            <p class="text-sm text-slate-600">Belum ada peserta terdaftar.</p>
                        @endforelse
                    </div>
                </section>

                <section class="rounded-none border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="text-xl font-semibold text-slate-900">Konten Terbaru Kelas</h3>
                    <div class="mt-4 space-y-3 text-sm text-slate-700">
                        <div class="rounded-none border border-slate-200 bg-slate-50 p-4">Materi: {{ $kelas->materis->filter(fn ($materi) => ! str_starts_with($materi->judul, 'Diskusi:'))->count() }}</div>
                        <div class="rounded-none border border-slate-200 bg-slate-50 p-4">Tugas: {{ $kelas->tugas->count() }}</div>
                        <div class="rounded-none border border-slate-200 bg-slate-50 p-4">Quiz: {{ $kelas->quizzes->count() }}</div>
                        <div class="rounded-none border border-slate-200 bg-slate-50 p-4">Diskusi: {{ $kelas->materis->filter(fn ($materi) => str_starts_with($materi->judul, 'Diskusi:'))->count() }}</div>
                        @if ($kelas->materis->firstWhere('file'))
                            <div class="rounded-none border border-slate-200 bg-slate-50 p-4">
                                <p class="font-semibold text-slate-900">File Materi Tersedia</p>
                                <a href="{{ asset('storage/'.$kelas->materis->firstWhere('file')->file) }}" target="_blank" rel="noopener" class="mt-2 inline-flex items-center justify-center rounded-none border border-sky-200 bg-white px-3 py-2 text-xs font-semibold text-sky-700 transition hover:bg-sky-50">
                                    Buka File
                                </a>
                            </div>
                        @endif
                    </div>
                </section>
            </section>
        </div>
    </div>
</x-layouts.app>
