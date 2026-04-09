<x-layouts.app>
<div class="min-h-screen bg-slate-50 py-10">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-8">
        <div class="flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-blue-600">Admin</p>
                <h1 class="text-3xl font-bold text-slate-900">Laporan & Statistik</h1>
                <p class="mt-2 text-slate-600">Ringkasan sistem, keaktifan kelas, dan ekspor data.</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-100">Kembali ke Dashboard</a>
        </div>

        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200"><p class="text-sm text-slate-500">Total User</p><p class="mt-2 text-3xl font-bold text-slate-900">{{ $totalUsers }}</p></div>
            <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200"><p class="text-sm text-slate-500">Program</p><p class="mt-2 text-3xl font-bold text-slate-900">{{ $totalPrograms }}</p></div>
            <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200"><p class="text-sm text-slate-500">Kelas Aktif</p><p class="mt-2 text-3xl font-bold text-slate-900">{{ $activeClasses }}</p></div>
            <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200"><p class="text-sm text-slate-500">Enrollment</p><p class="mt-2 text-3xl font-bold text-slate-900">{{ $totalEnrollments }}</p></div>
        </div>

        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-slate-900">Ekspor Data</h2>
                    <p class="text-sm text-slate-500">CSV siap dibuka di Excel. PDF bisa dibuat lewat print browser dari halaman ini.</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('admin.reports.export-users') }}" class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">Export User CSV</a>
                    <a href="{{ route('admin.reports.export-classes') }}" class="rounded-xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">Export Kelas CSV</a>
                </div>
            </div>
        </div>

        <div class="grid gap-8 xl:grid-cols-2">
            <div class="rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">
                <div class="border-b border-slate-200 px-6 py-4"><h2 class="text-lg font-semibold text-slate-900">Keaktifan Kelas</h2></div>
                <div class="divide-y divide-slate-200">
                    @foreach ($classes as $kelas)
                        <div class="px-6 py-4">
                            <div class="flex items-center justify-between gap-4">
                                <div>
                                    <p class="font-semibold text-slate-900">{{ $kelas->nama }}</p>
                                    <p class="text-sm text-slate-500">{{ $kelas->program?->nama }} · Mentor {{ $kelas->mentor?->name }}</p>
                                </div>
                                <div class="text-right text-sm text-slate-500">
                                    <p>{{ $kelas->enrollments->count() }} peserta</p>
                                    <p>{{ ucfirst($kelas->status) }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">
                <div class="border-b border-slate-200 px-6 py-4"><h2 class="text-lg font-semibold text-slate-900">Pengumuman Terbaru</h2></div>
                <div class="divide-y divide-slate-200">
                    @foreach ($announcements as $announcement)
                        <div class="px-6 py-4">
                            <p class="font-semibold text-slate-900">{{ $announcement->judul }}</p>
                            <p class="mt-1 text-sm text-slate-600">{{ $announcement->target }} · {{ $announcement->published_at?->diffForHumans() }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
</x-layouts.app>