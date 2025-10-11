<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SIPKL - Sistem Informasi Praktik Kerja Lapangan</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @keyframes slide-in-left {
            from {
                transform: translateX(-100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slide-in-right {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .animate-slide-in-left {
            animation: slide-in-left 1s ease-out forwards;
        }

        .animate-slide-in-right {
            animation: slide-in-right 1s ease-out forwards;
        }

        .scroll-animate {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }

        .scroll-animate.is-visible {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>

<body class="antialiased bg-gray-50 text-gray-800 overflow-x-hidden">
    <div class="flex flex-col min-h-screen">
        <nav class="bg-white/80 backdrop-blur-md shadow-sm sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <img class="h-10 w-auto" src="{{ asset('images/logo.png') }}" alt="SIPKL Logo">
                        </div>
                        <div class="hidden md:block">
                            <div class="ml-10 flex items-baseline space-x-4">
                                <a href="#hero"
                                    class="text-gray-600 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium">Beranda</a>
                                <a href="#about"
                                    class="text-gray-600 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium">Tentang</a>
                                <a href="#flow"
                                    class="text-gray-600 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium">Alur
                                    Pendaftaran</a>
                                <a href="#active-students"
                                    class="text-gray-600 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium">Mahasiswa
                                    Aktif</a>
                            </div>
                        </div>
                    </div>
                    <div class="hidden md:block">
                        <div class="ml-4 flex items-center md:ml-6">
                            @if (Route::has('login'))
                            @auth
                            <a href="{{ url('/dashboard') }}"
                                class="text-gray-600 hover:bg-gray-200 px-3 py-2 rounded-md text-sm font-medium">Dashboard</a>
                            @else
                            <a href="{{ route('login') }}"
                                class="text-gray-600 hover:bg-gray-200 px-3 py-2 rounded-md text-sm font-medium">Masuk</a>
                            @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="ml-4 text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-md text-sm font-medium shadow-md transition-transform transform hover:scale-105">Daftar</a>
                            @endif
                            @endauth
                            @endif
                        </div>
                    </div>
                    <div class="-mr-2 flex md:hidden">
                        <button onclick="document.getElementById('mobile-menu').classList.toggle('hidden')"
                            class="bg-gray-100 inline-flex items-center justify-center p-2 rounded-md text-gray-700 hover:bg-gray-200 focus:outline-none">
                            <span class="sr-only">Open main menu</span>
                            <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                            <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <div class="md:hidden hidden" id="mobile-menu">
                <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                    <a href="#hero"
                        class="text-gray-600 hover:bg-gray-100 block px-3 py-2 rounded-md text-base font-medium">Beranda</a>
                    <a href="#about"
                        class="text-gray-600 hover:bg-gray-100 block px-3 py-2 rounded-md text-base font-medium">Tentang</a>
                    <a href="#flow"
                        class="text-gray-600 hover:bg-gray-100 block px-3 py-2 rounded-md text-base font-medium">Alur
                        Pendaftaran</a>
                    <a href="#active-students"
                        class="text-gray-600 hover:bg-gray-100 block px-3 py-2 rounded-md text-base font-medium">Mahasiswa
                        Aktif</a>
                </div>
            </div>
        </nav>

        <main class="flex-grow">
            <section id="hero" class="bg-white">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                        <div class="animate-slide-in-left">
                            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 leading-tight">
                                Sistem Informasi <span class="text-blue-600">Praktik Kerja Lapangan</span>
                            </h1>
                            <p class="mt-6 text-lg text-gray-600">Mempermudah mahasiswa dalam proses pengajuan,
                                pelaksanaan, dan pelaporan Praktik Kerja Lapangan (PKL) di instansi kami.</p>
                            <div class="mt-8">
                                <a href="{{ route('register') }}"
                                    class="inline-block text-white bg-blue-600 hover:bg-blue-700 px-8 py-3 rounded-lg text-lg font-semibold shadow-lg transition-transform transform hover:scale-105">
                                    Mulai Pendaftaran
                                </a>
                            </div>
                        </div>
                        <div class="animate-slide-in-right">
                            <img src="{{ asset('images/landingpage.jpg') }}" alt="Mahasiswa PKL Bekerja"
                                class="rounded-2xl shadow-2xl w-full h-auto object-cover">
                        </div>
                    </div>
                </div>
            </section>

            <section id="about" class="py-20 bg-gray-100">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="grid md:grid-cols-2 gap-12 items-center scroll-animate">
                        <div>
                            <img src="{{ asset('images/landingpage1.jpg') }}" alt="Diskusi Tim PKL"
                                class="rounded-2xl shadow-xl w-full h-auto object-cover">
                        </div>
                        <div class="text-left">
                            <h2 class="text-3xl font-bold text-gray-900">Tentang Website Ini</h2>
                            <p class="mt-4 text-gray-600 max-w-xl">Website ini dirancang untuk menjadi jembatan antara
                                mahasiswa yang ingin melaksanakan PKL dengan instansi kami. Semua proses, mulai dari
                                pendaftaran hingga pengumpulan laporan, dapat dilakukan secara online, transparan, dan
                                efisien.</p>
                        </div>
                    </div>
                </div>
            </section>

            <section id="flow" class="py-20 bg-white">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <h2 class="text-3xl font-bold text-center text-gray-900 mb-16">Alur Pendaftaran PKL yang Mudah</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                        <div
                            class="text-center p-8 bg-gray-50 rounded-2xl border border-gray-200 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 scroll-animate">
                            <div
                                class="flex items-center justify-center h-16 w-16 rounded-full bg-blue-600 text-white mx-auto mb-6 shadow-lg">
                                <span class="text-2xl font-bold">1</span>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900">Registrasi Akun</h3>
                            <p class="mt-2 text-gray-600">Mahasiswa mendaftar dan membuat akun di website.</p>
                        </div>

                        <div class="text-center p-8 bg-gray-50 rounded-2xl border border-gray-200 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 scroll-animate"
                            style="transition-delay: 0.1s;">
                            <div
                                class="flex items-center justify-center h-16 w-16 rounded-full bg-blue-600 text-white mx-auto mb-6 shadow-lg">
                                <span class="text-2xl font-bold">2</span>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900">Pengajuan PKL</h3>
                            <p class="mt-2 text-gray-600">Melengkapi formulir pengajuan dan mengunggah dokumen yang
                                diperlukan.</p>
                        </div>

                        <div class="text-center p-8 bg-gray-50 rounded-2xl border border-gray-200 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 scroll-animate"
                            style="transition-delay: 0.2s;">
                            <div
                                class="flex items-center justify-center h-16 w-16 rounded-full bg-blue-600 text-white mx-auto mb-6 shadow-lg">
                                <span class="text-2xl font-bold">3</span>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900">Verifikasi & Penempatan</h3>
                            <p class="mt-2 text-gray-600">Admin akan memverifikasi pengajuan dan menempatkan mahasiswa
                                di bidang yang sesuai.</p>
                        </div>
                    </div>
                </div>
            </section>

            <section id="active-students" class="py-20 bg-gray-100">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-center scroll-animate">
                        <div
                            class="bg-white p-10 rounded-3xl shadow-2xl border border-gray-200 text-center transform hover:scale-105 transition-transform duration-300 w-full max-w-md">
                            <h3 class="text-xl font-semibold text-gray-500">Saat ini ada:</h3>
                            <p class="text-7xl font-bold text-blue-600 my-4">{{ $mahasiswaAktifCount }}</p>
                            <p class="text-xl font-semibold text-gray-500">mahasiswa yang sedang melaksanakan PKL.</p>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <footer class="bg-white border-t border-gray-200">
            <div
                class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8 text-center md:flex md:justify-between md:items-center">
                <div class="mb-6 md:mb-0 md:text-left">
                    <h3 class="text-lg font-semibold text-gray-900">Hubungi Kami</h3>
                    <p class="mt-2 text-gray-600">Jl. Pembangunan No. 123, Kabupaten Garut</p>
                    <p class="text-gray-600">Email: info@sipkl.com</p>
                </div>
                <p class="text-gray-500 text-sm">&copy; {{ date('Y') }} SIPKL. All rights reserved.</p>
            </div>
        </footer>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1 
            });

            const targets = document.querySelectorAll('.scroll-animate');
            targets.forEach(target => {
                observer.observe(target);
            });
        });
    </script>
</body>

</html>