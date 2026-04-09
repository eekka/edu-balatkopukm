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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <i class="fas fa-graduation-cap text-2xl theme-text-primary"></i>
                <span class="text-2xl font-bold theme-text-primary">Akademi Balatkop</span>
            </div>
            <div class="hidden md:flex space-x-8">
                <a href="#programs" class="text-slate-700 hover:text-[var(--primary)] transition">Program</a>
                <a href="#stats" class="text-slate-700 hover:text-[var(--primary)] transition">Statistik</a>
                <a href="#testimonials" class="text-slate-700 hover:text-[var(--primary)] transition">Testimoni</a>
            </div>
            <div class="flex space-x-4">
                @auth
                    <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg transition">Dashboard</a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="px-4 py-2 text-red-600 hover:text-red-700">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 text-slate-700 hover:text-[var(--primary)] transition">Masuk</a>
                    <a href="{{ route('register') }}" class="px-4 py-2 theme-btn-accent rounded-lg hover:bg-[#fff5a4] transition">Daftar</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="text-white py-20 md:py-32" style="background-image: linear-gradient(135deg, var(--primary-dark), var(--primary), var(--primary-light));">
        <div class="container mx-auto px-4 grid md:grid-cols-2 gap-12 items-center">
            <div>
                <h1 class="text-4xl md:text-5xl font-bold mb-6">Transformasi Pendidikan Digital</h1>
                <p class="text-xl mb-8 text-white/80">Platform e-learning profesional untuk pengembangan keterampilan jangka panjang. Belajar kapan saja, di mana saja dengan metode pembelajaran yang terstruktur.</p>
                <div class="flex space-x-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-8 py-3 bg-white theme-text-primary font-semibold rounded-lg hover:bg-[rgba(var(--primary-light-rgb),0.12)] transition">Buka Dashboard</a>
                    @else
                        <a href="{{ route('register') }}" class="px-8 py-3 bg-white theme-text-primary font-semibold rounded-lg hover:bg-[rgba(var(--primary-light-rgb),0.12)] transition">Daftar Sekarang</a>
                        <a href="{{ route('login') }}" class="px-8 py-3 theme-btn-accent font-semibold rounded-lg hover:bg-[#ffd657] transition">Masuk</a>
                    @endauth
                </div>
            </div>
            <div class="hidden md:block">
                <div class="bg-white bg-opacity-10 rounded-lg p-8 backdrop-blur-lg">
                    <i class="fas fa-laptop text-6xl text-center block mb-4 theme-text-accent"></i>
                    <p class="text-center text-white/90">Pembelajaran interaktif dan engaging</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section id="stats" class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Statistik Platform</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="text-center card-hover p-6 bg-gradient-to-br from-primary-light to-primary rounded-lg">
                    <i class="fas fa-book text-3xl theme-text-primary mb-4"></i>
                    <h3 class="text-4xl font-bold theme-text-primary mb-2">{{ $stats['programs'] }}</h3>
                    <p class="text-slate-700">Program Tersedia</p>
                </div>
                <div class="text-center card-hover p-6 bg-gradient-to-br from-green-50 to-green-100 rounded-lg">
                    <i class="fas fa-chalkboard-user text-3xl text-green-600 mb-4"></i>
                    <h3 class="text-4xl font-bold text-green-600 mb-2">{{ $stats['classes'] }}</h3>
                    <p class="text-gray-700">Kelas Aktif</p>
                </div>
                <div class="text-center card-hover p-6 bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg">
                    <i class="fas fa-user-tie text-3xl text-purple-600 mb-4"></i>
                    <h3 class="text-4xl font-bold text-purple-600 mb-2">{{ $stats['mentors'] }}</h3>
                    <p class="text-gray-700">Mentor Profesional</p>
                </div>
                <div class="text-center card-hover p-6 bg-gradient-to-br from-orange-50 to-orange-100 rounded-lg">
                    <i class="fas fa-users text-3xl text-orange-600 mb-4"></i>
                    <h3 class="text-4xl font-bold text-orange-600 mb-2">{{ $stats['participants'] }}</h3>
                    <p class="text-gray-700">Peserta Terdaftar</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Programs Section -->
    <section id="programs" class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Program Unggulan</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="card-hover bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="bg-gradient-to-r from-purple-500 to-purple-600 h-32 flex items-center justify-center">
                        <i class="fas fa-briefcase text-5xl text-white"></i>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-3">Leadership & Management</h3>
                        <p class="text-gray-650 mb-4">Program pelatihan kepemimpinan dan manajemen untuk pengembangan karir profesional. Dirancang khusus untuk manajer muda dan pemimpin organisasi.</p>
                        <div class="space-y-2 text-sm text-gray-600">
                            <p><i class="fas fa-check text-green-500 mr-2"></i>Kualitas internasional</p>
                            <p><i class="fas fa-check text-green-500 mr-2"></i>Instruktur berpengalaman</p>
                            <p><i class="fas fa-check text-green-500 mr-2"></i>Sertifikat profesional</p>
                        </div>
                    </div>
                </div>

                <div class="card-hover bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-32 flex items-center justify-center">
                        <i class="fas fa-computer text-5xl text-white"></i>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-3">Digital Skills</h3>
                        <p class="text-gray-650 mb-4">Program pengembangan keterampilan digital dan teknologi informasi modern. Mencakup tools dan platform terkini untuk kesuksesan bisnis digital.</p>
                        <div class="space-y-2 text-sm text-gray-600">
                            <p><i class="fas fa-check text-green-500 mr-2"></i>Konten up-to-date</p>
                            <p><i class="fas fa-check text-green-500 mr-2"></i>Praktik langsung</p>
                            <p><i class="fas fa-check text-green-500 mr-2"></i>Job placement support</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Mengapa Memilih Kami?</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="text-5xl text-purple-600 mb-4"><i class="fas fa-video"></i></div>
                    <h3 class="text-xl font-bold mb-3">Video HD</h3>
                    <p class="text-gray-600">Konten video berkualitas tinggi dengan subtitle lengkap untuk pembelajaran yang lebih efektif.</p>
                </div>
                <div class="text-center">
                    <div class="text-5xl text-blue-600 mb-4"><i class="fas fa-mobile-alt"></i></div>
                    <h3 class="text-xl font-bold mb-3">Mobile Friendly</h3>
                    <p class="text-gray-600">Akses materi pembelajaran dari perangkat apapun dengan interface yang responsif.</p>
                </div>
                <div class="text-center">
                    <div class="text-5xl text-green-600 mb-4"><i class="fas fa-certificate"></i></div>
                    <h3 class="text-xl font-bold mb-3">Sertifikat</h3>
                    <p class="text-gray-600">Dapatkan sertifikat yang diakui industri setelah menyelesaikan program.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Testimoni Peserta</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="card-hover bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-purple-400 to-purple-600 rounded-full flex items-center justify-center text-white font-bold">AB</div>
                        <div class="ml-4">
                            <h4 class="font-bold">Ahmad Budi</h4>
                            <p class="text-sm text-gray-600">Manager PT XYZ</p>
                        </div>
                    </div>
                    <div class="flex text-yellow-400 mb-3">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="text-gray-700">Program ini benar-benar mengubah cara saya memimpin tim. Materi sangat praktis dan dapat langsung diterapkan di tempat kerja.</p>
                </div>

                <div class="card-hover bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center text-white font-bold">SR</div>
                        <div class="ml-4">
                            <h4 class="font-bold">Siti Rahma</h4>
                            <p class="text-sm text-gray-600">Entrepreneur</p>
                        </div>
                    </div>
                    <div class="flex text-yellow-400 mb-3">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="text-gray-700">Kelas Excel & Data Analysis sangat membantu dalam menganalisis data penjualan bisnis saya. Instruktur sangat responsif dan supportif.</p>
                </div>

                <div class="card-hover bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center text-white font-bold">DW</div>
                        <div class="ml-4">
                            <h4 class="font-bold">Dwi Wicaksono</h4>
                            <p class="text-sm text-gray-600">Staf Development</p>
                        </div>
                    </div>
                    <div class="flex text-yellow-400 mb-3">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="text-gray-700">Platformnya user-friendly dan sangat mudah digunakan. Saya bisa belajar sesuai kecepatan saya sendiri dengan fleksibilitas penuh.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="hero-gradient text-white py-16">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-6">Siap Mengembangkan Karir Anda?</h2>
            <p class="text-xl mb-8 text-purple-100">Bergabunglah dengan ribuan profesional yang telah meningkatkan keterampilan mereka bersama kami.</p>
            @auth
                <a href="{{ route('dashboard') }}" class="px-8 py-3 bg-white text-purple-600 font-semibold rounded-lg hover:bg-gray-100 transition inline-block">Lihat Program</a>
            @else
                <a href="{{ route('register') }}" class="px-8 py-3 bg-white text-purple-600 font-semibold rounded-lg hover:bg-gray-100 transition inline-block">Daftar Gratis</a>
            @endauth
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-400 py-12">
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
            <div class="border-t border-gray-700 pt-8 text-center text-gray-500">
                <p>&copy; 2026 Akademi Balatkop UKM. Semua hak dilindungi.</p>
            </div>
        </div>
    </footer>
</body>
</html>
