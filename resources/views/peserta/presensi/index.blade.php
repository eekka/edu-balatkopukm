<x-layouts.app>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Presensi') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 h-full">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 rounded-2xl bg-green-100 p-4 text-green-800">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 rounded-2xl bg-red-100 p-4 text-red-800">
                    {{ session('error') }}
                </div>
            @endif

            <div class="flex justify-between items-center overflow-hidden rounded-[32px] bg-gradient-to-r from-sky-700 to-sky-600 p-8 shadow-xl shadow-sky-400/20">
                <div class="space-y-3 text-white">
                    <p class="text-xs font-semibold uppercase tracking-[0.32em] text-sky-200/80">Presensi</p>
                    <h3 class="text-3xl font-bold">Lakukan Presensi dengan Selfie</h3>
                    <p class="max-w-2xl text-sm text-sky-100/90">Ambil foto selfie Anda untuk mencatat kehadiran di kelas. Pastikan wajah Anda terlihat jelas.</p>
                </div>
            </div>

            <!-- Daftar Kelas -->
            <div class="mt-8">
                <div class="rounded-[28px] border border-slate-200 bg-white p-8 shadow-lg shadow-slate-300/20">
                    <div class="space-y-6">
                        <div>
                            <h4 class="text-xl font-semibold text-slate-900">Pilih Kelas untuk Presensi</h4>
                            <p class="mt-2 text-sm text-slate-500">Pilih kelas yang ingin Anda lakukan presensi hari ini.</p>
                        </div>

                        @if($enrolledClasses->count() > 0)
                            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                                @foreach($enrolledClasses as $enrollment)
                                    <div class="rounded-2xl border {{ $enrollment->sudah_absen ? 'border-green-200 bg-green-50' : 'border-slate-200 bg-white' }} p-6 shadow-sm">
                                        <div class="flex items-start justify-between">
                                            <div class="flex-1">
                                                <h5 class="font-semibold text-slate-900">{{ $enrollment->kelas->nama }}</h5>
                                                <p class="mt-1 text-sm text-slate-600">{{ $enrollment->kelas->deskripsi }}</p>
                                                <p class="mt-2 text-xs text-slate-500">Mentor: {{ $enrollment->kelas->mentor->name }}</p>
                                            </div>
                                            <div class="ml-4">
                                                @if($enrollment->sudah_absen)
                                                    <span class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                                        <svg class="mr-1 h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                        </svg>
                                                        Sudah Presensi
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-700">
                                                        <svg class="mr-1 h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                                        </svg>
                                                        Belum Presensi
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        @if(!$enrollment->sudah_absen)
                                            <button type="button"
                                                    data-class-id="{{ $enrollment->kelas->id }}"
                                                    data-class-name="{{ $enrollment->kelas->nama }}"
                                                    class="btn-select-class mt-4 w-full inline-flex items-center justify-center rounded-2xl bg-sky-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-sky-700">
                                                Lakukan Presensi
                                            </button>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12">
                                <p class="text-slate-500">Anda belum terdaftar di kelas manapun.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Form Presensi -->
            <div id="presensi-form" class="mt-8 hidden">
                <div class="rounded-[28px] border border-slate-200 bg-white p-8 shadow-lg shadow-slate-300/20">
                    <div class="space-y-6">
                        <div class="text-center">
                            <h4 class="text-xl font-semibold text-slate-900">Presensi untuk: <span id="selected-class-name" class="text-sky-600"></span></h4>
                            <p class="mt-2 text-sm text-slate-500">Klik tombol di bawah untuk mengakses kamera dan ambil foto selfie.</p>
                        </div>

                        <div class="flex justify-center">
                            <div class="relative">
                                <video id="camera" class="rounded-2xl border-2 border-slate-300" width="400" height="300" autoplay muted></video>
                                <canvas id="canvas" class="hidden rounded-2xl border-2 border-slate-300" width="400" height="300"></canvas>
                                <div id="no-camera" class="flex items-center justify-center rounded-2xl border-2 border-slate-300 bg-slate-100" style="width: 400px; height: 300px; display: none;">
                                    <p class="text-slate-500">Kamera tidak tersedia</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-center space-x-4">
                            <flux:button id="start-camera" variant="primary" icon="camera">
                                Buka Kamera
                            </flux:button>
                            <flux:button id="capture" variant="outline" icon="photo" class="hidden">
                                Ambil Foto
                            </flux:button>
                            <flux:button id="retake" variant="outline" icon="arrow-path" class="hidden">
                                Ambil Ulang
                            </flux:button>
                        </div>

                        <form id="attendance-form" action="{{ route('peserta.presensi.store') }}" method="POST" class="hidden">
                            @csrf
                            <input type="hidden" id="kelas-id" name="kelas_id">
                            <input type="hidden" id="photo-data" name="photo">
                            <div class="text-center">
                                <flux:button type="submit" variant="primary" icon="check">
                                    Kirim Presensi
                                </flux:button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let stream;
        let selectedClassId = null;
        const video = document.getElementById('camera');
        const canvas = document.getElementById('canvas');
        const noCamera = document.getElementById('no-camera');
        const startButton = document.getElementById('start-camera');
        const captureButton = document.getElementById('capture');
        const retakeButton = document.getElementById('retake');
        const form = document.getElementById('attendance-form');
        const photoInput = document.getElementById('photo-data');
        const kelasIdInput = document.getElementById('kelas-id');
        const selectedClassName = document.getElementById('selected-class-name');
        const presensiForm = document.getElementById('presensi-form');

        function selectClass(classId, className) {
            selectedClassId = classId;
            selectedClassName.textContent = className;
            kelasIdInput.value = classId;
            presensiForm.classList.remove('hidden');
            presensiForm.scrollIntoView({ behavior: 'smooth' });
        }

        // Add event listeners to all select class buttons
        document.querySelectorAll('.btn-select-class').forEach(button => {
            button.addEventListener('click', function() {
                const classId = this.dataset.classId;
                const className = this.dataset.className;
                selectClass(classId, className);
            });
        });

        startButton.addEventListener('click', async () => {
            try {
                stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: 'user' } });
                video.srcObject = stream;
                video.classList.remove('hidden');
                noCamera.style.display = 'none';
                startButton.classList.add('hidden');
                captureButton.classList.remove('hidden');
            } catch (error) {
                console.error('Error accessing camera:', error);
                noCamera.style.display = 'flex';
                video.classList.add('hidden');
            }
        });

        captureButton.addEventListener('click', () => {
            const context = canvas.getContext('2d');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            const dataURL = canvas.toDataURL('image/jpeg');
            photoInput.value = dataURL;

            video.classList.add('hidden');
            canvas.classList.remove('hidden');
            captureButton.classList.add('hidden');
            retakeButton.classList.remove('hidden');
            form.classList.remove('hidden');

            // Stop camera stream
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
            }
        });

        retakeButton.addEventListener('click', () => {
            canvas.classList.add('hidden');
            video.classList.remove('hidden');
            retakeButton.classList.add('hidden');
            form.classList.add('hidden');
            startButton.classList.remove('hidden');
        });

        form.addEventListener('submit', (e) => {
            // Form will submit normally
        });
    </script>
</x-layouts.app>