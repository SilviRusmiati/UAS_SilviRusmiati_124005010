<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Match STYLE | Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* Animasi fade-in dari bawah (sama seperti halaman awal) */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(28px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up {
            animation: fadeInUp 0.8s cubic-bezier(0.22, 0.61, 0.36, 1) forwards;
            opacity: 0;
        }
        .animate-delay-150 { animation-delay: 0.15s; }
        .animate-delay-300 { animation-delay: 0.3s; }

        /* Tombol gradien + glow */
        .btn-glow {
            background: linear-gradient(135deg, #ca6180 0%, #d97894 30%, #ca6180 60%, #b84d6a 100%);
            background-size: 200% 200%;
            background-position: 0% 0%;
            box-shadow: 0 0 18px 3px rgba(202, 97, 128, 0.45), 0 6px 18px rgba(180, 77, 106, 0.3);
            transition: background-position 0.5s ease, transform 0.25s ease, box-shadow 0.35s ease;
        }
        .btn-glow:hover {
            background-position: 100% 100%;
            box-shadow: 0 0 32px 8px rgba(202, 97, 128, 0.6), 0 8px 24px rgba(180, 77, 106, 0.4);
            transform: scale(1.02);
        }
        .btn-glow:active { transform: scale(0.98); }

        /* Kustomisasi scrollbar & highlight */
        * { -webkit-tap-highlight-color: transparent; }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #ca618066; border-radius: 10px; }
    </style>
</head>

<body class="font-['Poppins'] min-h-screen flex items-center justify-center relative z-0 p-4"
    style="background-image: linear-gradient(135deg, rgba(255,255,255,0.38) 0%, rgba(255,226,226,0.13) 45%, rgba(0,121,121,0.05) 100%), url('{{ asset('bg.png') }}'); background-size: cover; background-position: center; background-repeat: no-repeat; background-attachment: fixed;">

    <!-- Dekorasi blur background (Konsisten dengan halaman awal) -->
    <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden">
        <div class="absolute -top-24 -left-24 w-[350px] h-[350px] md:w-[500px] md:h-[500px] bg-pink-300/20 rounded-full blur-[80px] md:blur-[120px]"></div>
        <div class="absolute -bottom-32 -right-24 w-[380px] h-[380px] md:w-[550px] md:h-[550px] bg-teal-300/15 rounded-full blur-[90px] md:blur-[130px]"></div>
    </div>

    <!-- Tombol Kembali -->
    <a href="{{ url('/') }}" class="absolute top-6 left-6 z-20 flex items-center gap-2 text-[#007979] hover:text-[#ca6180] transition-colors font-medium text-sm bg-white/50 backdrop-blur-md px-4 py-2 rounded-full shadow-sm border border-white/40">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali
    </a>

    <!-- Card Login (Glassmorphism) -->
    <div class="w-full max-w-md bg-white/70 backdrop-blur-xl border border-white/60 rounded-[2rem] shadow-2xl shadow-pink-900/10 p-8 md:p-10 relative z-10 animate-fade-in-up">
        
        <!-- Logo di dalam form -->
        <div class="flex justify-center mb-8">
            <img src="{{ asset('logo.png') }}" alt="Match STYLE" class="h-12 md:h-14 w-auto object-contain drop-shadow-sm">
        </div>

        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-[#ca6180] tracking-wide">Welcome Back!</h2>
            <p class="text-xs text-[#007979] mt-1 font-medium">Silakan masuk untuk mengelola outfitmu.</p>
        </div>

        <!-- Form Login Laravel -->
        <form method="POST" action="{{ route('login') }}" class="space-y-5 animate-fade-in-up animate-delay-150">
            @csrf

            <!-- Input Email -->
            <div>
                <label for="email" class="block text-xs font-semibold text-[#007979] mb-1.5 ml-1 tracking-wide">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" 
                    class="w-full px-5 py-3.5 bg-white/60 border border-pink-200 rounded-2xl focus:outline-none focus:border-[#ca6180] focus:ring-4 focus:ring-[#ca6180]/10 transition-all text-sm text-gray-700 shadow-sm placeholder-gray-400" placeholder="Masukkan email kamu">
                @error('email')
                    <p class="text-[10px] text-red-500 mt-1 ml-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Input Password -->
            <div>
                <label for="password" class="block text-xs font-semibold text-[#007979] mb-1.5 ml-1 tracking-wide">Password</label>
                <input id="password" type="password" name="password" required autocomplete="current-password" 
                    class="w-full px-5 py-3.5 bg-white/60 border border-pink-200 rounded-2xl focus:outline-none focus:border-[#ca6180] focus:ring-4 focus:ring-[#ca6180]/10 transition-all text-sm text-gray-700 shadow-sm placeholder-gray-400" placeholder="Masukkan password">
                @error('password')
                    <p class="text-[10px] text-red-500 mt-1 ml-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between px-1">
                <label for="remember_me" class="inline-flex items-center cursor-pointer">
                    <input id="remember_me" type="checkbox" name="remember" class="rounded border-pink-300 text-[#ca6180] shadow-sm focus:ring-[#ca6180]/50 bg-white/50 w-4 h-4 transition-colors">
                    <span class="ml-2 text-xs text-[#007979] font-medium tracking-wide">Ingat saya</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-xs font-medium text-[#ca6180] hover:text-[#007979] transition-colors" href="{{ route('password.request') }}">
                        Lupa password?
                    </a>
                @endif
            </div>

            <!-- Tombol Login -->
            <div class="pt-4 animate-fade-in-up animate-delay-300">
                <button type="submit" class="btn-glow w-full py-3.5 text-white rounded-full text-sm font-semibold tracking-wide border border-white/20">
                    Masuk Sekarang
                </button>
            </div>
        </form>

        <!-- Link ke Register -->
        <p class="text-center text-xs text-[#007979] mt-8 font-medium animate-fade-in-up animate-delay-300">
            Belum punya akun? 
            <a href="{{ route('register') }}" class="text-[#ca6180] font-bold hover:underline underline-offset-4 decoration-2 transition-all">Daftar di sini</a>
        </p>

    </div>
</body>
</html>