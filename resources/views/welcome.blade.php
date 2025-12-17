<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SmashZone Arena - Premium Badminton Court</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-gray-900 bg-gray-50">

    <nav x-data="{ open: false, profileOpen: false }" class="fixed w-full z-50 bg-emerald-900/95 backdrop-blur-md border-b border-emerald-800 shadow-lg transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                
                <div class="flex-shrink-0 flex items-center gap-3 cursor-pointer" onclick="window.location.href='{{ route('home') }}'">
                    <div class="bg-white/10 p-2 rounded-lg backdrop-blur-sm border border-white/20">
                        <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <span class="font-bold text-xl tracking-wide text-white">SmashZone</span>
                </div>

                <div class="hidden md:flex space-x-8 items-center">
                    <a href="{{ route('home') }}#home" class="text-gray-300 hover:text-white font-medium transition duration-300">Home</a>
                    <a href="{{ route('home') }}#courts" class="text-gray-300 hover:text-white font-medium transition duration-300">Lapangan</a>
                    <a href="{{ route('home') }}#features" class="text-gray-300 hover:text-white font-medium transition duration-300">Fasilitas</a>
                    
                    @auth
                        <div class="relative ml-4">
                            <button @click="profileOpen = !profileOpen" @click.away="profileOpen = false" class="flex items-center gap-2 text-white bg-emerald-800 hover:bg-emerald-700 px-4 py-2 rounded-full transition focus:outline-none border border-emerald-600">
                                <span class="font-semibold text-sm">Halo, {{ Auth::user()->name }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            
                            <div x-show="profileOpen" class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl py-2 z-50 border border-gray-100" style="display: none;">
                                <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-600 font-medium">
                                    📅 Riwayat Booking
                                </a>
                                <div class="border-t border-gray-100 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 font-medium">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center gap-4">
                            <a href="{{ route('login') }}" class="text-white font-semibold hover:text-emerald-300 transition">Log in</a>
                            <a href="{{ route('register') }}" class="bg-emerald-500 text-white px-5 py-2.5 rounded-full font-bold hover:bg-emerald-400 transition shadow-lg shadow-emerald-500/30 transform hover:-translate-y-0.5">
                                Daftar Member
                            </a>
                        </div>
                    @endauth
                </div>

                <div class="-mr-2 flex items-center md:hidden">
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-emerald-200 hover:text-white hover:bg-emerald-800 focus:outline-none transition">
                        <svg class="h-8 w-8" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div :class="{'block': open, 'hidden': ! open}" class="hidden md:hidden bg-emerald-950 border-t border-emerald-800">
            <div class="pt-2 pb-3 space-y-1 px-4">
                <a href="{{ route('home') }}#home" class="block px-3 py-3 rounded-md text-base font-medium text-white hover:bg-emerald-800">Home</a>
                <a href="{{ route('home') }}#courts" class="block px-3 py-3 rounded-md text-base font-medium text-white hover:bg-emerald-800">Lapangan</a>
                <a href="{{ route('home') }}#features" class="block px-3 py-3 rounded-md text-base font-medium text-white hover:bg-emerald-800">Fasilitas</a>
            </div>
            
            <div class="pt-4 pb-6 border-t border-emerald-800 px-4 space-y-3">
                @auth
                    <div class="text-emerald-300 text-sm font-bold mb-2 px-1">Member: {{ Auth::user()->name }}</div>
                    <a href="{{ route('dashboard') }}" class="block w-full text-center bg-emerald-700 text-white px-4 py-3 rounded-lg font-bold border border-emerald-600">
                        📅 Riwayat Booking
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-center bg-red-600/20 text-red-200 px-4 py-3 rounded-lg font-bold hover:bg-red-600/30 mt-2">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block w-full text-center bg-emerald-800 text-white px-4 py-3 rounded-lg font-semibold border border-emerald-700">Log in</a>
                    <a href="{{ route('register') }}" class="block w-full text-center bg-white text-emerald-900 px-4 py-3 rounded-lg font-bold">Daftar Member</a>
                @endauth
            </div>
        </div>
    </nav>

    <section id="home" class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden bg-emerald-900">
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1626224583764-84786071963f?q=80&w=2070&auto=format&fit=crop" class="w-full h-full object-cover opacity-40 mix-blend-overlay">
            <div class="absolute inset-0 bg-gradient-to-b from-emerald-950/80 via-emerald-900/60 to-gray-50"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <span class="text-emerald-300 font-bold tracking-widest uppercase text-xs md:text-sm bg-white/10 backdrop-blur border border-white/20 px-4 py-1.5 rounded-full mb-6 inline-block">
                📍 SmashZone Arena, Bondowoso
            </span>
            <h1 class="text-4xl md:text-6xl lg:text-7xl font-extrabold text-white tracking-tight mb-6 leading-tight drop-shadow-lg">
                Main Badminton <br class="hidden md:block">
                <span class="text-emerald-400">Level Profesional.</span>
            </h1>
            <p class="mt-4 max-w-2xl mx-auto text-lg md:text-xl text-gray-200 mb-10 leading-relaxed">
                Booking lapangan semudah satu kali klik. Lantai standar BWF, pencahayaan anti-glare, dan komunitas yang seru.
            </p>
            <div class="flex flex-col md:flex-row justify-center gap-4 px-4">
                <a href="#courts" class="bg-emerald-500 text-white px-8 py-4 rounded-full font-bold text-lg hover:bg-emerald-400 transition shadow-xl shadow-emerald-500/30 w-full md:w-auto">
                    Booking Lapangan 🏸
                </a>
                <a href="#features" class="bg-transparent text-white border-2 border-white/30 px-8 py-4 rounded-full font-bold text-lg hover:bg-white/10 transition w-full md:w-auto">
                    Lihat Fasilitas
                </a>
            </div>
        </div>
    </section>

    <section id="features" class="py-12 bg-white -mt-10 relative z-20 mx-4 md:mx-auto max-w-6xl rounded-2xl shadow-xl border border-gray-100">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center divide-y md:divide-y-0 md:divide-x divide-gray-100 p-4">
            <div class="p-4">
                <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">⚡</div>
                <h3 class="font-bold text-lg text-gray-900">Instant Booking</h3>
                <p class="text-gray-500 text-sm mt-2">Cek jadwal real-time & booking dalam hitungan detik via website.</p>
            </div>
            <div class="p-4">
                <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">🛡️</div>
                <h3 class="font-bold text-lg text-gray-900">Lantai Standar BWF</h3>
                <p class="text-gray-500 text-sm mt-2">Karpet vinyl tebal & lantai kayu parket yang aman untuk lutut.</p>
            </div>
            <div class="p-4">
                <div class="w-12 h-12 bg-orange-100 text-orange-600 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">🅿️</div>
                <h3 class="font-bold text-lg text-gray-900">Fasilitas Lengkap</h3>
                <p class="text-gray-500 text-sm mt-2">Parkir luas, Shower air panas, Kantin, dan Musholla nyaman.</p>
            </div>
        </div>
    </section>

    <section id="courts" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Pilih Lapangan Favoritmu</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Kami menyediakan 6 lapangan dengan dua tipe lantai berbeda.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($courts as $court)
                <div class="group bg-white rounded-2xl shadow-sm hover:shadow-2xl transition-all duration-300 border border-gray-100 overflow-hidden flex flex-col h-full">
                    
                    <div class="relative h-64 bg-gray-200 overflow-hidden">
                        @if($court->image)
                            <img src="{{ asset('storage/' . $court->image) }}" class="w-full h-full object-cover transition duration-700 group-hover:scale-110" alt="{{ $court->name }}">
                        @else
                            <img src="https://images.unsplash.com/photo-1613918108466-292b78a8ef95?q=80&w=2076&auto=format&fit=crop" class="w-full h-full object-cover opacity-80 group-hover:opacity-100 transition duration-500">
                        @endif

                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-80"></div>

                        <div class="absolute bottom-4 left-4 text-white">
                            <h3 class="text-xl font-bold">{{ $court->name }}</h3>
                            <p class="text-sm opacity-90">{{ $court->type == 'karpet' ? 'Karpet' : 'Lantai' }}</p>
                        </div>
                        
                        <div class="absolute top-4 right-4">
                            <span class="bg-white/90 backdrop-blur text-emerald-900 text-xs font-bold px-3 py-1.5 rounded-full shadow">
                                Rp {{ number_format($court->price/1000, 0) }}k /jam
                            </span>
                        </div>
                    </div>

                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div class="flex items-center gap-2 mb-6">
                            <span class="flex h-2 w-2 rounded-full bg-emerald-500"></span>
                            <span class="text-sm text-gray-500">Available Today</span>
                        </div>
                        
                        @auth
                            <a href="{{ route('booking.show', $court->id) }}" class="block w-full text-center bg-gray-900 text-white py-3 rounded-xl font-bold hover:bg-emerald-600 transition shadow-lg group-hover:shadow-emerald-600/30">
                                Booking Sekarang
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="block w-full text-center border-2 border-gray-200 text-gray-700 py-3 rounded-xl font-bold hover:border-emerald-500 hover:text-emerald-600 transition">
                                Login untuk Booking
                            </a>
                        @endauth
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <footer class="bg-gray-900 text-white py-12 border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center md:text-left">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div class="col-span-1 md:col-span-2">
                    <span class="text-2xl font-bold text-emerald-400 flex items-center justify-center md:justify-start gap-2 mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        SmashZone
                    </span>
                    <p class="text-gray-400 text-sm leading-relaxed max-w-xs mx-auto md:mx-0">
                        Platform booking lapangan badminton modern. Lupakan chat admin yang lama, booking langsung disini.
                    </p>
                </div>
                <div>
                    <h4 class="font-bold text-lg mb-4 text-white">Menu</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><a href="#home" class="hover:text-emerald-400 transition">Home</a></li>
                        <li><a href="#courts" class="hover:text-emerald-400 transition">Lapangan</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-emerald-400 transition">Login</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-lg mb-4 text-white">Hubungi Kami</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li>📍 Jakarta Selatan, INA</li>
                        <li>📞 +62 812-3456-7890</li>
                        <li>✉️ booking@smashzone.com</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 text-gray-500 text-sm">
                &copy; {{ date('Y') }} SmashZone Arena. All rights reserved.
            </div>
        </div>
    </footer>

</body>
</html>