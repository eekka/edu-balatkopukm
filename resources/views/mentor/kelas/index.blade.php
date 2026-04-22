<x-layouts.app>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Kelas Saya') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 h-full">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between overflow-hidden rounded-none bg-gradient-to-r from-sky-700 to-sky-600 p-8 shadow-xl shadow-sky-400/20">
                <div class="space-y-3 text-white">
                    <p class="text-xs font-semibold uppercase tracking-[0.32em] text-sky-200/80">Kelas Saya</p>
                    <h3 class="text-3xl font-bold">Kelola Kelas Anda</h3>
                    <p class="max-w-2xl text-sm text-sky-100/90">Buat, lihat, dan kelola kelas yang Anda tangani sebagai mentor.</p>
                </div>
                <div>
                    <a href="{{ route('mentor.kelas.create') }}" class="inline-flex items-center justify-center rounded-none bg-white px-4 py-3 text-sm font-semibold text-sky-700 transition hover:bg-slate-100">
                        <flux:icon.plus />
                        <span class="ml-2">Buat Kelas Baru</span>
                    </a>
                </div>
            </div>

            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($myClasses as $kelas)
                    <div class="flex flex-col h-full rounded-none border border-slate-200 bg-white p-6 shadow-lg shadow-slate-300/20">
                        <div class="flex flex-col h-full justify-between gap-4">
                            <div>
                                <h4 class="text-xl font-semibold text-slate-900">{{ $kelas->nama }}</h4>
                                <p class="mt-2 text-sm text-slate-500">{{ $kelas->deskripsi }}</p>
                            </div>

                            <div class="grid gap-3 text-sm text-slate-600">
                                <p><span class="font-semibold text-slate-900">Program:</span> {{ $kelas->program?->nama ?? '-' }}</p>
                                <p><span class="font-semibold text-slate-900">Peserta:</span> {{ $kelas->enrollments->count() }} / {{ $kelas->kapasitas }}</p>
                                <p><span class="font-semibold text-slate-900">Kode:</span> {{ $kelas->kode_kelas }}</p>
                            </div>

                            <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                <span class="inline-flex rounded-none bg-sky-100 px-4 py-2 text-sm font-semibold text-sky-700">{{ ucfirst($kelas->status) }}</span>
                                <a href="{{ route('mentor.kelas.show', $kelas) }}" class="inline-flex items-center justify-center rounded-none bg-sky-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-sky-700">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="rounded-none border border-slate-200 bg-white p-8 shadow-lg shadow-slate-300/20 lg:col-span-3">
                        <p class="text-slate-600">Belum ada kelas yang Anda kelola. Buat kelas baru untuk mulai mengundang peserta.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-layouts.app>