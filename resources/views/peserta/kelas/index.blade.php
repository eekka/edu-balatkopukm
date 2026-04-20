<x-layouts.app>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Kelas Saya') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 h-full">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center overflow-hidden rounded-[32px] bg-gradient-to-r from-sky-700 to-sky-600 p-8 shadow-xl shadow-sky-400/20">
                <div class="space-y-3 text-white">
                    <p class="text-xs font-semibold uppercase tracking-[0.32em] text-sky-200/80">Kelas Saya</p>
                    <h3 class="text-3xl font-bold">Daftar Kelas yang Diikuti</h3>
                    <p class="max-w-2xl text-sm text-sky-100/90">Lihat semua kelas aktif Anda, cek mentor, status keikutsertaan, dan materi.</p>
                </div>
            </div>
            <div class="mt-8">
                <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                    <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-500">Join Kelas</p>
                            <h2 class="mt-2 text-xl font-semibold text-slate-900">Masukkan Kode Kelas</h2>
                            <p class="mt-1 text-sm text-slate-600">Gunakan kode kelas dari admin atau mentor untuk bergabung ke kelas aktif.</p>
                        </div>
    
                        <form method="POST" action="{{ route('peserta.kelas.join') }}" class="flex-row w-full justify-center gap-2 sm:max-w-md sm:flex-row">
                            @csrf
                            <input name="kode_kelas" value="{{ old('kode_kelas') }}" placeholder="Contoh: AB12CD34" class="w-full mb-4 rounded-xl border-slate-300 bg-white text-slate-900 uppercase placeholder:text-slate-400 focus:border-blue-500 focus:ring-blue-500" required>
                            <button type="submit" class="rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-slate-800">Join</button>
                        </form>
                    </div>
                    @error('kode_kelas')
                        <p class="mt-3 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                    <!-- <a href="" class="inline-flex items-center justify-center rounded-2xl bg-white px-4 py-3 text-sm font-semibold text-sky-700 transition hover:bg-slate-100">
                        <flux:icon.plus />               
                    </a> -->
                </div>
            </div>


            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @if($enrolledClasses->count() > 0)
                    @foreach($enrolledClasses as $enrollment)
                        <div class="flex flex-col h-full rounded-[28px] border border-slate-200 bg-white p-6 shadow-lg shadow-slate-300/20">
                            <div class="flex flex-col h-full items-start justify-between gap-4">
                                <div>
                                    <h4 class="text-xl font-semibold text-slate-900">{{ $enrollment->kelas->nama }}</h4>
                                    <p class="mt-2 text-sm text-slate-500">{{ $enrollment->kelas->deskripsi }}</p>
                                </div>
                                <span class="rounded-3xl bg-sky-100 px-4 py-2 text-sm font-semibold text-sky-700">{{ ucfirst($enrollment->status) }}</span>
                            </div>

                            <div class="mt-6 grid gap-4 text-sm text-slate-600">
                                <p><span class="font-semibold text-slate-900">Mentor:</span> {{ $enrollment->kelas->mentor->name }}</p>
                            </div>

                            <a href="{{ route('peserta.kelas.show', $enrollment->kelas) }}" class="mt-6 inline-flex items-center justify-center rounded-2xl bg-sky-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-sky-700">
                                Lihat Kelas
                            </a>
                        </div>
                    @endforeach
                @else
                    <div class="rounded-[28px] border border-slate-200 bg-white p-8 shadow-lg shadow-slate-300/20">
                        <p class="text-slate-600">Anda belum terdaftar di kelas manapun.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.app>