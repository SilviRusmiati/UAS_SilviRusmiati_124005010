<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Match STYLE | Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(24px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fade-in-up { animation: fadeInUp 0.65s cubic-bezier(0.23, 1, 0.32, 1) forwards; opacity: 0; }
        .delay-100 { animation-delay: 0.1s; } .delay-200 { animation-delay: 0.2s; } .delay-300 { animation-delay: 0.3s; } .delay-400 { animation-delay: 0.4s; } .delay-500 { animation-delay: 0.5s; }
        .nav-link { transition: all 0.3s ease; border-radius: 0.75rem; }
        .nav-link:hover { background: linear-gradient(90deg, rgba(0,121,121,0.12) 0%, rgba(202,97,128,0.08) 80%); color: #ca6180; }
        .nav-link.active { background: linear-gradient(90deg, rgba(0,121,121,0.25) 0%, rgba(202,97,128,0.1) 70%); color: #007979; font-weight: 600; box-shadow: 0 4px 12px rgba(0,121,121,0.12); }
        .mini-calendar { display: grid; grid-template-columns: repeat(7, 1fr); gap: 2px; }
        .mini-calendar div { aspect-ratio: 1 / 1; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; border-radius: 50%; color: #007979; font-weight: 500; }
        .mini-calendar .today { background: #ca6180; color: white; font-weight: 700; box-shadow: 0 0 6px rgba(202,97,128,0.5); }
        ::-webkit-scrollbar { width: 5px; } ::-webkit-scrollbar-track { background: #fff5f5; } ::-webkit-scrollbar-thumb { background: #ca6180; border-radius: 10px; }

        body { background-color: #fff5f5; position: relative; }
        body::before {
            content: "";
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background-image: url('{{ asset('bg.png') }}');
            background-size: cover; background-position: center; background-repeat: no-repeat;
            opacity: 0.3; z-index: -1;
        }
        .modal-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,0.3); backdrop-filter: blur(4px);
            z-index: 100; align-items: center; justify-content: center;
        }
        .modal-overlay.active { display: flex; }
        .modal-content {
            background: white; border-radius: 2rem; padding: 2rem;
            max-width: 360px; width: 90%; text-align: center;
            box-shadow: 0 20px 40px rgba(202,97,128,0.25);
        }
        /* Rekomendasi card */
        .rek-card:hover { transform: translateY(-4px); box-shadow: 0 16px 32px rgba(202,97,128,0.15); }
    </style>
</head>
<body class="font-['Poppins']">

    <aside class="w-72 bg-white/80 backdrop-blur-xl border-r border-pink-100/60 fixed h-full flex flex-col p-6 shadow-xl shadow-pink-900/5 z-20">
        <div class="flex items-center gap-3 mb-10">
            <img src="{{ asset('logo.png') }}" alt="Logo S" class="h-10 w-auto drop-shadow-md">
            <img src="{{ asset('teks.png') }}" alt="Match STYLE" class="h-12 w-auto object-contain">
        </div>
        <nav class="flex flex-col gap-2 flex-1">
            <a href="{{ route('dashboard') }}" class="nav-link active flex items-center gap-3 px-4 py-3">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/></svg> Home
            </a>
            <a href="{{ route('wardrobe') }}" class="nav-link flex items-center gap-3 px-4 py-3 text-gray-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg> Wardrobe
            </a>
            <a href="{{ route('mix-and-match') }}" class="nav-link flex items-center gap-3 px-4 py-3 text-gray-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg> Mix & Match
            </a>
        </nav>
        <a href="#" id="logout-link" class="nav-link flex items-center gap-3 px-4 py-3 text-red-400 hover:text-red-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
            Log Out
        </a>
    </aside>

    <main class="flex-1 ml-72 p-8 relative z-10">
        <header class="flex items-center justify-between mb-8 animate-fade-in-up">
            <div>
                @php $userName = optional(auth()->user())->name; @endphp
                <h1 class="text-3xl font-bold text-[#ca6180] tracking-tight">hallo {{ $userName ?? 'silvi' }}!!</h1>
                <p class="text-[#007979] font-medium text-base mt-0.5">mau pakai apa hari ini? ✨</p>
            </div>
            <div class="bg-white/70 backdrop-blur-md px-4 py-2 rounded-full shadow-sm border border-pink-100 flex items-center gap-2">
                <svg class="w-4 h-4 text-[#ca6180]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span id="live-clock" class="text-[#007979] font-semibold text-xs tracking-wide">--:--</span>
            </div>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <a href="{{ route('outfits.create') }}" class="bg-white/80 backdrop-blur-sm rounded-xl px-4 py-3 shadow-sm border border-pink-100 hover:shadow-md transition-all duration-300 flex items-center gap-3 animate-fade-in-up delay-100">
                <div class="w-9 h-9 bg-pink-100 rounded-lg flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 text-[#ca6180]" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 16V4m0 0L8 8m4-4l4 4M20 16v2a4 4 0 01-4 4H8a4 4 0 01-4-4v-2"/></svg>
                </div>
                <div>
                    <div class="text-[#ca6180] font-bold text-xs">Tambah Baju</div>
                    <div class="text-[9px] text-[#007979]">klik untuk mulai ✨</div>
                </div>
            </a>
            <div class="bg-white/80 backdrop-blur-sm rounded-xl px-4 py-3 shadow-sm border border-pink-100 flex items-center gap-3 animate-fade-in-up delay-200">
                <div class="w-9 h-9 bg-pink-100 rounded-lg flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 text-[#ca6180]" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 2a3 3 0 00-3 3h6a3 3 0 00-3-3zm0 4v2m0 0l-7 4v5a1 1 0 001 1h12a1 1 0 001-1v-5l-7-4z"/></svg>
                </div>
                <div>
                    <div class="text-[#007979] font-bold text-xs leading-none">{{ count($outfits) }} baju</div>
                    <div class="text-[#ca6180] text-[9px] mt-0.5">terdaftar di lemari</div>
                </div>
            </div>
            <div class="bg-white/80 backdrop-blur-sm rounded-xl p-3 shadow-sm border border-pink-100 flex items-center gap-3 animate-fade-in-up delay-300">
                <div class="w-9 h-9 bg-pink-100 rounded-lg flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 text-[#ca6180]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <div class="mini-calendar w-48">
                    <div>Min</div><div>Sen</div><div>Sel</div><div>Rab</div><div>Kam</div><div>Jum</div><div>Sab</div>
                    <div></div><div></div><div></div><div>1</div><div>2</div><div class="today">3</div><div>4</div>
                </div>
            </div>
        </div>

        <div class="mb-8 animate-fade-in-up delay-400">
            <div class="bg-white/80 backdrop-blur-sm rounded-full px-5 py-2.5 shadow-sm border border-pink-100 flex items-center gap-3">
                <svg class="w-4 h-4 text-[#ca6180]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input id="searchInput" type="text" placeholder="cari rekomendasi outfit disini yaaa cantikk" class="w-full bg-transparent outline-none text-[#ca6180] placeholder-[#ca6180]/60 text-sm">
            </div>
        </div>

        <section>
            <h2 class="text-xl font-bold text-[#007979] mb-4 flex items-center gap-2 animate-fade-in-up delay-500">Rekomendasi Mix & Match</h2>
            <div id="rekomendasiContainer" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @php
                    $grouped = ['atasan'=>[], 'bawahan'=>[], 'outer'=>[], 'dress'=>[], 'aksesoris'=>[]];
                    foreach($outfits as $item) $grouped[$item->category][] = $item;
                    $combos = [];
                    // Banyak kombinasi berdasarkan data
                    if(count($grouped['atasan']) && count($grouped['bawahan'])) {
                        $combos[] = ['nama'=>'Casual Look', 'items'=>[$grouped['atasan'][0], $grouped['bawahan'][0]], 'keywords'=>'casual style santai'];
                    }
                    if(count($grouped['atasan'])>1 && count($grouped['bawahan'])>1) {
                        $combos[] = ['nama'=>'Daily Casual', 'items'=>[$grouped['atasan'][1], $grouped['bawahan'][1]], 'keywords'=>'casual daily'];
                    }
                    if(count($grouped['atasan']) && count($grouped['bawahan']) && count($grouped['outer'])) {
                        $combos[] = ['nama'=>'Semi Formal', 'items'=>[$grouped['atasan'][0], $grouped['bawahan'][0], $grouped['outer'][0]], 'keywords'=>'semi formal rapi'];
                    }
                    if(count($grouped['atasan']) && count($grouped['bawahan']) && count($grouped['outer'])>1) {
                        $combos[] = ['nama'=>'Formal Elegan', 'items'=>[$grouped['atasan'][1]??$grouped['atasan'][0], $grouped['bawahan'][1]??$grouped['bawahan'][0], $grouped['outer'][1]], 'keywords'=>'formal elegan'];
                    }
                    if(count($grouped['dress'])) {
                        $combos[] = ['nama'=>'Party Look', 'items'=>[$grouped['dress'][0]], 'keywords'=>'party pesta'];
                    }
                    if(count($grouped['dress'])>1) {
                        $combos[] = ['nama'=>'Elegant Dress', 'items'=>[$grouped['dress'][1]], 'keywords'=>'elegant dress'];
                    }
                    if(count($grouped['atasan']) && count($grouped['bawahan']) && count($grouped['aksesoris'])) {
                        $combos[] = ['nama'=>'Accessorized Casual', 'items'=>[$grouped['atasan'][0], $grouped['bawahan'][0], $grouped['aksesoris'][0]], 'keywords'=>'accessorized casual'];
                    }
                    if(count($grouped['dress']) && count($grouped['outer'])) {
                        $combos[] = ['nama'=>'Layered Dress', 'items'=>[$grouped['dress'][0], $grouped['outer'][0]], 'keywords'=>'layered dress'];
                    }
                    if(count($grouped['atasan']) && count($grouped['outer'])) {
                        $combos[] = ['nama'=>'Light Outer', 'items'=>[$grouped['atasan'][0], $grouped['outer'][0]], 'keywords'=>'light outer'];
                    }
                    if(empty($combos)) {
                        $combos = [
                            ['nama'=>'Formal Outfit', 'items'=>[], 'keywords'=>'formal outfit'],
                            ['nama'=>'Semi Formal', 'items'=>[], 'keywords'=>'semi formal'],
                            ['nama'=>'Casual Style', 'items'=>[], 'keywords'=>'casual style'],
                            ['nama'=>'Party Look', 'items'=>[], 'keywords'=>'party look']
                        ];
                    }
                @endphp
                @foreach($combos as $c)
                <div class="rek-card bg-white rounded-2xl overflow-hidden shadow-sm border border-pink-100 transition-all duration-300 animate-fade-in-up delay-500" data-keywords="{{ $c['keywords'] }}">
                    <div class="h-40 bg-pink-50 flex items-center justify-center gap-2 p-4">
                        @if(!empty($c['items']))
                            @foreach($c['items'] as $item)
                                @if($item->image)
                                    <img src="{{ asset('storage/'.$item->image) }}" alt="{{ $item->name }}" class="w-16 h-16 object-cover rounded-lg shadow-sm border border-white">
                                @else
                                    @php $emojis=['atasan'=>'👔','bawahan'=>'👖','outer'=>'🧥','dress'=>'👗','aksesoris'=>'💍']; @endphp
                                    <span class="text-2xl">{{ $emojis[$item->category] ?? '👕' }}</span>
                                @endif
                            @endforeach
                        @else
                            <span class="text-4xl opacity-30">
                                @php $placeEmoji=['Formal Outfit'=>'👗','Semi Formal'=>'🧥','Casual Style'=>'👚','Party Look'=>'👜']; @endphp
                                {{ $placeEmoji[$c['nama']] ?? '👕' }}
                            </span>
                        @endif
                    </div>
                    <div class="p-3 text-center">
                        <h3 class="font-bold text-[#ca6180] text-sm">{{ $c['nama'] }}</h3>
                        <p class="text-xs text-gray-400 mt-1">
                            {{ !empty($c['items']) ? implode(' + ', array_map(fn($i) => $i->name, $c['items'])) : '' }}
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
        </section>
    </main>

    <!-- MODAL LOGOUT -->
    <div id="logout-modal" class="modal-overlay">
        <div class="modal-content">
            <div class="text-5xl mb-4">👋</div>
            <h3 class="text-xl font-bold text-[#007979] mb-2">Mau pergi dulu?</h3>
            <p class="text-sm text-gray-400 mb-6">Koleksi outfitmu akan tetap aman di lemari. Kamu bisa login lagi kapan saja ✨</p>
            <div class="flex gap-3 justify-center">
                <button id="cancel-logout" class="px-5 py-2 rounded-full border border-pink-200 text-gray-500 hover:bg-pink-50 transition">Nanti deh</button>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="px-5 py-2 rounded-full bg-red-400 hover:bg-red-500 text-white font-semibold transition">Ya, Keluar</a>
            </div>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
        </div>
    </div>

    <script>
        function updateClock() {
            const now = new Date();
            document.getElementById('live-clock').textContent =
                `${String(now.getHours()).padStart(2,'0')}:${String(now.getMinutes()).padStart(2,'0')}:${String(now.getSeconds()).padStart(2,'0')}`;
        }
        updateClock();
        setInterval(updateClock, 1000);

        const searchInput = document.getElementById('searchInput');
        const cards = document.querySelectorAll('.rek-card');
        searchInput.addEventListener('input', function() {
            const q = this.value.trim().toLowerCase();
            cards.forEach(card => {
                const kw = card.dataset.keywords.toLowerCase();
                card.style.display = (!q || kw.includes(q)) ? '' : 'none';
            });
        });

        const logoutLink = document.getElementById('logout-link');
        const logoutModal = document.getElementById('logout-modal');
        const cancelLogout = document.getElementById('cancel-logout');
        logoutLink.addEventListener('click', e => { e.preventDefault(); logoutModal.classList.add('active'); });
        cancelLogout.addEventListener('click', () => logoutModal.classList.remove('active'));
        logoutModal.addEventListener('click', e => { if (e.target === logoutModal) logoutModal.classList.remove('active'); });
    </script>
</body>
</html>