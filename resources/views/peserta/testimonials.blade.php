<x-layouts.app>
<div class="min-h-screen bg-slate-50 py-10">
    <div class="mx-auto max-w-6xl space-y-8 px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-blue-600">Peserta</p>
                <h1 class="text-3xl font-bold text-slate-900">Testimoni Saya</h1>
                <p class="mt-2 text-slate-600">Kirim testimoni untuk tampil di halaman landing.</p>
            </div>
            <a href="{{ route('peserta.dashboard') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-100">Kembali ke Dashboard</a>
        </div>

        @if (session('status'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800">{{ session('status') }}</div>
        @endif

        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-slate-900">Tambah Testimoni</h2>
                <p class="text-sm text-slate-500">Nama dan instansi diambil dari profil akun Anda.</p>
            </div>

            <form method="POST" action="{{ route('peserta.testimonials.store') }}" class="grid gap-4 md:grid-cols-2">
                @csrf

                <label class="block">
                    <span class="text-sm font-medium text-slate-700">Rating</span>
                    <select name="rating" class="mt-1 w-full rounded-xl border-slate-300 bg-white text-slate-900 focus:border-blue-500 focus:ring-blue-500" required>
                        @for ($rating = 1; $rating <= 5; $rating++)
                            <option value="{{ $rating }}" @selected(old('rating', 5) == $rating)>{{ $rating }} Bintang</option>
                        @endfor
                    </select>
                </label>

                <label class="block md:col-span-2">
                    <span class="text-sm font-medium text-slate-700">Isi Testimoni</span>
                    <textarea name="isi" rows="5" class="mt-1 w-full rounded-xl border-slate-300 bg-white text-slate-900 placeholder:text-slate-400 focus:border-blue-500 focus:ring-blue-500" required>{{ old('isi') }}</textarea>
                </label>

                <div class="md:col-span-2 flex justify-end">
                    <button type="submit" class="rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white hover:bg-slate-800">Kirim Testimoni</button>
                </div>
            </form>
        </div>

        <div class="rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">
            <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
                <h2 class="text-lg font-semibold text-slate-900">Testimoni Anda</h2>
                <span class="text-sm text-slate-500">{{ $testimonials->count() }} testimoni</span>
            </div>
            <div class="divide-y divide-slate-200">
                @forelse ($testimonials as $testimonial)
                    <div class="px-6 py-5">
                        <div class="flex items-center gap-2 text-amber-400">
                            @for ($i = 0; $i < $testimonial->rating; $i++)
                                <i class="fas fa-star"></i>
                            @endfor
                        </div>
                        <p class="mt-3 text-sm leading-6 text-slate-600">{{ $testimonial->isi }}</p>
                        <p class="mt-3 text-xs text-slate-500">Dibuat {{ $testimonial->created_at?->diffForHumans() }}</p>
                    </div>
                @empty
                    <div class="px-6 py-12 text-center text-slate-500">Belum ada testimoni yang Anda kirim.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
</x-layouts.app>