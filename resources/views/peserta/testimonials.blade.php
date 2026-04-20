<x-layouts.app>
<div class="min-h-screen bg-slate-50 py-10">
    <div class="mx-auto max-w-6xl space-y-8 px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-blue-600">Peserta</p>
                <h1 class="text-3xl font-bold text-slate-900">Testimoni Saya</h1>
                <p class="mt-2 text-slate-600">Kirim testimoni untuk tampil di halaman landing.</p>
            </div>
            <a href="{{ route('peserta.dashboard') }}" class="inline-flex items-center justify-center rounded-none border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-100">Kembali ke Dashboard</a>
        </div>

        @if (session('status'))
            <div class="rounded-none border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div class="rounded-none border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
                <p class="font-semibold">Periksa kembali form berikut:</p>
                <ul class="mt-2 list-disc space-y-1 pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="rounded-none border border-slate-200 bg-white p-6 shadow-sm">
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-slate-900">Tambah Testimoni</h2>
                <p class="text-sm text-slate-500">Nama dan instansi diambil dari profil akun Anda.</p>
            </div>

            <form method="POST" action="{{ route('peserta.testimonials.store') }}" class="grid gap-4 md:grid-cols-2">
                @csrf

                <div class="block">
                    <span class="text-sm font-medium text-slate-700">Rating</span>
                    <input type="hidden" name="rating" id="rating-value" value="{{ old('rating', 5) }}">
                    <div class="mt-2 flex items-center gap-1" data-rating-group>
                        @for ($rating = 1; $rating <= 5; $rating++)
                            <button
                                type="button"
                                data-rating-button
                                data-rating-value="{{ $rating }}"
                                aria-label="Pilih {{ $rating }} bintang"
                                class="text-3xl leading-none text-amber-400 opacity-30 transition hover:opacity-100 focus:outline-none"
                            >
                                ★
                            </button>
                        @endfor
                        <span class="ml-2 text-sm text-slate-500" id="rating-label">5 Bintang</span>
                    </div>
                </div>

                <label class="block md:col-span-2">
                    <span class="text-sm font-medium text-slate-700">Isi Testimoni</span>
                    <textarea name="isi" rows="5" class="mt-1 w-full rounded-none border border-slate-300 bg-white px-3 py-2 text-slate-900 placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none" required>{{ old('isi') }}</textarea>
                </label>

                <div class="md:col-span-2 flex justify-end">
                    <button type="submit" class="rounded-none bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800">Kirim Testimoni</button>
                </div>
            </form>
        </div>

        <div class="rounded-none border border-slate-200 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
                <h2 class="text-lg font-semibold text-slate-900">Testimoni Anda</h2>
                <span class="rounded-none border border-slate-200 bg-slate-100 px-3 py-1 text-sm text-slate-500">{{ $testimonials->count() }} testimoni</span>
            </div>
            <div class="divide-y divide-slate-200">
                @forelse ($testimonials as $testimonial)
                    <article class="px-6 py-5">
                        <div class="flex items-center gap-2 text-amber-400">
                            @for ($i = 0; $i < $testimonial->rating; $i++)
                                <i class="fas fa-star"></i>
                            @endfor
                        </div>
                        <p class="mt-3 text-sm leading-6 text-slate-600">{{ $testimonial->isi }}</p>
                        <p class="mt-3 inline-flex rounded-none border border-slate-200 bg-slate-50 px-2.5 py-1 text-xs text-slate-500">Dibuat {{ $testimonial->created_at?->diffForHumans() }}</p>
                    </article>
                @empty
                    <div class="px-6 py-12 text-center text-slate-500">Belum ada testimoni yang Anda kirim.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ratingInput = document.getElementById('rating-value');
        const ratingButtons = Array.from(document.querySelectorAll('[data-rating-button]'));
        const ratingLabel = document.getElementById('rating-label');

        if (!ratingInput || ratingButtons.length === 0) {
            return;
        }

        const renderRating = function (value) {
            const selectedValue = Number(value) || 1;
            ratingButtons.forEach(function (button) {
                const buttonValue = Number(button.dataset.ratingValue);
                button.classList.toggle('opacity-100', buttonValue <= selectedValue);
                button.classList.toggle('opacity-30', buttonValue > selectedValue);
            });

            if (ratingLabel) {
                ratingLabel.textContent = selectedValue + ' Bintang';
            }
        };

        ratingButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                const value = Number(button.dataset.ratingValue) || 1;
                ratingInput.value = String(value);
                renderRating(value);
            });
        });

        renderRating(ratingInput.value);
    });
</script>
</x-layouts.app>