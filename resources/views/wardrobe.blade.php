<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Match STYLE | Wardrobe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(24px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fade-in-up { animation: fadeInUp 0.6s cubic-bezier(0.23, 1, 0.32, 1) forwards; opacity: 0; }
        .delay-100 { animation-delay: 0.1s; } .delay-200 { animation-delay: 0.2s; } .delay-300 { animation-delay: 0.3s; }
        .nav-link { transition: all 0.3s ease; border-radius: 0.75rem; }
        .nav-link:hover { background: linear-gradient(90deg, rgba(0,121,121,0.12) 0%, rgba(202,97,128,0.08) 80%); color: #ca6180; }
        .nav-link.active { background: linear-gradient(90deg, rgba(0,121,121,0.25) 0%, rgba(202,97,128,0.1) 70%); color: #007979; font-weight: 600; box-shadow: 0 4px 12px rgba(0,121,121,0.12); }
        ::-webkit-scrollbar { width: 5px; } ::-webkit-scrollbar-track { background: #fff5f5; } ::-webkit-scrollbar-thumb { background: #ca6180; border-radius: 10px; }
        .filter-btn { transition: all 0.2s; }
        .filter-btn.active { background: #007979; color: white; }

        /* Background dengan gambar transparan */
        body {
            background-color: #fff5f5;
            position: relative;
        }
        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('{{ asset('bg.png') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            opacity: 0.3; /* 30% gambar, 70% warna latar */
            z-index: -1;
        }

        /* Modal Logout */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.3);
            backdrop-filter: blur(4px);
            z-index: 100;
            align-items: center;
            justify-content: center;
        }
        .modal-overlay.active { display: flex; }
        .modal-content {
            background: white;
            border-radius: 2rem;
            padding: 2rem;
            max-width: 360px;
            width: 90%;
            text-align: center;
            box-shadow: 0 20px 40px rgba(202,97,128,0.25);
        }
    </style>
</head>
<body class="font-['Poppins']">

    <aside class="w-72 bg-white/80 backdrop-blur-xl border-r border-pink-100/60 fixed h-full flex flex-col p-6 shadow-xl shadow-pink-900/5 z-20">
        <div class="flex items-center gap-3 mb-10">
            <img src="{{ asset('logo.png') }}" alt="Logo S" class="h-10 w-auto drop-shadow-md">
            <img src="{{ asset('teks.png') }}" alt="Match STYLE" class="h-12 w-auto object-contain">
        </div>
        <nav class="flex flex-col gap-2 flex-1">
            <a href="{{ route('dashboard') }}" class="nav-link flex items-center gap-3 px-4 py-3 text-gray-500">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/></svg> Home
            </a>
            <a href="#" class="nav-link active flex items-center gap-3 px-4 py-3">
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
                <h1 class="text-3xl font-bold text-[#ca6180] tracking-tight">Lemari {{ $userName ?? 'Silvi' }}</h1>
                <p class="text-[#007979] font-medium text-base mt-0.5" id="count-text">
                    {{ isset($outfits) ? count($outfits) : 0 }} baju tersimpan rapi ✨
                </p>
            </div>
            <a href="{{ route('outfits.create') }}" class="bg-[#ca6180] hover:bg-[#b84d6a] text-white px-6 py-3 rounded-full font-semibold shadow-lg shadow-pink-200 transition flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg> Tambah Baju
            </a>
        </header>

        @php
            $emojis = [
                'atasan' => '👔', 'bawahan' => '👖', 'outer' => '🧥',
                'dress' => '👗', 'aksesoris' => '💍', 'sepatu' => '👠',
            ];
        @endphp

        <section class="flex gap-2 mb-8 animate-fade-in-up delay-100" id="filter-buttons">
            <button class="filter-btn active px-5 py-2 rounded-full text-sm font-medium" data-category="semua">Semua</button>
            <button class="filter-btn px-5 py-2 bg-white text-[#007979] border border-pink-100 rounded-full text-sm font-medium hover:bg-pink-50" data-category="atasan">Atasan</button>
            <button class="filter-btn px-5 py-2 bg-white text-[#007979] border border-pink-100 rounded-full text-sm font-medium hover:bg-pink-50" data-category="bawahan">Bawahan</button>
            <button class="filter-btn px-5 py-2 bg-white text-[#007979] border border-pink-100 rounded-full text-sm font-medium hover:bg-pink-50" data-category="outer">Outer</button>
            <button class="filter-btn px-5 py-2 bg-white text-[#007979] border border-pink-100 rounded-full text-sm font-medium hover:bg-pink-50" data-category="dress">Dress</button>
            <button class="filter-btn px-5 py-2 bg-white text-[#007979] border border-pink-100 rounded-full text-sm font-medium hover:bg-pink-50" data-category="aksesoris">Aksesoris</button>
        </section>

        <div id="wardrobe-grid" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-5">
            @forelse ($outfits ?? [] as $item)
            <div class="outfit-card bg-white rounded-2xl p-4 shadow-sm border border-pink-100 hover:shadow-lg transition animate-fade-in-up delay-200 flex flex-col" data-category="{{ $item->category }}">
                <div class="h-44 bg-pink-50/50 rounded-xl mb-3 flex items-center justify-center overflow-hidden">
                    @if ($item->image)
                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="w-full h-full object-cover">
                    @else
                        <span class="text-5xl opacity-40">{{ $emojis[$item->category] ?? '👕' }}</span>
                    @endif
                </div>
                <h3 class="font-bold text-[#ca6180] text-sm leading-tight">{{ $item->name }}</h3>
                <p class="text-[10px] text-[#007979] mt-1 capitalize">{{ $item->category }}</p>
                <div class="mt-auto pt-3 flex justify-between items-center gap-2">
                    <a href="{{ route('outfits.edit', $item->id) }}" 
                       class="text-xs text-[#007979] hover:text-[#ca6180] transition font-medium flex items-center gap-1">
                        <span>✏️</span> Edit
                    </a>
                    <button class="text-xs text-red-400 hover:text-red-600 transition hapus-outfit flex items-center gap-1" 
                            data-id="{{ $item->id }}">
                        <span>🗑️</span> Hapus
                    </button>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center text-[#007979] mt-20 animate-fade-in-up">
                <span class="text-6xl">👗</span>
                <p class="mt-4 font-medium text-lg">Lemari masih kosong</p>
                <p class="text-sm opacity-70">Klik "Tambah Baju" untuk memulai koleksi ✨</p>
            </div>
            @endforelse
        </div>
    </main>

    <!-- MODAL LOGOUT CANTIK -->
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
        // Filter functionality
        const filterBtns = document.querySelectorAll('.filter-btn');
        const cards = document.querySelectorAll('.outfit-card');

        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                filterBtns.forEach(b => b.classList.remove('active', 'bg-[#007979]', 'text-white'));
                btn.classList.add('active', 'bg-[#007979]', 'text-white');
                const kat = btn.dataset.category;
                cards.forEach(card => {
                    card.style.display = (kat === 'semua' || card.dataset.category === kat) ? '' : 'none';
                });
            });
        });

        // Delete functionality
        document.querySelectorAll('.hapus-outfit').forEach(btn => {
            btn.addEventListener('click', async (e) => {
                e.preventDefault();
                const id = btn.dataset.id;
                if (!confirm('Hapus baju ini dari lemari?')) return;
                try {
                    const res = await fetch(`/outfits/${id}`, {
                        method: 'DELETE',
                        headers: { 
                            'X-CSRF-TOKEN': '{{ csrf_token() }}', 
                            'Accept': 'application/json' 
                        }
                    });
                    if (res.ok) {
                        const card = btn.closest('.outfit-card');
                        card.style.opacity = '0';
                        card.style.transform = 'scale(0.95)';
                        card.style.transition = '0.2s';
                        setTimeout(() => {
                            card.remove();
                            const remaining = document.querySelectorAll('.outfit-card').length;
                            const countText = document.getElementById('count-text');
                            if (countText) {
                                countText.textContent = `${remaining} baju tersimpan rapi ✨`;
                            }
                        }, 200);
                    } else {
                        alert('Gagal menghapus baju.');
                    }
                } catch (err) { 
                    console.error(err); 
                    alert('Terjadi kesalahan.');
                }
            });
        });

        // Modal Logout
        const logoutLink = document.getElementById('logout-link');
        const logoutModal = document.getElementById('logout-modal');
        const cancelLogout = document.getElementById('cancel-logout');

        logoutLink.addEventListener('click', function(e) {
            e.preventDefault();
            logoutModal.classList.add('active');
        });

        cancelLogout.addEventListener('click', function() {
            logoutModal.classList.remove('active');
        });

        logoutModal.addEventListener('click', function(e) {
            if (e.target === logoutModal) logoutModal.classList.remove('active');
        });
    </script>
</body>
</html>