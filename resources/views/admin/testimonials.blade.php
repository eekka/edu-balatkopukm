<x-layouts.app>
<div class="min-h-screen bg-slate-50 py-10">
    <div class="mx-auto max-w-6xl space-y-8 px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-blue-600">Admin</p>
                <h1 class="text-3xl font-bold text-slate-900">Testimoni Peserta</h1>
                <p class="mt-2 text-slate-600">Ubah atau hapus testimoni yang dikirim peserta.</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-100">Kembali ke Dashboard</a>
        </div>

        @if (session('status'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800">{{ session('status') }}</div>
        @endif

        @if ($editingTestimonial)
            <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <div class="mb-6 flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-slate-900">Edit Testimoni</h2>
                        <p class="text-sm text-slate-500">Admin dapat memperbaiki isi atau rating testimoni peserta.</p>
                    </div>
                    <a href="{{ route('admin.testimonials.index') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-700">Batal edit</a>
                </div>

                <form method="POST" action="{{ route('admin.testimonials.update', $editingTestimonial) }}" class="grid gap-4 md:grid-cols-2">
                    @csrf
                    @method('PUT')

                    <label class="block md:col-span-2">
                        <span class="text-sm font-medium text-slate-700">Peserta</span>
                        <input value="{{ $editingTestimonial?->user?->name ?? '-' }}" class="mt-1 w-full rounded-xl border-slate-300 bg-slate-100 text-slate-700" disabled>
                    </label>

                    <label class="block">
                        <span class="text-sm font-medium text-slate-700">Rating</span>
                        <select name="rating" class="mt-1 w-full rounded-xl border-slate-300 bg-white text-slate-900 focus:border-blue-500 focus:ring-blue-500" required>
                            @for ($rating = 1; $rating <= 5; $rating++)
                                <option value="{{ $rating }}" @selected(old('rating', $editingTestimonial?->rating ?? 5) == $rating)>{{ $rating }} Bintang</option>
                            @endfor
                        </select>
                    </label>

                    <label class="block md:col-span-2">
                        <span class="text-sm font-medium text-slate-700">Isi Testimoni</span>
                        <textarea name="isi" rows="5" class="mt-1 w-full rounded-xl border-slate-300 bg-white text-slate-900 placeholder:text-slate-400 focus:border-blue-500 focus:ring-blue-500" required>{{ old('isi', $editingTestimonial?->isi) }}</textarea>
                    </label>

                    <div class="md:col-span-2 flex justify-end">
                        <button type="submit" class="rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white hover:bg-slate-800">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        @else
            <div class="rounded-2xl border border-dashed border-slate-200 bg-white p-6 text-slate-600 shadow-sm ring-1 ring-slate-200">
                Pilih salah satu testimoni untuk diedit.
            </div>
        @endif

        <div class="rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">
            <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
                <h2 class="text-lg font-semibold text-slate-900">Daftar Testimoni</h2>
                <span class="text-sm text-slate-500">{{ $testimonials->count() }} testimoni</span>
            </div>
            <div class="divide-y divide-slate-200">
                @forelse ($testimonials as $testimonial)
                    <div class="px-6 py-5">
                        <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                            <div class="max-w-3xl">
                                <h3 class="text-lg font-semibold text-slate-900">{{ $testimonial->user?->name }}</h3>
                                <p class="mt-1 text-sm text-slate-500">{{ $testimonial->user?->instansi ?? ucfirst($testimonial->user?->role ?? 'Peserta') }}</p>
                                <div class="mt-3 flex flex-wrap gap-2 text-xs text-slate-500">
                                    <span class="rounded-full bg-slate-100 px-3 py-1">Rating: {{ $testimonial->rating }}/5</span>
                                    <span class="rounded-full bg-slate-100 px-3 py-1">Dibuat: {{ $testimonial->created_at?->diffForHumans() }}</span>
                                    <span class="rounded-full bg-slate-100 px-3 py-1">Diperbarui: {{ $testimonial->updated_at?->diffForHumans() }}</span>
                                </div>
                                <p class="mt-3 text-sm leading-6 text-slate-600">{{ $testimonial->isi }}</p>
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ route('admin.testimonials.index', ['edit' => $testimonial->id]) }}" class="rounded-lg border border-blue-200 px-3 py-1.5 text-sm font-semibold text-blue-700 hover:bg-blue-50">Edit</a>
                                <form method="POST" action="{{ route('admin.testimonials.destroy', $testimonial) }}" onsubmit="return confirm('Hapus testimoni ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-lg border border-rose-200 px-3 py-1.5 text-sm font-semibold text-rose-700 hover:bg-rose-50">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-12 text-center text-slate-500">Belum ada testimoni peserta.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
</x-layouts.app>