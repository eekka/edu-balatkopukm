<x-layouts.app>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Jadwal Kelas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium mb-4">Jadwal Kelas yang Diikuti</h3>
                    @if($enrolledClasses->count() > 0)
                        <div class="space-y-4">
                            @foreach($enrolledClasses as $enrollment)
                                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                    <h4 class="font-semibold">{{ $enrollment->kelas->nama }}</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Mentor: {{ $enrollment->kelas->mentor->name }}</p>
                                    <p class="text-sm">Status: {{ $enrollment->status }}</p>
                                    <!-- Tambahkan jadwal spesifik jika ada -->
                                    <p class="text-sm">Jadwal: Belum ditentukan</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p>Anda belum terdaftar di kelas manapun.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>