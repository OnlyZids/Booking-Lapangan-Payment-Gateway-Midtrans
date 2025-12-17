<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SmashZone Arena - Member Area</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-gray-900 bg-gray-50 flex flex-col min-h-screen">

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
                    <a href="{{ route('home') }}#home" class="text-gray-300 hover:text-white font-medium transition">Home</a>
                    <a href="{{ route('home') }}#courts" class="text-gray-300 hover:text-white font-medium transition">Lapangan</a>
                    <a href="{{ route('home') }}#features" class="text-gray-300 hover:text-white font-medium transition">Fasilitas</a>
                    
                    <div class="relative ml-4">
                        <button @click="profileOpen = !profileOpen" @click.away="profileOpen = false" class="flex items-center gap-2 text-white bg-emerald-800 hover:bg-emerald-700 px-4 py-2 rounded-full transition focus:outline-none border border-emerald-600">
                            <span class="font-semibold text-sm">{{ Auth::user()->name }}</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        
                        <div x-show="profileOpen" class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl py-2 z-50 border border-gray-100" style="display: none;">
                            <div class="px-4 py-2 text-xs text-gray-400">Manage Account</div>
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
                <a href="{{ route('home') }}" class="block px-3 py-3 rounded-md text-base font-medium text-white hover:bg-emerald-800">Home</a>
                <a href="{{ route('home') }}#courts" class="block px-3 py-3 rounded-md text-base font-medium text-white hover:bg-emerald-800">Lapangan</a>
            </div>
            <div class="pt-4 pb-6 border-t border-emerald-800 px-4">
                <div class="flex items-center px-3 mb-3">
                    <div class="text-base font-medium text-white">{{ Auth::user()->name }}</div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-center bg-red-600/20 text-red-200 px-4 py-3 rounded-lg font-bold hover:bg-red-600/30">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <main class="flex-grow pt-24 pb-12">
        {{ $slot }}
    </main>

    <footer class="bg-gray-900 text-white py-8 border-t border-gray-800 mt-auto">
        <div class="max-w-7xl mx-auto px-4 text-center sm:text-left sm:flex sm:justify-between sm:items-center">
            <div class="mb-4 sm:mb-0">
                <span class="text-xl font-bold text-emerald-400 flex items-center justify-center sm:justify-start gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    SmashZone
                </span>
            </div>
            <div class="text-gray-500 text-sm">
                &copy; {{ date('Y') }} SmashZone Arena. All rights reserved.
            </div>
        </div>
    </footer>

</body>
</html>