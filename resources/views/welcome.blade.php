<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Match STYLE | Selamat Datang</title>
    <script src="https://cdn.tailwindcss.com">
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* Animasi soft pulse untuk bubble chat */
        @keyframes softPulse {
            0%,
            100% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(202, 97, 128, 0.25);
            }
            50% {
                transform: scale(1.04);
                box-shadow: 0 0 18px 3px rgba(202, 97, 128, 0.15);
            }
        }
        .animate-soft-pulse {
            animation: softPulse 3.2s ease-in-out infinite;
        }

        /* Animasi fade-in dari bawah */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(28px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-fade-in-up {
            animation: fadeInUp 0.8s cubic-bezier(0.22, 0.61, 0.36, 1) forwards;
            opacity: 0;
        }
        .animate-delay-150 {
            animation-delay: 0.15s;
        }
        .animate-delay-300 {
            animation-delay: 0.3s;
        }
        .animate-delay-450 {
            animation-delay: 0.45s;
        }

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
            transform: scale(1.05);
        }
        .btn-glow:active {
            transform: scale(0.95);
        }

        * {
            -webkit-tap-highlight-color: transparent;
        }
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: #ca618066;
            border-radius: 10px;
        }
    </style>
</head>

<body class="font-['Poppins'] min-h-screen flex flex-col relative z-0"
    style="background-image: linear-gradient(135deg, rgba(255,255,255,0.38) 0%, rgba(255,226,226,0.13) 45%, rgba(0,121,121,0.05) 100%), url('{{ asset('bg.png') }}'); background-size: cover; background-position: center; background-repeat: no-repeat; background-attachment: fixed;">

    <!-- Dekorasi blur background -->
    <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden">
        <div class="absolute -top-24 -left-24 w-[350px] h-[350px] md:w-[500px] md:h-[500px] bg-pink-300/15 rounded-full blur-[80px] md:blur-[120px]"></div>
        <div class="absolute -bottom-32 -right-24 w-[380px] h-[380px] md:w-[550px] md:h-[550px] bg-teal-300/12 rounded-full blur-[90px] md:blur-[130px]"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[280px] h-[280px] md:w-[400px] md:h-[400px] bg-pink-200/10 rounded-full blur-[60px] md:blur-[100px]"></div>
    </div>

    <!-- Header -->
    <header class="w-full flex items-center justify-between py-3 px-4 md:px-12 bg-white/80 backdrop-blur-lg border-b-[3px] border-[#ca6180]/50 shadow-md shadow-pink-900/5 relative z-20 transition-all duration-300">
        <!-- Logo kiri -->
        <div class="flex items-center space-x-3 md:space-x-5">
            <img src="{{ asset('logo.png') }}" alt="Logo S" class="h-10 md:h-14 w-auto object-contain drop-shadow-sm hover:scale-105 transition-transform duration-300">
            <img src="{{ asset('teks.png') }}" alt="Match STYLE" class="hidden sm:block h-12 md:h-16 w-auto object-contain drop-shadow-sm">
        </div>
        <!-- Bubble chat -->
        <div class="px-6 py-2.5 bg-[#ffe2e2] rounded-full text-gray-800 text-[11px] md:text-sm font-semibold tracking-wide shadow-md shadow-pink-200/40 border border-white/60 animate-soft-pulse cursor-default select-none transition-colors duration-300 hover:bg-[#ffd6d6]">
            hallooo, selamat datang&nbsp;🤍
        </div>
    </header>

    <!-- Konten utama -->
    <main class="flex-grow flex flex-col items-center justify-center text-center px-4 pb-10 relative z-10">

        <!-- Logo besar tengah (tanpa animasi) -->
        <div class="mb-8 flex justify-center w-full animate-fade-in-up">
            <img src="{{ asset('teks.png') }}" alt="Match STYLE"
            class="w-[280px] sm:w-[350px] md:w-[480px] lg:w-[550px] h-auto object-contain drop-shadow-2xl"
            style="filter: drop-shadow(0 8px 24px rgba(202, 97, 128, 0.2));">
        </div>

        <!-- Slogan -->
        <p class="text-[#007979] font-semibold text-sm md:text-base mb-12 tracking-wide md:tracking-wider animate-fade-in-up animate-delay-150 max-w-md md:max-w-xl leading-relaxed">
            Kelola koleksi outfitmu dengan lebih rapi dan cerdas!!
        </p>

        <!-- Tombol Login & Registrasi (dengan glow) -->
        <div class="flex flex-col space-y-4 md:flex-row md:space-y-0 md:space-x-8 w-full md:w-auto animate-fade-in-up animate-delay-300">
            <!-- Login -->
            <a href="{{ route('login') }}"
            class="btn-glow group px-14 py-3.5 text-[#ffffff] rounded-full text-sm font-semibold flex items-center justify-center gap-2.5 border border-white/20 tracking-wide">
            <svg class="w-4 h-4 transition-transform duration-300 group-hover:-translate-x-0.5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
                <polyline points="10 17 15 12 10 7" />
                <line x1="15" y1="12" x2="3" y2="12" />
            </svg>
            Login
        </a>
        <!-- Registrasi -->
        <a href="{{ route('register') }}"
        class="btn-glow group px-14 py-3.5 text-[#ffffff] rounded-full text-sm font-semibold flex items-center justify-center gap-2.5 border border-white/20 tracking-wide">
        <svg class="w-4 h-4 transition-transform duration-300 group-hover:scale-110" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
            <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
            <circle cx="8.5" cy="7" r="4" />
            <line x1="20" y1="8" x2="20" y2="14" />
            <line x1="23" y1="11" x2="17" y2="11" />
        </svg>
        Registrasi
    </a>
</div>

<!-- Garis dekoratif -->
<div class="mt-12 w-16 h-0.5 bg-gradient-to-r from-transparent via-[#ca6180]/30 to-transparent rounded-full animate-fade-in-up animate-delay-450"></div>
</main>
</body>
</html>