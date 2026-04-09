<x-layouts.app>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Sertifikat Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium mb-4">Daftar Sertifikat</h3>
                    @if($completedEnrollments->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($completedEnrollments as $enrollment)
                                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                    <h4 class="font-semibold">{{ $enrollment->kelas->nama }}</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Selesai pada: {{ $enrollment->updated_at->format('d M Y') }}</p>
                                    <a href="#" class="mt-2 inline-block bg-green-500 text-white px-4 py-2 rounded">Unduh Sertifikat</a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p>Anda belum menyelesaikan kelas manapun.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>