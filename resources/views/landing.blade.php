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

        .hero-image-wrap {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            max-width: 18.5rem;
        }

        .hero-image-wrap::before {
            content: '';
            position: absolute;
            width: 88%;
            height: 78%;
            border-radius: 9999px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.5) 0%, rgba(255, 255, 255, 0.24) 44%, rgba(255, 255, 255, 0) 75%);
            filter: blur(18px);
            z-index: 0;
            pointer-events: none;
        }

        .hero-image {
            position: relative;
            z-index: 1;
            filter: drop-shadow(0 10px 20px rgba(255, 255, 255, 0.24));
        }

        @media (max-width: 640px) {
            .hero-image-wrap {
                max-width: 15.5rem;
            }

            .hero-image-wrap::before {
                width: 92%;
                height: 72%;
                filter: blur(14px);
            }
        }

        @media (min-width: 768px) {
            .hero-image-wrap {
                max-width: 32rem;
            }
        }
    </style>
</head>
<body class="overflow-x-hidden bg-slate-50 text-slate-800">
    <!-- Navigation -->
    <nav class="sticky top-0 z-50 border-b border-blue-100 bg-white/95 shadow-sm backdrop-blur">
        <div class="container mx-auto flex flex-wrap items-center justify-between gap-y-2 px-4 py-3 md:py-4">
            <div class="flex items-center gap-2">
                <i class="fas fa-graduation-cap text-xl text-blue-700 md:text-2xl"></i>
                <span class="text-xl font-bold leading-tight text-blue-900 sm:hidden">Akademi</span>
                <span class="hidden text-2xl font-bold leading-tight text-blue-900 sm:inline">Akademi Balatkop</span>
            </div>
            <div class="hidden md:flex space-x-8">
                <a href="#programs" class="text-slate-700 hover:text-blue-700 transition">Program</a>
                <a href="#stats" class="text-slate-700 hover:text-blue-700 transition">Statistik</a>
                <a href="#testimonials" class="text-slate-700 hover:text-blue-700 transition">Testimoni</a>
            </div>
            <div class="flex items-center gap-2 md:gap-4">
                @auth
                    <a href="{{ route('dashboard') }}" class="rounded-lg bg-blue-50 px-4 py-2 text-blue-700 hover:bg-blue-100 transition">Dashboard</a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="px-4 py-2 text-red-600 hover:text-red-700">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="px-2 py-2 text-sm text-slate-700 transition hover:text-blue-700 sm:px-3 md:px-4 md:text-base">Masuk</a>
                    <a href="{{ route('register') }}" class="rounded-lg bg-blue-700 px-3 py-2 text-sm font-semibold text-white transition hover:bg-blue-800 sm:px-4 md:text-base">Daftar</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-gradient overflow-hidden py-10 text-white md:py-0">
        <div class="container mx-auto grid items-center gap-6 px-4 md:min-h-[560px] md:grid-cols-2 md:gap-10 md:px-6">
            <div class="py-4 md:py-12">
                <h1 class="mb-5 max-w-[14ch] text-4xl font-bold leading-tight sm:max-w-none sm:text-5xl md:mb-6 md:text-5xl">Transformasi Pendidikan Digital</h1>
                <p class="mb-7 text-base leading-relaxed text-blue-100/90 sm:text-lg md:mb-8 md:text-xl">Platform e-learning profesional untuk pengembangan keterampilan jangka panjang. Belajar kapan saja, di mana saja dengan metode pembelajaran yang terstruktur.</p>
                <div class="flex flex-wrap gap-3 md:gap-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="rounded-lg bg-white px-8 py-3 font-semibold text-blue-700 hover:bg-blue-50 transition">Buka Dashboard</a>
                    @else
                        <a href="{{ route('register') }}" class="rounded-lg bg-white px-5 py-3 font-semibold text-blue-700 transition hover:bg-blue-50 md:px-8">Daftar Sekarang</a>
                        <a href="{{ route('login') }}" class="rounded-lg border border-white/30 bg-white/10 px-5 py-3 font-semibold text-white transition hover:bg-white/15 md:px-8">Masuk</a>
                    @endauth
                </div>
            </div>

            <div class="relative isolate md:h-full md:min-h-[560px] md:pl-6">
                <div class="absolute left-8 top-16 h-44 w-44 rounded-full bg-sky-300/18 blur-3xl"></div>
                <div class="absolute right-2 bottom-12 h-56 w-56 rounded-full bg-blue-300/14 blur-3xl"></div>
                <div class="absolute left-1/2 top-1/2 h-72 w-72 -translate-x-1/2 -translate-y-1/2 rounded-full bg-white/6 blur-2xl md:h-96 md:w-96"></div>

                <div class="relative flex min-h-[15rem] flex-col items-center justify-end px-2 pt-4 md:h-[36rem] md:justify-center md:gap-8 md:px-8">
                    <div class="hero-image-wrap">
                        <img src="/asset/aball.png" alt="Karakter Belajar" class="hero-image h-auto w-full max-w-[15.5rem] sm:max-w-[22rem] md:max-w-lg">
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
            <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                @forelse ($testimonials as $testimonial)
                    @php
                        $palette = ['from-indigo-500 to-indigo-700', 'from-cyan-500 to-cyan-700', 'from-emerald-500 to-emerald-700'];
                        $gradient = $palette[$loop->index % count($palette)];
                    @endphp
                    <div class="card-hover rounded-2xl border border-blue-100 bg-white p-6 shadow-md">
                        <div class="mb-4 flex items-center">
                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-gradient-to-br {{ $gradient }} font-bold text-white">{{ $testimonial->user?->initials() }}</div>
                            <div class="ml-4 min-w-0">
                                <h4 class="truncate font-bold text-slate-900">{{ $testimonial->user?->name }}</h4>
                                <p class="truncate text-sm text-slate-600">{{ $testimonial->user?->instansi ?? ucfirst($testimonial->user?->role ?? 'Peserta') }}</p>
                            </div>
                        </div>
                        <div class="mb-3 flex text-amber-400">
                            @for ($i = 0; $i < $testimonial->rating; $i++)
                                <i class="fas fa-star"></i>
                            @endfor
                        </div>
                        <p class="text-slate-700">{{ $testimonial->isi }}</p>
                    </div>
                @empty
                    <div class="rounded-2xl border border-dashed border-blue-200 bg-white p-8 text-center text-slate-600 md:col-span-3">
                        Belum ada testimoni yang ditambahkan peserta.
                    </div>
                @endforelse
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
