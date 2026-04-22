<x-layouts.app>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Kelas Saya') }}
        </h2>
    </x-slot>
    
    <div class="h-full bg-slate-50 py-8 sm:py-10">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            <section class="overflow-hidden rounded-none border border-sky-700 bg-gradient-to-r from-sky-700 to-sky-600 px-6 py-7 text-white shadow-lg shadow-sky-300/20 sm:px-8">
                <div class="space-y-3">
                    <p class="text-xs font-semibold uppercase tracking-[0.32em] text-sky-200/80">Kelas Saya</p>
                    <h3 class="text-3xl font-bold">Daftar Kelas yang Diikuti</h3>
                    <p class="max-w-2xl text-sm text-sky-100/90">Lihat semua kelas aktif Anda, cek mentor, status keikutsertaan, dan materi.</p>
                </div>
            </section>

            @if (session('status'))
                <div class="rounded-none border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                    {{ session('status') }}
                </div>
            @endif
            <!-- Join Kelas -->
            <section class="rounded-none border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                <div class="flex flex-col gap-5 items-center lg:flex-row lg:justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-500">Join Kelas</p>
                        <h2 class="mt-2 text-2xl font-semibold text-slate-900">Masukkan Kode Kelas</h2>
                        <p class="mt-1 text-sm text-slate-600">Gunakan kode kelas dari admin atau mentor untuk bergabung ke kelas aktif.</p>
                    </div>

                    <form method="POST" action="{{ route('peserta.kelas.join') }}" class="w-full lg:max-w-md">
                        @csrf
                        <div class="grid gap-2 sm:grid-cols-[1fr_auto]">
                            <input name="kode_kelas" value="{{ old('kode_kelas') }}" placeholder="Contoh: AB12CD34" class="w-full rounded-none border border-slate-300 bg-white px-3 py-2.5 text-slate-900 uppercase placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none" required>
                            <button type="submit" class="rounded-none bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800">Join</button>
                        </div>
                    </form>
                </div>

                @error('kode_kelas')
                    <p class="mt-3 text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </section>

            <!-- Akses Cepat -->
            <section class="grid gap-4 lg:grid-cols-4">
                <a href="{{ route('peserta.presensi.index') }}" class="rounded-none border border-slate-200 bg-white p-4 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
                    Konfirmasi Kehadiran
                </a>
                <a href="{{ route('peserta.kelas.index') }}" class="rounded-none border border-slate-200 bg-white p-4 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
                    Cari Kelas Baru
                </a>
                <a href="{{ route('peserta.progress') }}" class="rounded-none border border-slate-200 bg-white p-4 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
                    Progress Belajar
                </a>
                <a href="{{ route('peserta.announcements.index') }}" class="rounded-none border border-slate-200 bg-white p-4 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
                    Semua Pengumuman
                </a>
            </section>

            <!-- Kelas yang Diikuti -->
            <section class="grid grid-cols-1 gap-6 items-stretch md:grid-cols-2 xl:grid-cols-3 auto-rows-fr">
                @if ($enrolledClasses->count() > 0)
                    @foreach ($enrolledClasses as $enrollment)
                    <article class="flex h-full flex-col rounded-none border border-slate-200 bg-white p-4 shadow-sm">
                        <div class="flex flex-1 flex-col">
                            
                            <div class="mb-4">
                                <h4 class="text-2xl font-semibold leading-tight text-slate-900 line-clamp-2 min-h-[4rem]">
                                    {{ $enrollment->kelas->nama }}
                                </h4>
                                <p class="mt-2 text-sm leading-6 text-slate-600 line-clamp-3 min-h-[4.5rem]">
                                    {{ $enrollment->kelas->deskripsi }}
                                </p>
                            </div>

                            <div class="space-y-3 border-y border-slate-100 py-4 text-sm text-slate-700">
                                <p class="flex justify-between">
                                    <span class="font-semibold text-slate-900">Mentor:</span> 
                                    <span class="text-right">{{ $enrollment->kelas->mentor->name }}</span>
                                </p>
                                <p class="flex justify-between">
                                    <span class="font-semibold text-slate-900">Status:</span> 
                                    <span>{{ ucfirst($enrollment->status) }}</span>
                                </p>
                                
                                <div class="min-h-[1.25rem]">
                                    @if ($enrollment->kelas->jadwal_hari_label || $enrollment->kelas->jadwal_jam_label)
                                        <p class="flex justify-between">
                                            <span class="font-semibold text-slate-900">Jadwal:</span> 
                                            <span class="text-right text-xs">{{ $enrollment->kelas->jadwal_hari_label ?? '-' }}{{ $enrollment->kelas->jadwal_jam_label ? ' · '.$enrollment->kelas->jadwal_jam_label : '' }}</span>
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('peserta.kelas.show', $enrollment->kelas) }}" class="mt-5 inline-flex items-center justify-center rounded-none bg-sky-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-sky-700">
                            Lihat Kelas
                        </a>
                    </article>
                    @endforeach
                @else
                    <div class="rounded-none border border-slate-200 bg-white p-8 text-center shadow-sm md:col-span-2 xl:col-span-3">
                        <p class="text-slate-600">Anda belum terdaftar di kelas manapun.</p>
                    </div>
                @endif
            </section>
        </div>
    </div>
</x-layouts.app>