<x-layouts.app>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Kelas: ') . $kelas->nama }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium mb-4">{{ $kelas->nama }}</h3>
                    <p class="mb-4">{{ $kelas->deskripsi }}</p>
                    <p class="mb-2">Mentor: {{ $kelas->mentor->name }}</p>
                    <p class="mb-4">Status Pendaftaran: {{ $enrollment->status }}</p>

                    <!-- Tambahkan konten kelas seperti materi, tugas, dll. -->
                    <p>Konten kelas akan ditampilkan di sini.</p>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>