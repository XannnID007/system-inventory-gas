<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - GasKu</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

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

        .gradient-green {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }

        .glass {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        .animate-float-delay {
            animation: float 6s ease-in-out 2s infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(5deg);
            }
        }

        .leaf {
            position: absolute;
            opacity: 0.15;
        }

        .leaf-top-left {
            top: -5%;
            left: -5%;
            width: 400px;
            height: 400px;
            background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
            border-radius: 0 80% 50% 50%;
            transform: rotate(-15deg);
        }

        .leaf-top-right {
            top: -10%;
            right: -5%;
            width: 500px;
            height: 500px;
            background: linear-gradient(135deg, #34d399 0%, #6ee7b7 100%);
            border-radius: 50% 0 50% 80%;
            transform: rotate(25deg);
        }

        .leaf-bottom-left {
            bottom: -10%;
            left: -8%;
            width: 450px;
            height: 450px;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border-radius: 50% 50% 0 80%;
            transform: rotate(45deg);
        }

        .leaf-bottom-right {
            bottom: -5%;
            right: -8%;
            width: 420px;
            height: 420px;
            background: linear-gradient(135deg, #6ee7b7 0%, #10b981 100%);
            border-radius: 80% 50% 50% 0;
            transform: rotate(-35deg);
        }

        .input-focus:focus {
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        }

        .btn-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(16, 185, 129, 0.3);
        }
    </style>
</head>

<body
    class="bg-gradient-to-br from-slate-50 via-green-50 to-slate-100 min-h-screen flex items-center justify-center p-4 overflow-hidden relative">

    <!-- Decorative Leaves -->
    <div class="leaf leaf-top-left animate-float"></div>
    <div class="leaf leaf-top-right animate-float-delay"></div>
    <div class="leaf leaf-bottom-left animate-float"></div>
    <div class="leaf leaf-bottom-right animate-float-delay"></div>

    <!-- Login Container -->
    <div class="relative z-10 w-full max-w-md" x-data="{ showPassword: false }">

        <!-- Logo & Title -->
        <div class="text-center mb-8">
            <div
                class="inline-flex items-center justify-center w-16 h-16 gradient-green rounded-2xl shadow-lg shadow-green-500/50 mb-4 animate-float">
                <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
            </div>
            <h1 class="text-gray-800 font-bold text-3xl mb-2">Selamat Datang</h1>
            <p class="text-green-600 font-medium">di GasKu - Agen LPG 3kg</p>
        </div>

        <!-- Login Form -->
        <div class="glass rounded-3xl shadow-2xl p-8">

            <!-- Alert Error -->
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-lg">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <p class="text-red-800 font-semibold text-sm">Terjadi Kesalahan</p>
                            <ul class="text-red-700 text-sm mt-1 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Alert Success -->
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-lg">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-green-700 text-sm">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-gray-700 font-semibold text-sm mb-2">Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                            </svg>
                        </div>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                            placeholder="nama@email.com" required
                            class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none input-focus transition-all text-gray-700">
                    </div>
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-gray-700 font-semibold text-sm mb-2">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input :type="showPassword ? 'text' : 'password'" id="password" name="password"
                            placeholder="Masukkan password" required
                            class="w-full pl-12 pr-12 py-3 border-2 border-gray-200 rounded-xl focus:outline-none input-focus transition-all text-gray-700">
                        <button type="button" @click="showPassword = !showPassword"
                            class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-green-600 transition-colors">
                            <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" style="display: none;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember"
                            class="w-4 h-4 rounded border-gray-300 text-green-600 focus:ring-green-500">
                        <span class="text-gray-600 text-sm">Ingat Saya</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full gradient-green text-white font-semibold py-3.5 rounded-xl shadow-lg btn-hover transition-all duration-300">
                    Masuk
                </button>
            </form>
        </div>

        <!-- Footer -->
        <div class="text-center mt-8">
            <p class="text-gray-500 text-sm">
                © 2024 GasKu. All rights reserved.
            </p>
        </div>
    </div>

</body>

</html>
