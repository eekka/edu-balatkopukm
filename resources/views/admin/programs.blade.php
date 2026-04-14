<x-layouts.app>
<div class="min-h-screen bg-slate-50 py-10">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-8">
        <div class="flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-blue-600">Admin</p>
                <h1 class="text-3xl font-bold text-slate-900">Manajemen Program</h1>
                <p class="mt-2 text-slate-600">Tambah, edit, dan hapus kategori pelatihan besar.</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-100">Kembali ke Dashboard</a>
        </div>

        @if (session('status'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800">{{ session('status') }}</div>
        @endif

        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-slate-900">{{ $editingProgram ? 'Edit Program' : 'Tambah Program' }}</h2>
                    <p class="text-sm text-slate-500">Contoh: Pelatihan Digital Marketing, Pemrograman, Multimedia.</p>
                </div>
                @if ($editingProgram)
                    <a href="{{ route('admin.programs.index') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-700">Batal edit</a>
                @endif
            </div>

            <form method="POST" action="{{ $editingProgram ? route('admin.programs.update', $editingProgram) : route('admin.programs.store') }}" class="grid gap-4 md:grid-cols-2">
                @csrf
                @if ($editingProgram)
                    @method('PUT')
                @endif

                <label class="block md:col-span-2">
                    <span class="text-sm font-medium text-slate-700">Nama Program</span>
                    <input name="nama" value="{{ old('nama', $editingProgram?->nama) }}" class="mt-1 w-full rounded-none border border-slate-300 bg-white px-3 py-2 text-slate-900 placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none" required>
                </label>

                <label class="block md:col-span-2">
                    <span class="text-sm font-medium text-slate-700">Deskripsi</span>
                    <textarea name="deskripsi" rows="4" class="mt-1 w-full rounded-none border border-slate-300 bg-white px-3 py-2 text-slate-900 placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none">{{ old('deskripsi', $editingProgram?->deskripsi) }}</textarea>
                </label>

                <label class="block md:col-span-2">
                    <span class="text-sm font-medium text-slate-700">Icon</span>
                    <input name="icon" value="{{ old('icon', $editingProgram?->icon) }}" class="mt-1 w-full rounded-none border border-slate-300 bg-white px-3 py-2 text-slate-900 placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none" placeholder="briefcase, computer, chart-line">
                </label>

                <div class="md:col-span-2 flex justify-end">
                    <button type="submit" class="rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white hover:bg-slate-800">{{ $editingProgram ? 'Update Program' : 'Simpan Program' }}</button>
                </div>
            </form>
        </div>

        <div class="rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">
            <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
                <h2 class="text-lg font-semibold text-slate-900">Daftar Program</h2>
                <span class="text-sm text-slate-500">{{ $programs->count() }} program</span>
            </div>
            <div class="divide-y divide-slate-200">
                @foreach ($programs as $program)
                    <div class="flex flex-col gap-4 px-6 py-5 md:flex-row md:items-center md:justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-slate-900">{{ $program->nama }}</h3>
                            <p class="mt-1 text-sm text-slate-600">{{ $program->deskripsi ?: 'Tidak ada deskripsi.' }}</p>
                            <p class="mt-1 text-xs text-slate-500">{{ $program->kelas_count }} kelas</p>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('admin.programs.index', ['edit' => $program->id]) }}" class="rounded-lg border border-blue-200 px-3 py-1.5 text-sm font-semibold text-blue-700 hover:bg-blue-50">Edit</a>
                            <form method="POST" action="{{ route('admin.programs.destroy', $program) }}" onsubmit="return confirm('Hapus program ini?')">
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