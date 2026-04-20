<x-layouts.app>
<div class="min-h-screen bg-slate-50 py-10">
    <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 space-y-8">
        <div class="flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-blue-600">Admin</p>
                <h1 class="text-3xl font-bold text-slate-900">Pengumuman Global</h1>
                <p class="mt-2 text-slate-600">Kirim info ke semua user, mentor, atau peserta.</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-100">Kembali ke Dashboard</a>
        </div>

        @if (session('status'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
                <p class="font-semibold">Periksa kembali form berikut:</p>
                <ul class="mt-2 list-disc space-y-1 pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-slate-900">Buat Pengumuman</h2>
                    <p class="text-sm text-slate-500">Contoh: jadwal pelatihan, sertifikat, atau maintenance sistem.</p>
                </div>
                @if ($editingAnnouncement)
                    <a href="{{ route('admin.announcements.index') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-700">Batal edit</a>
                @endif
            </div>

            @php
                $selectedUserIds = collect(old('user_ids', $editingAnnouncement?->targetedUsers?->pluck('id')->all() ?? []))
                    ->map(fn ($id) => (int) $id)
                    ->all();
            @endphp

            <form method="POST" enctype="multipart/form-data" action="{{ $editingAnnouncement ? route('admin.announcements.update', $editingAnnouncement) : route('admin.announcements.store') }}" class="grid gap-4 md:grid-cols-2">
                @csrf
                @if ($editingAnnouncement)
                    @method('PUT')
                @endif

                <label class="block md:col-span-2">
                    <span class="text-sm font-medium text-slate-700">Judul</span>
                    <input name="judul" value="{{ old('judul', $editingAnnouncement?->judul) }}" class="mt-1 w-full rounded-none border border-slate-300 bg-white px-3 py-2 text-slate-900 placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none" required>
                </label>

                <label class="block md:col-span-2">
                    <span class="text-sm font-medium text-slate-700">Isi</span>
                    <textarea name="isi" rows="5" class="mt-1 w-full rounded-none border border-slate-300 bg-white px-3 py-2 text-slate-900 placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none" required>{{ old('isi', $editingAnnouncement?->isi) }}</textarea>
                </label>

                <label class="block md:col-span-2">
                    <span class="text-sm font-medium text-slate-700">Target</span>
                    <select name="target" class="mt-1 w-full rounded-none border border-slate-300 bg-white px-3 py-2 text-slate-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none" required>
                        @foreach (['all' => 'Semua User', 'admin' => 'Admin', 'mentor' => 'Mentor', 'peserta' => 'Peserta'] as $value => $label)
                            <option value="{{ $value }}" @selected(old('target', $editingAnnouncement?->target ?? 'all') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </label>

                <label class="block md:col-span-2">
                    <span class="text-sm font-medium text-slate-700">Gambar Pengumuman (Opsional)</span>
                    <input type="file" name="image" accept="image/png,image/jpeg,image/webp" class="mt-1 w-full rounded-none border border-slate-300 bg-white px-3 py-2 text-slate-900 file:mr-3 file:rounded-none file:border-0 file:bg-slate-900 file:px-3 file:py-1.5 file:text-sm file:font-semibold file:text-white hover:file:bg-slate-800 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none">
                    <p class="mt-1 text-xs text-slate-500">Maksimal 2MB, format JPG/PNG/WEBP.</p>
                    @if ($editingAnnouncement?->image_path)
                        <img src="{{ asset('storage/'.$editingAnnouncement->image_path) }}" alt="Gambar pengumuman" class="mt-3 h-36 w-auto rounded-none border border-slate-200 object-cover">
                    @endif
                </label>

                <div class="block md:col-span-2">
                    <span class="text-sm font-medium text-slate-700">Pilih User Spesifik (Real-time Access)</span>
                    <p class="mt-1 text-xs text-slate-500">Jika ada user dipilih, pengumuman hanya bisa diakses user tersebut. Kosongkan jika ingin memakai target umum.</p>
                    <input
                        type="search"
                        data-user-search
                        placeholder="Cari user berdasarkan nama atau email..."
                        class="mt-2 w-full rounded-none border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none"
                    >
                    <div class="mt-2 max-h-64 space-y-2 overflow-y-auto rounded-none border border-slate-300 bg-white p-3">
                        @foreach ($users as $user)
                            <label
                                data-user-item
                                data-search="{{ strtolower($user->name.' '.$user->email) }}"
                                class="grid grid-cols-[auto_minmax(0,1fr)] items-start gap-3 border px-3 py-2 transition-colors"
                            >
                                <input
                                    type="checkbox"
                                    name="user_ids[]"
                                    value="{{ $user->id }}"
                                    @checked(in_array($user->id, $selectedUserIds, true))
                                    class="peer sr-only"
                                >
                                <span class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-none border border-slate-300 bg-white text-transparent transition-colors peer-checked:border-emerald-600 peer-checked:text-emerald-600 peer-focus-visible:ring-2 peer-focus-visible:ring-emerald-400 peer-focus-visible:ring-offset-2">
                                    <svg class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M16.704 5.29a1 1 0 010 1.42l-7.25 7.25a1 1 0 01-1.42 0l-3.25-3.25a1 1 0 111.414-1.42l2.543 2.544 6.543-6.544a1 1 0 011.42 0z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                                <span>
                                    <span class="block text-sm font-medium text-slate-800">{{ $user->name }}</span>
                                    <span class="block text-xs text-slate-500">{{ $user->email }} · {{ ucfirst($user->role ?? 'user') }}</span>
                                </span>
                            </label>
                        @endforeach

                        <p data-user-empty class="hidden py-2 text-sm text-slate-500">User tidak ditemukan untuk kata kunci tersebut.</p>
                    </div>
                </div>

                <div class="md:col-span-2 flex justify-end">
                    <button type="submit" class="rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white hover:bg-slate-800">Kirim Pengumuman</button>
                </div>
            </form>
        </div>

        <div class="rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">
            <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
                <h2 class="text-lg font-semibold text-slate-900">Riwayat Pengumuman</h2>
                <span class="text-sm text-slate-500">{{ $announcements->count() }} pengumuman</span>
            </div>
            <div class="divide-y divide-slate-200">
                @foreach ($announcements as $announcement)
                    <div class="px-6 py-5">
                        <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                            <div class="max-w-3xl">
                                <h3 class="text-lg font-semibold text-slate-900">{{ $announcement->judul }}</h3>
                                @if ($announcement->image_path)
                                    <img src="{{ asset('storage/'.$announcement->image_path) }}" alt="Gambar {{ $announcement->judul }}" class="mt-3 h-44 w-full max-w-md rounded-none border border-slate-200 object-cover">
                                @endif
                                <p class="mt-2 text-sm leading-6 text-slate-600">{{ $announcement->isi }}</p>
                                <div class="mt-3 flex flex-wrap gap-2 text-xs text-slate-500">
                                    @if ($announcement->targetedUsers->isNotEmpty())
                                        <span class="rounded-full bg-emerald-100 px-3 py-1 font-semibold text-emerald-700">Target: Spesifik ({{ $announcement->targetedUsers->count() }} user)</span>
                                    @else
                                        <span class="rounded-full bg-slate-100 px-3 py-1">Target: {{ $announcement->target }}</span>
                                    @endif
                                    <span class="rounded-full bg-slate-100 px-3 py-1">Oleh: {{ $announcement->creator?->name }}</span>
                                    <span class="rounded-full bg-slate-100 px-3 py-1">{{ $announcement->published_at?->diffForHumans() }}</span>
                                </div>
                                @if ($announcement->targetedUsers->isNotEmpty())
                                    @php
                                        $targetedUserNames = $announcement->targetedUsers->take(5)->pluck('name')->implode(', ');
                                        $targetedUserSuffix = $announcement->targetedUsers->count() > 5 ? ', dan lainnya' : '';
                                    @endphp
                                    <p class="mt-2 text-xs text-slate-500">
                                        User dipilih: {{ $targetedUserNames }}{{ $targetedUserSuffix }}
                                    </p>
                                @endif
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ route('admin.announcements.index', ['edit' => $announcement->id]) }}" class="rounded-lg border border-blue-200 px-3 py-1.5 text-sm font-semibold text-blue-700 hover:bg-blue-50">Edit</a>
                                <form method="POST" action="{{ route('admin.announcements.destroy', $announcement) }}" onsubmit="return confirm('Hapus pengumuman ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-lg border border-rose-200 px-3 py-1.5 text-sm font-semibold text-rose-700 hover:bg-rose-50">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.querySelector('[data-user-search]');
        const userItems = Array.from(document.querySelectorAll('[data-user-item]'));
        const emptyState = document.querySelector('[data-user-empty]');

        const applyCheckedStyle = function (item, checkbox) {
            if (checkbox.checked) {
                item.classList.remove('border-slate-200');
                item.classList.add('border-emerald-400');
            } else {
                item.classList.remove('border-emerald-400');
                item.classList.add('border-slate-200');
            }
        };

        const applySearch = function () {
            const keyword = (searchInput?.value ?? '').toLowerCase().trim();
            let visibleCount = 0;

            userItems.forEach(function (item) {
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

        userItems.forEach(function (item) {
            const checkbox = item.querySelector('input[type="checkbox"]');
            if (!checkbox) {
                return;
            }

            applyCheckedStyle(item, checkbox);
            checkbox.addEventListener('change', function () {
                applyCheckedStyle(item, checkbox);
            });
        });

        if (searchInput) {
            searchInput.addEventListener('input', applySearch);
            applySearch();
        }
    });
</script>
</x-layouts.app>