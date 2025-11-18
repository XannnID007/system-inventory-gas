<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - {{ config('app.name', 'GasKu') }}</title>

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

<body class="bg-gradient-to-br from-slate-50 via-green-50 to-slate-100" x-data="{ sidebarOpen: false }">

    <div class="app-container">
        <!-- Mobile Sidebar Backdrop -->
        <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false"
            class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40 lg:hidden"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        </div>

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-50 w-72 glass border-r border-green-200 transition-transform duration-300 ease-in-out lg:translate-x-0 flex flex-col shadow-xl">

            <div class="flex-1 overflow-y-auto p-6">
                <!-- Logo -->
                <div class="mb-8">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-12 h-12 gradient-purple rounded-2xl flex items-center justify-center shadow-lg shadow-green-500/50 animate-float flex-shrink-0">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-gray-800 font-bold text-2xl tracking-tight">GasKu</h1>
                            <p class="text-green-600 text-xs font-medium">Agen LPG 3kg</p>
                        </div>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="space-y-2">
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center gap-3 px-4 py-3.5 rounded-xl transition-all {{ request()->routeIs('dashboard') ? 'sidebar-active shadow-lg shadow-green-500/30' : 'text-gray-600 hover:bg-green-50 hover:text-green-700' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span class="font-semibold">Dashboard</span>
                    </a>

                    <a href="{{ route('transaksi.index') }}"
                        class="flex items-center gap-3 px-4 py-3.5 rounded-xl transition-all {{ request()->routeIs('transaksi.*') ? 'sidebar-active shadow-lg shadow-green-500/30' : 'text-gray-600 hover:bg-green-50 hover:text-green-700' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <span class="font-semibold">Kelola Transaksi</span>
                    </a>

                    <a href="{{ route('stok.index') }}"
                        class="flex items-center gap-3 px-4 py-3.5 rounded-xl transition-all {{ request()->routeIs('stok.*') ? 'sidebar-active shadow-lg shadow-green-500/30' : 'text-gray-600 hover:bg-green-50 hover:text-green-700' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                        <span class="font-semibold">Kelola Stok</span>
                    </a>

                    <a href="{{ route('laporan.index') }}"
                        class="flex items-center gap-3 px-4 py-3.5 rounded-xl transition-all {{ request()->routeIs('laporan.*') ? 'sidebar-active shadow-lg shadow-green-500/30' : 'text-gray-600 hover:bg-green-50 hover:text-green-700' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        <span class="font-semibold">Laporan</span>
                    </a>

                    <a href="{{ route('riwayat.index') }}"
                        class="flex items-center gap-3 px-4 py-3.5 rounded-xl transition-all {{ request()->routeIs('riwayat.*') ? 'sidebar-active shadow-lg shadow-green-500/30' : 'text-gray-600 hover:bg-green-50 hover:text-green-700' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="font-semibold">Riwayat</span>
                    </a>

                    <a href="{{ route('pengaturan.index') }}"
                        class="flex items-center gap-3 px-4 py-3.5 rounded-xl transition-all {{ request()->routeIs('pengaturan.*') ? 'sidebar-active shadow-lg shadow-green-500/30' : 'text-gray-600 hover:bg-green-50 hover:text-green-700' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span class="font-semibold">Pengaturan</span>
                    </a>
                </nav>
            </div>

            <!-- User Profile - Sticky at bottom -->
            <div class="p-6 border-t border-green-200 bg-white/50">
                <div class="glass rounded-xl p-4">
                    <div class="flex items-center gap-3 mb-3">
                        <div
                            class="w-10 h-10 gradient-cyan rounded-full flex items-center justify-center text-white font-bold text-sm shadow-lg flex-shrink-0">
                            {{ strtoupper(substr(auth()->user()->nama, 0, 2)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-gray-800 font-semibold text-sm truncate">{{ auth()->user()->nama }}</p>
                            <p class="text-green-600 text-xs truncate">{{ auth()->user()->email }}</p>
                        </div>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="w-full px-4 py-2 bg-red-500/20 hover:bg-red-500/30 text-red-300 rounded-lg text-sm font-medium transition-all flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="main-content lg:ml-72">
            <!-- Top Bar -->
            <header class="glass border-b border-green-200 px-6 py-4 sticky top-0 z-30 flex-shrink-0">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <button @click="sidebarOpen = !sidebarOpen"
                            class="lg:hidden text-gray-700 p-2 hover:bg-green-50 rounded-lg transition-colors">
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
                    <div class="flex items-center gap-3">
                        <span
                            class="hidden sm:block text-green-600 text-sm font-medium">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
                    </div>
                </div>
            </header>

            <!-- Content Area with Alerts and Main Content -->
            <div class="content-area">
                <!-- Alert Messages -->
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

                <!-- Page Content -->
                <main class="p-6">
                    @yield('content')
                </main>
            </div>
        </div>
    </div>

    @stack('scripts')
</body>

</html>
