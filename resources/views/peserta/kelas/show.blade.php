<x-layouts.app>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Kelas: ') . $kelas->nama }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 h-full">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-[32px] bg-gradient-to-r from-sky-700 to-sky-600 p-8 shadow-xl shadow-sky-400/20">
                <div class="space-y-3 text-white">
                    <p class="text-xs font-semibold uppercase tracking-[0.32em] text-sky-200/80">Detail Kelas</p>
                    <h3 class="text-3xl font-bold">{{ $kelas->nama }}</h3>
                    <p class="max-w-2xl text-sm text-sky-100/90">{{ $kelas->deskripsi }}</p>
                </div>
            </div>

            <div class="mt-8 grid gap-6 lg:grid-cols-3">
                <div class="rounded-[28px] border border-slate-200 bg-white p-6 shadow-lg shadow-slate-300/20">
                    <p class="text-xs uppercase tracking-[0.32em] text-sky-700">Mentor</p>
                    <p class="mt-3 text-xl font-semibold text-slate-900">{{ $kelas->mentor->name }}</p>
                </div>

                <div class="rounded-[28px] border border-slate-200 bg-sky-50/90 p-6 shadow-lg shadow-sky-200/30">
                    <p class="text-xs uppercase tracking-[0.32em] text-sky-700">Status Pendaftaran</p>
                    <p class="mt-3 text-xl font-semibold text-slate-900">{{ ucfirst($enrollment->status) }}</p>
                </div>

                <div class="rounded-[28px] border border-slate-200 bg-white p-6 shadow-lg shadow-slate-300/20">
                    <p class="text-xs uppercase tracking-[0.32em] text-sky-700">Jumlah Materi</p>
                    <p class="mt-3 text-xl font-semibold text-slate-900">{{ $kelas->materis->count() ?? 0 }}</p>
                </div>
            </div>

            <div class="mt-6 grid gap-6 lg:grid-cols-2">
                <div class="rounded-[28px] border border-slate-200 bg-white p-6 shadow-lg shadow-slate-300/20">
                    <h4 class="text-lg font-semibold text-slate-900">Deskripsi Kelas</h4>
                    <p class="mt-4 text-sm leading-7 text-slate-600">{{ $kelas->deskripsi }}</p>
                </div>

                <div class="rounded-[28px] border border-slate-200 bg-sky-50/90 p-6 shadow-lg shadow-sky-200/30">
                    <h4 class="text-lg font-semibold text-slate-900">Aksi Cepat</h4>
                    <p class="mt-4 text-sm leading-7 text-slate-600">Mulai materi, cek tugas, dan pantau kemajuan kelas Anda dari halaman ini.</p>
                    <a href="{{ route('peserta.kelas.index') }}" class="mt-6 inline-flex items-center justify-center rounded-2xl bg-sky-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-sky-700">
                        Kembali ke Kelas Saya
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>