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

        .bg-image-overlay {
            position: relative;
            overflow: hidden;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .bg-image-overlay::before {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            /* Gelapkan background sedikit saja agar teks terbaca */
            z-index: 1;
        }

        /* --- EFEK BENING TOTAL (TRANSPARENT) --- */
        .login-box {
            /* 1. Background benar-benar bening (transparent) */
            background: transparent;

            /* 2. Tanpa Blur */
            backdrop-filter: none;
            -webkit-backdrop-filter: none;

            /* 3. Border dipertegas (lebih tebal/putih) agar kotak tetap terlihat bentuknya */
            border: 2px solid rgba(255, 255, 255, 0.5);

            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);

            border-radius: 1.5rem;
            /* Sudut lebih bulat */
            animation: slideInUp 0.6s ease-out;
        }

        /* Helper agar teks lebih 'pop' di background transparan */
        .text-glow {
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.8);
        }

        .input-field {
            background: transparent;
            border: none;
            /* Garis input putih tegas */
            border-bottom: 2px solid rgba(255, 255, 255, 0.6);
            border-radius: 0;
            transition: all 0.3s ease;
            color: white;
            padding: 12px 0;
            font-weight: 500;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.8);
            /* Shadow teks input */
        }

        .input-field::placeholder {
            color: rgba(255, 255, 255, 0.8);
            /* Placeholder putih terang */
        }

        .input-field:focus {
            background: transparent;
            border-bottom-color: #8BC34A;
            /* Hijau saat fokus */
            outline: none;
        }

        .input-field:focus::placeholder {
            opacity: 0.6;
            transform: translateX(10px);
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .btn-login {
            /* Tombol dibuat solid atau gradient agar kontras dengan background bening */
            background: linear-gradient(135deg, #8BC34A 0%, #7CB342 100%);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(139, 195, 74, 0.5);
            background: linear-gradient(135deg, #7CB342 0%, #689F38 100%);
        }
    </style>
</head>

<body class="bg-image-overlay min-h-screen flex items-center justify-center p-4"
    style="background-image: url('{{ asset('images/bg-login.png') }}');">

    <div class="absolute inset-0" style="z-index: 1;"></div>

    <div class="w-full max-w-xs login-box p-6 relative z-10" x-data="{ showPassword: false }">

        <div class="text-center mb-5">
            <h1 class="text-2xl font-bold text-white tracking-wide mb-2 text-glow">LOGIN</h1>
            <div
                class="w-20 h-1 bg-gradient-to-r from-green-400 via-green-500 to-green-600 mx-auto rounded-full shadow-lg shadow-green-500/50">
            </div>
        </div>

        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-white text-sm font-bold mb-1 text-glow">Email</label>
                <input type="email" name="email" placeholder="Masukkan email" required autocomplete="off"
                    class="input-field w-full">
            </div>

            <div>
                <label class="block text-white text-sm font-bold mb-1 text-glow">Password</label>
                <div class="relative">
                    <input :type="showPassword ? 'text' : 'password'" name="password" placeholder="Masukkan password"
                        required class="input-field w-full pr-10">
                    <button type="button" @click="showPassword = !showPassword"
                        class="absolute right-0 top-1/2 -translate-y-1/2 text-white hover:text-green-400 transition drop-shadow-md">
                        <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" style="display:none">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="flex items-center text-sm pt-1">
                <label
                    class="flex items-center text-white font-medium hover:text-green-300 cursor-pointer transition text-glow">
                    <input type="checkbox" name="remember"
                        class="rounded border-white bg-transparent text-green-500 focus:ring-green-500 focus:ring-offset-0 mr-2 border-2">
                    <span>Ingat saya</span>
                </label>
            </div>

            <button type="submit"
                class="btn-login w-full py-3 text-white font-bold rounded-full shadow-lg mt-3 transition-transform hover:scale-105 text-glow">
                Log in
            </button>
        </form>

        <div class="text-center mt-4 text-white text-xs text-glow">
            © {{ date('Y') }} {{ $pengaturanToko->nama_toko ?? 'GasKu' }} All rights reserved.
        </div>
    </div>

</body>

</html>
