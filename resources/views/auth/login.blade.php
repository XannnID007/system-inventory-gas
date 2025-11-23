<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - {{ $pengaturanToko->nama_toko ?? 'GasKu' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .bg-mesh-dark {
            background-color: #022c22;
            background-image:
                radial-gradient(at 0% 0%, hsla(161, 94%, 30%, 0.4) 0, transparent 50%),
                radial-gradient(at 100% 100%, hsla(166, 100%, 46%, 0.2) 0, transparent 50%);
        }
    </style>
</head>

<body class="bg-mesh-dark min-h-screen flex items-center justify-center p-4 relative overflow-hidden">

    <div
        class="absolute top-0 left-1/4 w-96 h-96 bg-emerald-500 rounded-full mix-blend-overlay filter blur-[128px] opacity-20 animate-pulse">
    </div>
    <div
        class="absolute bottom-0 right-1/4 w-96 h-96 bg-teal-500 rounded-full mix-blend-overlay filter blur-[128px] opacity-20">
    </div>

    <div class="w-full max-w-md bg-white/10 backdrop-blur-xl border border-white/20 rounded-2xl shadow-2xl p-8 relative z-10"
        x-data="{ showPassword: false }">

        <div class="text-center mb-8">
            <div
                class="inline-flex p-3 rounded-full bg-emerald-500/20 border border-emerald-500/30 mb-4 text-emerald-300">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-white tracking-tight">{{ $pengaturanToko->nama_toko ?? 'GasKu' }}</h1>
            <p class="text-emerald-200/60 text-sm mt-2">Please sign in to continue</p>
        </div>

        <form action="{{ route('login') }}" method="POST" class="space-y-6">
            @csrf

            <div class="space-y-4">
                <div class="relative group">
                    <div
                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-emerald-200/50 group-focus-within:text-emerald-400 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                        </svg>
                    </div>
                    <input type="email" name="email" placeholder="Email Address" required
                        class="w-full pl-10 pr-4 py-3 bg-black/20 border border-white/10 rounded-xl text-white placeholder-white/30 focus:outline-none focus:bg-black/30 focus:border-emerald-500 transition-all">
                </div>

                <div class="relative group">
                    <div
                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-emerald-200/50 group-focus-within:text-emerald-400 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <input :type="showPassword ? 'text' : 'password'" name="password" placeholder="Password" required
                        class="w-full pl-10 pr-10 py-3 bg-black/20 border border-white/10 rounded-xl text-white placeholder-white/30 focus:outline-none focus:bg-black/30 focus:border-emerald-500 transition-all">
                    <button type="button" @click="showPassword = !showPassword"
                        class="absolute right-3 top-3 text-emerald-200/50 hover:text-emerald-400">
                        <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" style="display:none">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="flex items-center justify-between text-sm">
                <label class="flex items-center text-emerald-100/80 hover:text-white cursor-pointer">
                    <input type="checkbox"
                        class="rounded bg-white/10 border-transparent focus:ring-0 text-emerald-500 mr-2">
                    Ingat Saya
                </label>
            </div>

            <button type="submit"
                class="w-full py-3.5 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-400 hover:to-teal-400 text-white font-bold rounded-xl shadow-lg shadow-emerald-500/20 transition-all transform hover:scale-[1.02]">
                Masuk Akun
            </button>
        </form>

        <div class="text-center mt-8 text-emerald-200/30 text-xs">
            © {{ date('Y') }} {{ $pengaturanToko->nama_toko ?? 'GasKu' }}.
        </div>
    </div>
</body>

</html>
