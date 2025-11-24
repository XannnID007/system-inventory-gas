<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - {{ $pengaturanToko->nama_toko ?? 'GasKu' }}</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <style>
        * {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .gradient-purple {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }

        .gradient-blue {
            background: linear-gradient(135deg, #34d399 0%, #10b981 100%);
        }

        .gradient-pink {
            background: linear-gradient(135deg, #6ee7b7 0%, #34d399 100%);
        }

        .gradient-cyan {
            background: linear-gradient(135deg, #34d399 0%, #10b981 100%);
        }

        .gradient-green {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }

        .gradient-orange {
            background: linear-gradient(135deg, #34d399 0%, #10b981 100%);
        }

        .glass {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(16, 185, 129, 0.2);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .glass-white {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .hover-lift {
            transition: all 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }

        .sidebar-active {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white !important;
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(16, 185, 129, 0.05);
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(16, 185, 129, 0.3);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgba(16, 185, 129, 0.5);
        }

        /* Smooth transitions */
        * {
            transition: background-color 0.2s ease;
        }

        /* Fix layout structure */
        .app-container {
            display: flex;
            min-height: 100vh;
        }

        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
            /* Prevent flex item overflow */
        }

        .content-area {
            flex: 1;
            overflow-y: auto;
        }
    </style>

    @stack('styles')
</head>

<body class="bg-gradient-to-br from-slate-50 via-green-50 to-slate-100" x-data="{
    sidebarOpen: window.innerWidth >= 1024,
    profileOpen: false
}">

    <div class="app-container">
        <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false"
            class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40 lg:hidden"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        </div>

        <aside :class="sidebarOpen ? 'translate-x-0 w-72' : '-translate-x-full lg:translate-x-0 lg:w-20'"
            class="fixed inset-y-0 left-0 z-50 glass border-r border-green-200 transition-all duration-300 ease-in-out flex flex-col shadow-xl overflow-hidden">

            <div class="flex-1 overflow-y-auto py-6 flex flex-col">
                <div class="mb-8 flex items-center transition-all duration-300 px-6"
                    :class="sidebarOpen ? 'justify-between' : 'justify-center'">

                    <div class="flex items-center gap-3 transition-all duration-300">
                        @if ($pengaturanToko && $pengaturanToko->logo_toko)
                            <div class="w-10 h-10 flex-shrink-0 transition-all duration-300">
                                <img src="{{ asset('storage/' . $pengaturanToko->logo_toko) }}"
                                    alt="{{ $pengaturanToko->nama_toko }}"
                                    class="w-full h-full object-cover rounded-xl shadow-lg shadow-green-500/50">
                            </div>
                        @else
                            <div
                                class="w-10 h-10 gradient-purple rounded-xl flex items-center justify-center shadow-lg shadow-green-500/50 flex-shrink-0 transition-all duration-300">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                            </div>
                        @endif

                        <div x-show="sidebarOpen" x-transition.opacity.duration.300ms
                            class="overflow-hidden whitespace-nowrap">
                            <h1 class="text-gray-800 font-bold text-xl tracking-tight">
                                {{ $pengaturanToko->nama_toko ?? 'GasKu' }}</h1>
                        </div>
                    </div>

                    <button @click="sidebarOpen = false" class="lg:hidden text-gray-500 hover:text-red-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <nav class="space-y-2 px-4 flex-1">
                    @php
                        $activeClass = 'sidebar-active shadow-lg shadow-green-500/30';
                        $inactiveClass = 'text-gray-600 hover:bg-green-50 hover:text-green-700';
                        $isOwner = auth()->user()->isOwner();
                        $prefix = $isOwner ? 'owner' : 'staff';
                    @endphp

                    {{-- Dashboard --}}
                    <a href="{{ route($prefix . '.dashboard') }}" title="Dashboard"
                        class="flex items-center gap-3 py-3.5 rounded-xl transition-all duration-300 whitespace-nowrap {{ request()->routeIs($prefix . '.dashboard') ? $activeClass : $inactiveClass }}"
                        :class="sidebarOpen ? 'px-4' : 'justify-center px-2'">
                        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span x-show="sidebarOpen" x-transition.opacity class="font-semibold">Dashboard</span>
                    </a>

                    @if ($isOwner)
                        {{-- OWNER MENU --}}

                        {{-- Kelola Staff --}}
                        <a href="{{ route('owner.staff.index') }}" title="Kelola Staff"
                            class="flex items-center gap-3 py-3.5 rounded-xl transition-all duration-300 whitespace-nowrap {{ request()->routeIs('owner.staff.*') ? $activeClass : $inactiveClass }}"
                            :class="sidebarOpen ? 'px-4' : 'justify-center px-2'">
                            <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <span x-show="sidebarOpen" x-transition.opacity class="font-semibold">Kelola Staff</span>
                        </a>

                        {{-- Laporan Keuangan --}}
                        <a href="{{ route('owner.laporan.index') }}" title="Laporan Keuangan"
                            class="flex items-center gap-3 py-3.5 rounded-xl transition-all duration-300 whitespace-nowrap {{ request()->routeIs('owner.laporan.*') ? $activeClass : $inactiveClass }}"
                            :class="sidebarOpen ? 'px-4' : 'justify-center px-2'">
                            <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            <span x-show="sidebarOpen" x-transition.opacity class="font-semibold">Laporan
                                Keuangan</span>
                        </a>

                        {{-- Riwayat Lengkap --}}
                        <a href="{{ route('owner.riwayat.index') }}" title="Riwayat Lengkap"
                            class="flex items-center gap-3 py-3.5 rounded-xl transition-all duration-300 whitespace-nowrap {{ request()->routeIs('owner.riwayat.*') ? $activeClass : $inactiveClass }}"
                            :class="sidebarOpen ? 'px-4' : 'justify-center px-2'">
                            <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span x-show="sidebarOpen" x-transition.opacity class="font-semibold">Riwayat
                                Lengkap</span>
                        </a>

                        {{-- Pengaturan Toko --}}
                        <a href="{{ route('owner.pengaturan.index') }}" title="Pengaturan Toko"
                            class="flex items-center gap-3 py-3.5 rounded-xl transition-all duration-300 whitespace-nowrap {{ request()->routeIs('owner.pengaturan.*') ? $activeClass : $inactiveClass }}"
                            :class="sidebarOpen ? 'px-4' : 'justify-center px-2'">
                            <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span x-show="sidebarOpen" x-transition.opacity class="font-semibold">Pengaturan
                                Toko</span>
                        </a>
                    @else
                        {{-- STAFF MENU --}}

                        {{-- Transaksi Penjualan --}}
                        <a href="{{ route('staff.transaksi.index') }}" title="Transaksi Penjualan"
                            class="flex items-center gap-3 py-3.5 rounded-xl transition-all duration-300 whitespace-nowrap {{ request()->routeIs('staff.transaksi.*') ? $activeClass : $inactiveClass }}"
                            :class="sidebarOpen ? 'px-4' : 'justify-center px-2'">
                            <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <span x-show="sidebarOpen" x-transition.opacity class="font-semibold">Transaksi
                                Penjualan</span>
                        </a>

                        {{-- Kelola Stok --}}
                        <a href="{{ route('staff.stok.index') }}" title="Kelola Stok"
                            class="flex items-center gap-3 py-3.5 rounded-xl transition-all duration-300 whitespace-nowrap {{ request()->routeIs('staff.stok.*') ? $activeClass : $inactiveClass }}"
                            :class="sidebarOpen ? 'px-4' : 'justify-center px-2'">
                            <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                            <span x-show="sidebarOpen" x-transition.opacity class="font-semibold">Kelola Stok</span>
                        </a>

                        {{-- Riwayat Saya --}}
                        <a href="{{ route('staff.riwayat.index') }}" title="Riwayat Saya"
                            class="flex items-center gap-3 py-3.5 rounded-xl transition-all duration-300 whitespace-nowrap {{ request()->routeIs('staff.riwayat.*') ? $activeClass : $inactiveClass }}"
                            :class="sidebarOpen ? 'px-4' : 'justify-center px-2'">
                            <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span x-show="sidebarOpen" x-transition.opacity class="font-semibold">Riwayat Saya</span>
                        </a>
                    @endif

                    {{-- Profil - Universal --}}
                    <a href="{{ route('profil.index') }}" title="Profil Saya"
                        class="flex items-center gap-3 py-3.5 rounded-xl transition-all duration-300 whitespace-nowrap {{ request()->routeIs('profil.*') ? $activeClass : $inactiveClass }}"
                        :class="sidebarOpen ? 'px-4' : 'justify-center px-2'">
                        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span x-show="sidebarOpen" x-transition.opacity class="font-semibold">Profil Saya</span>
                    </a>
                </nav>
            </div>

            <div x-show="sidebarOpen" x-transition.opacity
                class="p-4 text-center text-xs text-green-600/60 font-medium whitespace-nowrap">
                &copy; {{ date('Y') }} {{ $pengaturanToko->nama_toko ?? 'GasKu' }}
            </div>
        </aside>

        <div class="main-content transition-all duration-300 ease-in-out"
            :class="sidebarOpen ? 'lg:ml-72' : 'lg:ml-20'">

            <header class="glass border-b border-green-200 px-6 py-3 sticky top-0 z-30 flex-shrink-0">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <button @click="sidebarOpen = !sidebarOpen"
                            class="text-gray-700 p-2 hover:bg-green-50 rounded-lg transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                        <div>
                            <h2 class="text-gray-800 font-bold text-xl">@yield('page-title')</h2>
                            <p class="text-green-600 text-sm">@yield('page-subtitle')</p>
                        </div>
                    </div>

                    <div class="relative" x-cloak>
                        <button @click="profileOpen = !profileOpen" @click.outside="profileOpen = false"
                            class="flex items-center gap-3 hover:bg-green-50 p-2 rounded-xl transition-all border border-transparent hover:border-green-100">

                            <div class="text-right hidden sm:block">
                                <p class="text-gray-800 font-semibold text-sm leading-tight">
                                    {{ auth()->user()->nama }}</p>
                                <p class="text-green-600 text-xs">Administrator</p>
                            </div>

                            @if (auth()->user()->foto)
                                <img src="{{ asset('storage/' . auth()->user()->foto) }}" alt="Profile"
                                    class="w-10 h-10 rounded-full object-cover border-2 border-green-200 shadow-sm">
                            @else
                                <div
                                    class="w-10 h-10 gradient-cyan rounded-full flex items-center justify-center text-white font-bold text-sm shadow-lg">
                                    {{ strtoupper(substr(auth()->user()->nama, 0, 2)) }}
                                </div>
                            @endif

                            <svg class="w-4 h-4 text-gray-400 transition-transform duration-200"
                                :class="profileOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div x-show="profileOpen" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl border border-green-100 py-2 z-50">

                            <div class="px-4 py-3 border-b border-gray-100 sm:hidden">
                                <p class="text-sm font-semibold text-gray-800">{{ auth()->user()->nama }}</p>
                                <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                            </div>

                            <a href="{{ route('owner.pengaturan.index') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 transition-colors">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Edit Profil
                                </div>
                            </a>

                            <div class="border-t border-gray-100 my-1"></div>

                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        Keluar
                                    </div>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <div class="content-area">
                @if (session('success'))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="mx-6 mt-6">
                        <div class="glass-white rounded-xl p-4 border-l-4 border-green-500 shadow-lg">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-green-800 font-semibold">Berhasil!</p>
                                    <p class="text-green-700 text-sm">{{ session('success') }}</p>
                                </div>
                                <button @click="show = false"
                                    class="text-green-800 hover:text-green-900 flex-shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="mx-6 mt-6">
                        <div class="glass-white rounded-xl p-4 border-l-4 border-red-500 shadow-lg">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 bg-red-500 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-red-800 font-semibold">Error!</p>
                                    <p class="text-red-700 text-sm">{{ session('error') }}</p>
                                </div>
                                <button @click="show = false" class="text-red-800 hover:text-red-900 flex-shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @endif

                <main class="p-6">
                    @yield('content')
                </main>
            </div>
        </div>
    </div>

    @stack('scripts')
</body>

</html>
