<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akademi Balatkop UKM - Platform E-Learning Terpadu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .hero-gradient {
            background:
                radial-gradient(circle at 14% 18%, rgba(125, 211, 252, 0.25), transparent 34%),
                radial-gradient(circle at 83% 14%, rgba(59, 130, 246, 0.28), transparent 32%),
                linear-gradient(140deg, #102a58 0%, #19427b 48%, #1f5ea4 100%);
        }

        .soft-blue {
            background: linear-gradient(180deg, #eff6ff 0%, #f8fbff 100%);
        }

        .card-blue {
            background: linear-gradient(180deg, #ffffff 0%, #f3f8ff 100%);
            border: 1px solid #dbeafe;
        }

        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 14px 34px rgba(30, 64, 175, 0.22);
        }

        .cta-gradient {
            background: linear-gradient(135deg, #123366 0%, #1d4e89 56%, #2668a6 100%);
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800">
    <!-- Navigation -->
    <nav class="sticky top-0 z-50 border-b border-blue-100 bg-white/95 shadow-sm backdrop-blur">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <i class="fas fa-graduation-cap text-2xl text-blue-700"></i>
                <span class="text-2xl font-bold text-blue-900">Akademi Balatkop</span>
            </div>
            <div class="hidden md:flex space-x-8">
                <a href="#programs" class="text-slate-700 hover:text-blue-700 transition">Program</a>
                <a href="#stats" class="text-slate-700 hover:text-blue-700 transition">Statistik</a>
                <a href="#testimonials" class="text-slate-700 hover:text-blue-700 transition">Testimoni</a>
            </div>
            <div class="flex space-x-4">
                @auth
                    <a href="{{ route('dashboard') }}" class="rounded-lg bg-blue-50 px-4 py-2 text-blue-700 hover:bg-blue-100 transition">Dashboard</a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="px-4 py-2 text-red-600 hover:text-red-700">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 text-slate-700 hover:text-blue-700 transition">Masuk</a>
                    <a href="{{ route('register') }}" class="rounded-lg bg-blue-700 px-4 py-2 text-white hover:bg-blue-800 transition">Daftar</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-gradient text-white py-14 md:py-0">
        <div class="container mx-auto grid items-center gap-8 px-4 md:min-h-[560px] md:grid-cols-2 md:gap-10 md:px-6">
            <div class="py-8 md:py-12">
                <h1 class="mb-6 text-4xl font-bold md:text-5xl">Transformasi Pendidikan Digital</h1>
                <p class="mb-8 text-xl text-blue-100/90">Platform e-learning profesional untuk pengembangan keterampilan jangka panjang. Belajar kapan saja, di mana saja dengan metode pembelajaran yang terstruktur.</p>
                <div class="flex space-x-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="rounded-lg bg-white px-8 py-3 font-semibold text-blue-700 hover:bg-blue-50 transition">Buka Dashboard</a>
                    @else
                        <a href="{{ route('register') }}" class="rounded-lg bg-white px-8 py-3 font-semibold text-blue-700 hover:bg-blue-50 transition">Daftar Sekarang</a>
                        <a href="{{ route('login') }}" class="rounded-lg border border-white/30 bg-white/10 px-8 py-3 font-semibold text-white hover:bg-white/15 transition">Masuk</a>
                    @endauth
                </div>
            </div>

            <div class="relative isolate md:h-full md:min-h-[560px] md:pl-6">
                <div class="absolute left-8 top-16 h-44 w-44 rounded-full bg-sky-300/18 blur-3xl"></div>
                <div class="absolute right-2 bottom-12 h-56 w-56 rounded-full bg-blue-300/14 blur-3xl"></div>
                <div class="absolute left-1/2 top-1/2 h-72 w-72 -translate-x-1/2 -translate-y-1/2 rounded-full bg-white/6 blur-2xl md:h-96 md:w-96"></div>

                <div class="relative flex h-[22rem] flex-col items-center justify-center gap-5 px-4 md:h-[36rem] md:gap-8 md:px-8">
                    <div class="grid w-full max-w-md grid-cols-3 items-center">
                        <div class="justify-self-start flex h-12 w-12 items-center justify-center rounded-full bg-white/10 text-cyan-100 backdrop-blur-md md:h-14 md:w-14 md:text-xl">
                            <i class="fas fa-book-open"></i>
                        </div>
                        <div></div>
                        <div class="justify-self-end flex h-12 w-12 items-center justify-center rounded-full bg-white/10 text-sky-100 backdrop-blur-md md:h-14 md:w-14 md:text-xl">
                            <i class="fas fa-comments"></i>
                        </div>
                    </div>

                    <div class="relative flex flex-col items-center justify-center text-center">
                        <div class="absolute -top-8 h-36 w-36 rounded-full bg-cyan-300/12 blur-3xl md:h-52 md:w-52"></div>
                        <div class="relative flex h-28 w-28 items-center justify-center rounded-full bg-white/10 text-4xl text-blue-50 shadow-[0_14px_35px_-24px_rgba(15,23,42,0.75)] backdrop-blur-md md:h-32 md:w-32 md:text-5xl">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                    </div>

                    <div class="grid w-full max-w-md grid-cols-3 items-center">
                        <div class="justify-self-start flex h-11 w-11 items-center justify-center rounded-full bg-white/10 text-emerald-100 backdrop-blur-md md:h-13 md:w-13 md:text-lg">
                            <i class="fas fa-laptop-code"></i>
                        </div>
                        <div class="justify-self-center text-center">
                            <i class="fas fa-graduation-cap text-2xl text-cyan-100 md:text-3xl"></i>
                        </div>
                        <div class="justify-self-end flex h-11 w-11 items-center justify-center rounded-full bg-white/10 text-indigo-100 backdrop-blur-md md:h-13 md:w-13 md:text-lg">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>

                    <div class="max-w-sm px-4 text-center">
                        <p class="text-sm font-semibold uppercase tracking-[0.22em] text-blue-100/80">Karakter Belajar</p>
                        <p class="mt-2 text-base leading-7 text-blue-50/90 md:text-lg">Komposisi yang lebih natural, tanpa kotak keras, supaya ikon utama dan elemen kecil punya ruang yang rapi.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section id="stats" class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="mb-12 text-center text-3xl font-bold text-blue-900">Statistik Platform</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="text-center card-hover card-blue rounded-2xl p-6">
                    <i class="fas fa-book text-3xl text-indigo-700 mb-4"></i>
                    <h3 class="text-4xl font-bold text-blue-900 mb-2">{{ $stats['programs'] }}</h3>
                    <p class="text-slate-700">Program Tersedia</p>
                </div>
                <div class="text-center card-hover card-blue rounded-2xl p-6">
                    <i class="fas fa-chalkboard-user text-3xl text-cyan-700 mb-4"></i>
                    <h3 class="text-4xl font-bold text-blue-900 mb-2">{{ $stats['classes'] }}</h3>
                    <p class="text-slate-700">Kelas Aktif</p>
                </div>
                <div class="text-center card-hover card-blue rounded-2xl p-6">
                    <i class="fas fa-user-tie text-3xl text-violet-700 mb-4"></i>
                    <h3 class="text-4xl font-bold text-blue-900 mb-2">{{ $stats['mentors'] }}</h3>
                    <p class="text-slate-700">Mentor Profesional</p>
                </div>
                <div class="text-center card-hover card-blue rounded-2xl p-6">
                    <i class="fas fa-users text-3xl text-emerald-700 mb-4"></i>
                    <h3 class="text-4xl font-bold text-blue-900 mb-2">{{ $stats['participants'] }}</h3>
                    <p class="text-slate-700">Peserta Terdaftar</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Programs Section -->
    <section id="programs" class="soft-blue py-16">
        <div class="container mx-auto px-4">
            <h2 class="mb-12 text-center text-3xl font-bold text-blue-900">Program Unggulan</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="card-hover overflow-hidden rounded-2xl border border-blue-100 bg-white shadow-md">
                    <div class="flex h-32 items-center justify-center bg-gradient-to-r from-blue-700 to-blue-500">
                        <i class="fas fa-briefcase text-5xl text-white"></i>
                    </div>
                    <div class="p-6">
                        <h3 class="mb-3 text-xl font-bold text-blue-900">Leadership & Management</h3>
                        <p class="mb-4 text-slate-600">Program pelatihan kepemimpinan dan manajemen untuk pengembangan karir profesional. Dirancang khusus untuk manajer muda dan pemimpin organisasi.</p>
                        <div class="space-y-2 text-sm text-slate-600">
                            <p><i class="fas fa-check mr-2 text-indigo-600"></i>Kualitas internasional</p>
                            <p><i class="fas fa-check mr-2 text-indigo-600"></i>Instruktur berpengalaman</p>
                            <p><i class="fas fa-check mr-2 text-indigo-600"></i>Sertifikat profesional</p>
                        </div>
                    </div>
                </div>

                <div class="card-hover overflow-hidden rounded-2xl border border-blue-100 bg-white shadow-md">
                    <div class="flex h-32 items-center justify-center bg-gradient-to-r from-blue-800 to-sky-600">
                        <i class="fas fa-computer text-5xl text-white"></i>
                    </div>
                    <div class="p-6">
                        <h3 class="mb-3 text-xl font-bold text-blue-900">Digital Skills</h3>
                        <p class="mb-4 text-slate-600">Program pengembangan keterampilan digital dan teknologi informasi modern. Mencakup tools dan platform terkini untuk kesuksesan bisnis digital.</p>
                        <div class="space-y-2 text-sm text-slate-600">
                            <p><i class="fas fa-check mr-2 text-cyan-600"></i>Konten up-to-date</p>
                            <p><i class="fas fa-check mr-2 text-cyan-600"></i>Praktik langsung</p>
                            <p><i class="fas fa-check mr-2 text-cyan-600"></i>Job placement support</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="mb-12 text-center text-3xl font-bold text-blue-900">Mengapa Memilih Kami?</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="rounded-2xl border border-blue-100 bg-blue-50/60 p-6 text-center">
                    <div class="mb-4 text-5xl text-indigo-700"><i class="fas fa-video"></i></div>
                    <h3 class="mb-3 text-xl font-bold text-blue-900">Video HD</h3>
                    <p class="text-slate-600">Konten video berkualitas tinggi dengan subtitle lengkap untuk pembelajaran yang lebih efektif.</p>
                </div>
                <div class="rounded-2xl border border-blue-100 bg-blue-50/60 p-6 text-center">
                    <div class="mb-4 text-5xl text-cyan-700"><i class="fas fa-mobile-alt"></i></div>
                    <h3 class="mb-3 text-xl font-bold text-blue-900">Mobile Friendly</h3>
                    <p class="text-slate-600">Akses materi pembelajaran dari perangkat apapun dengan interface yang responsif.</p>
                </div>
                <div class="rounded-2xl border border-blue-100 bg-blue-50/60 p-6 text-center">
                    <div class="mb-4 text-5xl text-emerald-700"><i class="fas fa-certificate"></i></div>
                    <h3 class="mb-3 text-xl font-bold text-blue-900">Sertifikat</h3>
                    <p class="text-slate-600">Dapatkan sertifikat yang diakui industri setelah menyelesaikan program.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="soft-blue py-16">
        <div class="container mx-auto px-4">
            <h2 class="mb-12 text-center text-3xl font-bold text-blue-900">Testimoni Peserta</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="card-hover rounded-2xl border border-blue-100 bg-white p-6 shadow-md">
                    <div class="flex items-center mb-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-gradient-to-br from-indigo-500 to-indigo-700 font-bold text-white">AB</div>
                        <div class="ml-4">
                            <h4 class="font-bold">Ahmad Budi</h4>
                            <p class="text-sm text-slate-600">Manager PT XYZ</p>
                        </div>
                    </div>
                    <div class="mb-3 flex text-amber-400">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="text-slate-700">Program ini benar-benar mengubah cara saya memimpin tim. Materi sangat praktis dan dapat langsung diterapkan di tempat kerja.</p>
                </div>

                <div class="card-hover rounded-2xl border border-blue-100 bg-white p-6 shadow-md">
                    <div class="flex items-center mb-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-gradient-to-br from-cyan-500 to-cyan-700 font-bold text-white">SR</div>
                        <div class="ml-4">
                            <h4 class="font-bold">Siti Rahma</h4>
                            <p class="text-sm text-slate-600">Entrepreneur</p>
                        </div>
                    </div>
                    <div class="mb-3 flex text-amber-400">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="text-slate-700">Kelas Excel & Data Analysis sangat membantu dalam menganalisis data penjualan bisnis saya. Instruktur sangat responsif dan supportif.</p>
                </div>

                <div class="card-hover rounded-2xl border border-blue-100 bg-white p-6 shadow-md">
                    <div class="flex items-center mb-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-gradient-to-br from-emerald-500 to-emerald-700 font-bold text-white">DW</div>
                        <div class="ml-4">
                            <h4 class="font-bold">Dwi Wicaksono</h4>
                            <p class="text-sm text-slate-600">Staf Development</p>
                        </div>
                    </div>
                    <div class="mb-3 flex text-amber-400">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="text-slate-700">Platformnya user-friendly dan sangat mudah digunakan. Saya bisa belajar sesuai kecepatan saya sendiri dengan fleksibilitas penuh.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-gradient py-16 text-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-6">Siap Mengembangkan Karir Anda?</h2>
            <p class="text-xl mb-8 text-blue-100">Bergabunglah dengan ribuan profesional yang telah meningkatkan keterampilan mereka bersama kami.</p>
            @auth
                <a href="{{ route('dashboard') }}" class="inline-block rounded-lg bg-white px-8 py-3 font-semibold text-blue-700 hover:bg-blue-50 transition">Lihat Program</a>
            @else
                <a href="{{ route('register') }}" class="inline-block rounded-lg bg-white px-8 py-3 font-semibold text-blue-700 hover:bg-blue-50 transition">Daftar Gratis</a>
            @endauth
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-[#0b1d47] py-12 text-blue-100/75">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div>
                    <h4 class="text-white font-bold mb-4"><i class="fas fa-graduation-cap mr-2"></i>Akademi Balatkop</h4>
                    <p>Platform e-learning profesional untuk pengembangan keterampilan dan karir.</p>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-4">Navigasi</h4>
                    <ul class="space-y-2">
                        <li><a href="#programs" class="hover:text-white transition">Program</a></li>
                        <li><a href="#stats" class="hover:text-white transition">Statistik</a></li>
                        <li><a href="#testimonials" class="hover:text-white transition">Testimoni</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-4">Kontak</h4>
                    <ul class="space-y-2">
                        <li>Email: info@akademi.test</li>
                        <li>Phone: +62 812-3456-789</li>
                        <li>Jakarta, Indonesia</li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-4">Media Sosial</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="text-xl hover:text-white transition"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="text-xl hover:text-white transition"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-xl hover:text-white transition"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-xl hover:text-white transition"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>
            </div>
            <div class="border-t border-blue-900/80 pt-8 text-center text-blue-200/60">
                <p>&copy; 2026 Akademi Balatkop UKM. Semua hak dilindungi.</p>
            </div>
        </div>
    </footer>
</body>
</html>
