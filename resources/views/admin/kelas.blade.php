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

            @if ($errors->any())
                <div class="mb-4 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
                    <p class="font-semibold">Periksa kembali form berikut:</p>
                    <ul class="mt-2 list-disc space-y-1 pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @php
                $selectedPesertaIds = collect(old('peserta_ids', $editingKelas?->enrollments?->pluck('peserta_id')->all() ?? []))
                    ->map(fn ($id) => (int) $id)
                    ->all();
            @endphp

            <form method="POST" action="{{ $editingKelas ? route('admin.kelas.update', $editingKelas) : route('admin.kelas.store') }}" class="grid gap-4 md:grid-cols-2">
                @csrf
                @if ($editingKelas)
                    @method('PUT')
                @endif

                <label class="block md:col-span-2">
                    <span class="text-sm font-medium text-slate-700">Program</span>
                    <select name="program_id" class="mt-1 w-full rounded-none border border-slate-300 bg-white px-3 py-2 text-slate-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none" required>
                        <option value="">Pilih program</option>
                        @foreach ($programs as $program)
                            <option value="{{ $program->id }}" @selected(old('program_id', $editingKelas?->program_id) == $program->id)>{{ $program->nama }}</option>
                        @endforeach
                    </select>
                </label>

                <label class="block md:col-span-2">
                    <span class="text-sm font-medium text-slate-700">Nama Kelas</span>
                    <input name="nama" value="{{ old('nama', $editingKelas?->nama) }}" class="mt-1 w-full rounded-none border border-slate-300 bg-white px-3 py-2 text-slate-900 placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none" required>
                </label>

                @if ($editingKelas)
                    <label class="block md:col-span-2">
                        <span class="text-sm font-medium text-slate-700">Kode Kelas</span>
                        <input value="{{ $editingKelas->kode_kelas }}" class="mt-1 w-full rounded-none border border-slate-300 bg-slate-100 px-3 py-2 text-slate-900" readonly>
                    </label>
                @endif

                <label class="block md:col-span-2">
                    <span class="text-sm font-medium text-slate-700">Deskripsi</span>
                    <textarea name="deskripsi" rows="3" class="mt-1 w-full rounded-none border border-slate-300 bg-white px-3 py-2 text-slate-900 placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none">{{ old('deskripsi', $editingKelas?->deskripsi) }}</textarea>
                </label>

                <label class="block">
                    <span class="text-sm font-medium text-slate-700">Hari Jadwal</span>
                    <select name="jadwal_hari" class="mt-1 w-full rounded-none border border-slate-300 bg-white px-3 py-2 text-slate-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none">
                        <option value="">Pilih hari</option>
                        @foreach ([
                            'senin' => 'Senin',
                            'selasa' => 'Selasa',
                            'rabu' => 'Rabu',
                            'kamis' => 'Kamis',
                            'jumat' => 'Jumat',
                            'sabtu' => 'Sabtu',
                            'minggu' => 'Minggu',
                        ] as $value => $label)
                            <option value="{{ $value }}" @selected(old('jadwal_hari', $editingKelas?->jadwal_hari) === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                    <p class="mt-2 text-xs text-slate-500">Contoh: Kamis jika kelas dimulai setiap hari Kamis.</p>
                </label>

                <label class="block">
                    <span class="text-sm font-medium text-slate-700">Jam Jadwal</span>
                    <input type="time" name="jadwal_jam" value="{{ old('jadwal_jam', $editingKelas?->jadwal_jam ? \Illuminate\Support\Carbon::parse($editingKelas->jadwal_jam)->format('H:i') : null) }}" class="mt-1 w-full rounded-none border border-slate-300 bg-white px-3 py-2 text-slate-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none">
                    <p class="mt-2 text-xs text-slate-500">Contoh: 09:00.</p>
                </label>

                <label class="block">
                    <span class="text-sm font-medium text-slate-700">Mentor</span>
                    <select name="mentor_id" class="mt-1 w-full rounded-none border border-slate-300 bg-white px-3 py-2 text-slate-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none" required>
                        <option value="">Pilih mentor</option>
                        @foreach ($mentors as $mentor)
                            <option value="{{ $mentor->id }}" @selected(old('mentor_id', $editingKelas?->mentor_id) == $mentor->id)>{{ $mentor->name }}</option>
                        @endforeach
                    </select>
                    @if ($editingKelas?->mentor)
                        <p class="mt-2 text-xs text-slate-500">Mentor saat ini: <span class="font-semibold text-slate-700">{{ $editingKelas->mentor->name }}</span>. Pilih mentor lain jika ingin mengganti.</p>
                    @endif
                </label>

                <label class="block">
                    <span class="text-sm font-medium text-slate-700">Status</span>
                    <select name="status" class="mt-1 w-full rounded-none border border-slate-300 bg-white px-3 py-2 text-slate-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none" required>
                        @foreach (['draft' => 'Draft', 'aktif' => 'Aktif', 'selesai' => 'Selesai'] as $value => $label)
                            <option value="{{ $value }}" @selected(old('status', $editingKelas?->status) === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </label>

                <label class="block">
                    <span class="text-sm font-medium text-slate-700">Mulai</span>
                    <input type="date" name="mulai" value="{{ old('mulai', optional($editingKelas?->mulai)->format('Y-m-d')) }}" class="mt-1 w-full rounded-none border border-slate-300 bg-white px-3 py-2 text-slate-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none">
                </label>

                <label class="block">
                    <span class="text-sm font-medium text-slate-700">Selesai</span>
                    <input type="date" name="selesai" value="{{ old('selesai', optional($editingKelas?->selesai)->format('Y-m-d')) }}" class="mt-1 w-full rounded-none border border-slate-300 bg-white px-3 py-2 text-slate-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none">
                </label>

                <label class="block">
                    <span class="text-sm font-medium text-slate-700">Kapasitas</span>
                    <input type="number" name="kapasitas" value="{{ old('kapasitas', $editingKelas?->kapasitas ?? 30) }}" class="mt-1 w-full rounded-none border border-slate-300 bg-white px-3 py-2 text-slate-900 placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none" required>
                </label>

                <div class="block md:col-span-2">
                    <span class="text-sm font-medium text-slate-700">Kelola Peserta Kelas (Tambah / Hapus Manual)</span>
                    <p class="mt-1 text-xs text-slate-500">Centang peserta yang harus terdaftar pada kelas ini. Hilangkan centang untuk menghapus dari kelas.</p>

                    <div class="mt-3">
                        <input
                            type="search"
                            data-peserta-search
                            placeholder="Cari nama atau email peserta..."
                            class="w-full rounded-none border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none"
                        >
                    </div>

                    <div class="mt-2 max-h-64 space-y-2 overflow-y-auto rounded-none border border-slate-300 bg-white p-3">
                        @foreach ($pesertas as $peserta)
                            <label
                                data-peserta-item
                                data-search="{{ strtolower($peserta->name.' '.$peserta->email) }}"
                                class="grid grid-cols-[auto_minmax(0,1fr)] items-start gap-3 border px-3 py-3 transition-colors"
                            >
                                <input
                                    type="checkbox"
                                    name="peserta_ids[]"
                                    value="{{ $peserta->id }}"
                                    @checked(in_array($peserta->id, $selectedPesertaIds, true))
                                    class="peer sr-only"
                                >
                                <span class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-none border border-rose-500 bg-white text-transparent transition-colors peer-checked:border-emerald-600 peer-checked:bg-white peer-checked:text-emerald-600 peer-focus-visible:ring-2 peer-focus-visible:ring-emerald-400 peer-focus-visible:ring-offset-2">
                                    <svg class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M16.704 5.29a1 1 0 010 1.42l-7.25 7.25a1 1 0 01-1.42 0l-3.25-3.25a1 1 0 111.414-1.42l2.543 2.544 6.543-6.544a1 1 0 011.42 0z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                                <span>
                                    <span class="block text-sm font-medium text-slate-800">{{ $peserta->name }}</span>
                                    <span class="block text-xs text-slate-500">{{ $peserta->email }}</span>
                                </span>
                            </label>
                        @endforeach

                        <p data-peserta-empty class="hidden py-2 text-sm text-slate-500">Peserta tidak ditemukan untuk kata kunci tersebut.</p>
                    </div>
                </div>

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
                            <p class="mt-1 text-xs text-slate-500">Kode: <span class="font-semibold text-slate-700">{{ $kelas->kode_kelas }}</span> · {{ $kelas->enrollments->count() }} peserta / kapasitas {{ $kelas->kapasitas }} · Status {{ ucfirst($kelas->status) }}</p>
                            @if ($kelas->jadwal_hari || $kelas->jadwal_jam)
                                <p class="mt-2 inline-flex rounded-none border border-sky-200 bg-sky-50 px-3 py-1 text-xs font-semibold uppercase tracking-[0.18em] text-sky-700">
                                    Jadwal: {{ ucfirst($kelas->jadwal_hari ?? '-') }} {{ $kelas->jadwal_jam ? \Illuminate\Support\Carbon::parse($kelas->jadwal_jam)->format('H:i') : '' }}
                                </p>
                            @endif
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.querySelector('[data-peserta-search]');
        const pesertaItems = Array.from(document.querySelectorAll('[data-peserta-item]'));
        const emptyState = document.querySelector('[data-peserta-empty]');

        const toggleCheckedStyle = function (item, checkbox) {
            if (checkbox.checked) {
                item.classList.remove('border-rose-300');
                item.classList.add('border-emerald-400');
            } else {
                item.classList.remove('border-emerald-400');
                item.classList.add('border-rose-300');
            }
        };

        const applySearch = function () {
            const keyword = (searchInput?.value ?? '').toLowerCase().trim();
            let visibleCount = 0;

            pesertaItems.forEach(function (item) {
                const haystack = item.getAttribute('data-search') ?? '';
                const isVisible = keyword === '' || haystack.includes(keyword);

                item.classList.toggle('hidden', !isVisible);
                if (isVisible) {
                    visibleCount++;
                }
            });

            if (emptyState) {
                emptyState.classList.toggle('hidden', visibleCount > 0);
            }
        };

        pesertaItems.forEach(function (item) {
            const checkbox = item.querySelector('input[type="checkbox"]');
            if (!checkbox) {
                return;
            }

            toggleCheckedStyle(item, checkbox);
            checkbox.addEventListener('change', function () {
                toggleCheckedStyle(item, checkbox);
            });
        });

        if (searchInput) {
            searchInput.addEventListener('input', applySearch);
            applySearch();
        }
    });
</script>
</x-layouts.app>