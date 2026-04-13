<x-layouts.app>
<div class="min-h-screen bg-slate-50 py-10">
    <div class="mx-auto max-w-7xl space-y-8 px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-blue-600">Mentor</p>
                <h1 class="text-3xl font-bold text-slate-900">Buat Kelas Baru</h1>
                <p class="mt-2 text-slate-700">Kelas yang dibuat akan dapat dikelola admin dan bisa diikuti peserta menggunakan kode kelas.</p>
            </div>
            <a href="{{ route('mentor.dashboard') }}" class="inline-flex items-center justify-center border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-800 shadow-sm transition hover:bg-slate-100">Kembali ke Dashboard</a>
        </div>

        @if (session('status'))
            <div class="border border-emerald-300 bg-emerald-50 px-4 py-3 text-emerald-900">{{ session('status') }}</div>
        @endif

        <div class="border border-slate-300 bg-white p-4 shadow-sm sm:p-6">
            <h2 class="mb-4 text-xl font-semibold text-slate-900">Form Kelas</h2>

            <form method="POST" action="{{ route('mentor.kelas.store') }}" class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                @csrf

                <label class="block lg:col-span-2">
                    <span class="text-sm font-semibold text-slate-800">Program</span>
                    <select name="program_id" class="mt-1 h-11 w-full border border-slate-400 bg-white px-3 text-slate-900 focus:border-blue-600 focus:ring-2 focus:ring-blue-100" required>
                        <option value="">Pilih program</option>
                        @foreach ($programs as $program)
                            <option value="{{ $program->id }}" @selected(old('program_id') == $program->id)>{{ $program->nama }}</option>
                        @endforeach
                    </select>
                    @error('program_id') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
                </label>

                <label class="block lg:col-span-2">
                    <span class="text-sm font-semibold text-slate-800">Nama Kelas</span>
                    <input name="nama" value="{{ old('nama') }}" class="mt-1 h-11 w-full border border-slate-400 bg-white px-3 text-slate-900 placeholder:text-slate-500 focus:border-blue-600 focus:ring-2 focus:ring-blue-100" required>
                    @error('nama') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
                </label>

                <label class="block lg:col-span-2">
                    <span class="text-sm font-semibold text-slate-800">Deskripsi</span>
                    <textarea name="deskripsi" rows="3" class="mt-1 w-full border border-slate-400 bg-white px-3 py-2 text-slate-900 placeholder:text-slate-500 focus:border-blue-600 focus:ring-2 focus:ring-blue-100">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
                </label>

                <label class="block">
                    <span class="text-sm font-semibold text-slate-800">Mulai</span>
                    <input type="date" name="mulai" value="{{ old('mulai') }}" class="mt-1 h-11 w-full border border-slate-400 bg-white px-3 text-slate-900 focus:border-blue-600 focus:ring-2 focus:ring-blue-100">
                    <p class="mt-1 text-xs text-slate-600">Pilih tanggal mulai kelas.</p>
                    @error('mulai') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
                </label>

                <label class="block">
                    <span class="text-sm font-semibold text-slate-800">Selesai</span>
                    <input type="date" name="selesai" value="{{ old('selesai') }}" class="mt-1 h-11 w-full border border-slate-400 bg-white px-3 text-slate-900 focus:border-blue-600 focus:ring-2 focus:ring-blue-100">
                    <p class="mt-1 text-xs text-slate-600">Tanggal selesai harus sama atau setelah tanggal mulai.</p>
                    @error('selesai') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
                </label>

                <label class="block">
                    <span class="text-sm font-semibold text-slate-800">Kapasitas</span>
                    <input type="number" name="kapasitas" min="1" value="{{ old('kapasitas', 30) }}" class="mt-1 h-11 w-full border border-slate-400 bg-white px-3 text-slate-900 focus:border-blue-600 focus:ring-2 focus:ring-blue-100" required>
                    @error('kapasitas') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
                </label>

                <label class="block">
                    <span class="text-sm font-semibold text-slate-800">Status</span>
                    <select name="status" class="mt-1 h-11 w-full border border-slate-400 bg-white px-3 text-slate-900 focus:border-blue-600 focus:ring-2 focus:ring-blue-100" required>
                        @foreach (['draft' => 'Draft', 'aktif' => 'Aktif'] as $value => $label)
                            <option value="{{ $value }}" @selected(old('status', 'draft') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('status') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
                </label>

                <div class="lg:col-span-2 flex justify-start sm:justify-end">
                    <button type="submit" class="w-full border border-slate-900 bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800 sm:w-auto">Simpan Kelas</button>
                </div>
            </form>
        </div>

        <div class="border border-slate-300 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-slate-300 px-4 py-4 sm:px-6">
                <h2 class="text-lg font-semibold text-slate-900">Kelas Saya</h2>
                <span class="text-sm text-slate-700">{{ $myClasses->count() }} kelas</span>
            </div>
            <div class="divide-y divide-slate-300">
                @forelse ($myClasses as $kelas)
                    <div class="flex flex-col gap-2 px-4 py-5 sm:px-6 lg:flex-row lg:items-center lg:justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-slate-900">{{ $kelas->nama }}</h3>
                            <p class="text-sm text-slate-700">{{ $kelas->program?->nama }} · {{ $kelas->enrollments->count() }} peserta</p>
                            <p class="mt-1 text-xs text-slate-700">Kode Kelas: <span class="font-semibold text-slate-900">{{ $kelas->kode_kelas }}</span> · Status {{ ucfirst($kelas->status) }}</p>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-10 text-center text-sm text-slate-700">Belum ada kelas yang dibuat.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
</x-layouts.app>
