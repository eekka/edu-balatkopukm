<x-layouts.app>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Progress Pembelajaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium mb-4">Progress Kelas</h3>
                    @if($enrollments->count() > 0)
                        <div class="space-y-4">
                            @foreach($enrollments as $enrollment)
                                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                    <h4 class="font-semibold">{{ $enrollment->kelas->nama }}</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Status: {{ $enrollment->status }}</p>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                                        <div class="bg-blue-600 h-2.5 rounded-full" style="width: 45%"></div> <!-- Placeholder progress -->
                                    </div>
                                    <p class="text-sm mt-1">45% Selesai</p> <!-- Placeholder -->
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