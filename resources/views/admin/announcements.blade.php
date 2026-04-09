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

            <form method="POST" action="{{ $editingAnnouncement ? route('admin.announcements.update', $editingAnnouncement) : route('admin.announcements.store') }}" class="grid gap-4 md:grid-cols-2">
                @csrf
                @if ($editingAnnouncement)
                    @method('PUT')
                @endif

                <label class="block md:col-span-2">
                    <span class="text-sm font-medium text-slate-700">Judul</span>
                    <input name="judul" value="{{ old('judul', $editingAnnouncement?->judul) }}" class="mt-1 w-full rounded-xl border-slate-300 bg-white text-slate-900 placeholder:text-slate-400 focus:border-blue-500 focus:ring-blue-500" required>
                </label>

                <label class="block md:col-span-2">
                    <span class="text-sm font-medium text-slate-700">Isi</span>
                    <textarea name="isi" rows="5" class="mt-1 w-full rounded-xl border-slate-300 bg-white text-slate-900 placeholder:text-slate-400 focus:border-blue-500 focus:ring-blue-500" required>{{ old('isi', $editingAnnouncement?->isi) }}</textarea>
                </label>

                <label class="block md:col-span-2">
                    <span class="text-sm font-medium text-slate-700">Target</span>
                    <select name="target" class="mt-1 w-full rounded-xl border-slate-300 bg-white text-slate-900 focus:border-blue-500 focus:ring-blue-500" required>
                        @foreach (['all' => 'Semua User', 'admin' => 'Admin', 'mentor' => 'Mentor', 'peserta' => 'Peserta'] as $value => $label)
                            <option value="{{ $value }}" @selected(old('target', $editingAnnouncement?->target ?? 'all') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </label>

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
                                <p class="mt-2 text-sm leading-6 text-slate-600">{{ $announcement->isi }}</p>
                                <div class="mt-3 flex flex-wrap gap-2 text-xs text-slate-500">
                                    <span class="rounded-full bg-slate-100 px-3 py-1">Target: {{ $announcement->target }}</span>
                                    <span class="rounded-full bg-slate-100 px-3 py-1">Oleh: {{ $announcement->creator?->name }}</span>
                                    <span class="rounded-full bg-slate-100 px-3 py-1">{{ $announcement->published_at?->diffForHumans() }}</span>
                                </div>
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
</x-layouts.app>