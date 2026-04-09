<x-layouts.app>
<div class="min-h-screen bg-slate-50 py-10">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-8">
        <div class="flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-blue-600">Admin</p>
                <h1 class="text-3xl font-bold text-slate-900">Manajemen Kelas</h1>
                <p class="mt-2 text-slate-600">Buat kelas, tentukan mentor, tambah peserta, dan atur jadwal.</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-100">Kembali ke Dashboard</a>
        </div>

        @if (session('status'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800">{{ session('status') }}</div>
        @endif

        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-slate-900">{{ $editingKelas ? 'Edit Kelas' : 'Buat Kelas' }}</h2>
                    <p class="text-sm text-slate-500">Form ini juga untuk menetapkan mentor dan peserta kelas.</p>
                </div>
                @if ($editingKelas)
                    <a href="{{ route('admin.kelas.index') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-700">Batal edit</a>
                @endif
            </div>

            <form method="POST" action="{{ $editingKelas ? route('admin.kelas.update', $editingKelas) : route('admin.kelas.store') }}" class="grid gap-4 md:grid-cols-2">
                @csrf
                @if ($editingKelas)
                    @method('PUT')
                @endif

                <label class="block md:col-span-2">
                    <span class="text-sm font-medium text-slate-700">Program</span>
                    <select name="program_id" class="mt-1 w-full rounded-xl border-slate-300 bg-white text-slate-900 focus:border-blue-500 focus:ring-blue-500" required>
                        <option value="">Pilih program</option>
                        @foreach ($programs as $program)
                            <option value="{{ $program->id }}" @selected(old('program_id', $editingKelas?->program_id) == $program->id)>{{ $program->nama }}</option>
                        @endforeach
                    </select>
                </label>

                <label class="block md:col-span-2">
                    <span class="text-sm font-medium text-slate-700">Nama Kelas</span>
                    <input name="nama" value="{{ old('nama', $editingKelas?->nama) }}" class="mt-1 w-full rounded-xl border-slate-300 bg-white text-slate-900 placeholder:text-slate-400 focus:border-blue-500 focus:ring-blue-500" required>
                </label>

                <label class="block md:col-span-2">
                    <span class="text-sm font-medium text-slate-700">Deskripsi</span>
                    <textarea name="deskripsi" rows="3" class="mt-1 w-full rounded-xl border-slate-300 bg-white text-slate-900 placeholder:text-slate-400 focus:border-blue-500 focus:ring-blue-500">{{ old('deskripsi', $editingKelas?->deskripsi) }}</textarea>
                </label>

                <label class="block">
                    <span class="text-sm font-medium text-slate-700">Mentor</span>
                    <select name="mentor_id" class="mt-1 w-full rounded-xl border-slate-300 bg-white text-slate-900 focus:border-blue-500 focus:ring-blue-500" required>
                        <option value="">Pilih mentor</option>
                        @foreach ($mentors as $mentor)
                            <option value="{{ $mentor->id }}" @selected(old('mentor_id', $editingKelas?->mentor_id) == $mentor->id)>{{ $mentor->name }}</option>
                        @endforeach
                    </select>
                </label>

                <label class="block">
                    <span class="text-sm font-medium text-slate-700">Status</span>
                    <select name="status" class="mt-1 w-full rounded-xl border-slate-300 bg-white text-slate-900 focus:border-blue-500 focus:ring-blue-500" required>
                        @foreach (['draft' => 'Draft', 'aktif' => 'Aktif', 'selesai' => 'Selesai'] as $value => $label)
                            <option value="{{ $value }}" @selected(old('status', $editingKelas?->status) === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </label>

                <label class="block">
                    <span class="text-sm font-medium text-slate-700">Mulai</span>
                    <input type="datetime-local" name="mulai" value="{{ old('mulai', optional($editingKelas?->mulai)->format('Y-m-d\TH:i')) }}" class="mt-1 w-full rounded-xl border-slate-300 bg-white text-slate-900 focus:border-blue-500 focus:ring-blue-500">
                </label>

                <label class="block">
                    <span class="text-sm font-medium text-slate-700">Selesai</span>
                    <input type="datetime-local" name="selesai" value="{{ old('selesai', optional($editingKelas?->selesai)->format('Y-m-d\TH:i')) }}" class="mt-1 w-full rounded-xl border-slate-300 bg-white text-slate-900 focus:border-blue-500 focus:ring-blue-500">
                </label>

                <label class="block">
                    <span class="text-sm font-medium text-slate-700">Kapasitas</span>
                    <input type="number" name="kapasitas" value="{{ old('kapasitas', $editingKelas?->kapasitas ?? 30) }}" class="mt-1 w-full rounded-xl border-slate-300 bg-white text-slate-900 placeholder:text-slate-400 focus:border-blue-500 focus:ring-blue-500" required>
                </label>

                <label class="block">
                    <span class="text-sm font-medium text-slate-700">Peserta Terdaftar</span>
                    <input type="number" name="peserta_terdaftar" value="{{ old('peserta_terdaftar', $editingKelas?->peserta_terdaftar ?? 0) }}" class="mt-1 w-full rounded-xl border-slate-300 bg-white text-slate-900 placeholder:text-slate-400 focus:border-blue-500 focus:ring-blue-500">
                </label>

                <label class="block md:col-span-2">
                    <span class="text-sm font-medium text-slate-700">Tambah Peserta ke Kelas</span>
                    <select name="peserta_ids[]" multiple class="mt-1 h-48 w-full rounded-xl border-slate-300 bg-white text-slate-900 focus:border-blue-500 focus:ring-blue-500">
                        @foreach ($pesertas as $peserta)
                            <option value="{{ $peserta->id }}" @selected(collect(old('peserta_ids', $editingKelas?->enrollments?->pluck('peserta_id')->all() ?? []))->contains($peserta->id))>{{ $peserta->name }} - {{ $peserta->email }}</option>
                        @endforeach
                    </select>
                </label>

                <div class="md:col-span-2 flex justify-end">
                    <button type="submit" class="rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white hover:bg-slate-800">{{ $editingKelas ? 'Update Kelas' : 'Simpan Kelas' }}</button>
                </div>
            </form>
        </div>

        <div class="rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">
            <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
                <h2 class="text-lg font-semibold text-slate-900">Daftar Kelas</h2>
                <span class="text-sm text-slate-500">{{ $kelasList->count() }} kelas</span>
            </div>
            <div class="divide-y divide-slate-200">
                @foreach ($kelasList as $kelas)
                    <div class="flex flex-col gap-4 px-6 py-5 lg:flex-row lg:items-center lg:justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-slate-900">{{ $kelas->nama }}</h3>
                            <p class="text-sm text-slate-600">{{ $kelas->program?->nama }} · Mentor: {{ $kelas->mentor?->name }}</p>
                            <p class="mt-1 text-xs text-slate-500">{{ $kelas->enrollments->count() }} peserta / kapasitas {{ $kelas->kapasitas }} · Status {{ ucfirst($kelas->status) }}</p>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('admin.kelas.index', ['edit' => $kelas->id]) }}" class="rounded-lg border border-blue-200 px-3 py-1.5 text-sm font-semibold text-blue-700 hover:bg-blue-50">Edit</a>
                            <form method="POST" action="{{ route('admin.kelas.destroy', $kelas) }}" onsubmit="return confirm('Hapus kelas ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="rounded-lg border border-rose-200 px-3 py-1.5 text-sm font-semibold text-rose-700 hover:bg-rose-50">Hapus</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
</x-layouts.app>