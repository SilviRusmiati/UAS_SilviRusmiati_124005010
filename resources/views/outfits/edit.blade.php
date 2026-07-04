<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Match STYLE | Edit Baju</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(24px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fade-in-up { animation: fadeInUp 0.6s cubic-bezier(0.23, 1, 0.32, 1) forwards; opacity: 0; }
        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .nav-link { transition: all 0.3s ease; border-radius: 0.75rem; }
        .nav-link:hover { background: linear-gradient(90deg, rgba(0,121,121,0.12) 0%, rgba(202,97,128,0.08) 80%); color: #ca6180; }
        .nav-link.active { background: linear-gradient(90deg, rgba(0,121,121,0.25) 0%, rgba(202,97,128,0.1) 70%); color: #007979; font-weight: 600; box-shadow: 0 4px 12px rgba(0,121,121,0.12); }
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: #fff5f5; }
        ::-webkit-scrollbar-thumb { background: #ca6180; border-radius: 10px; }
        .category-card { transition: all 0.3s ease; }
        .category-card.selected { border-color: #ca6180; background: rgba(202,97,128,0.05); box-shadow: 0 4px 12px rgba(202,97,128,0.15); }
        .category-card:hover { border-color: #ca6180; background: rgba(202,97,128,0.03); }

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
            opacity: 0.3;
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
            <a href="{{ route('wardrobe') }}" class="nav-link active flex items-center gap-3 px-4 py-3">
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
        <header class="mb-8 animate-fade-in-up">
            @php $userName = optional(auth()->user())->name; @endphp
            <h1 class="text-3xl font-bold text-[#ca6180] tracking-tight">Edit Baju {{ $userName ?? '' }}</h1>
            <p class="text-[#007979] text-base mt-0.5">perbarui detail koleksimu ✨</p>
        </header>

        <section class="max-w-3xl mx-auto animate-fade-in-up delay-100">
            <form action="{{ route('outfits.update', $outfit->id) }}" method="POST" enctype="multipart/form-data" 
                  class="bg-white/80 backdrop-blur-xl rounded-3xl p-8 shadow-sm border border-pink-100 space-y-8">
                @csrf
                @method('PUT')

                <div class="space-y-2">
                    <label class="text-sm font-semibold text-[#ca6180] ml-2">👚 Nama Baju</label>
                    <input type="text" name="name" value="{{ old('name', $outfit->name) }}" 
                           class="w-full bg-white px-5 py-3 rounded-2xl border border-pink-100 focus:border-[#ca6180] focus:ring-4 focus:ring-pink-50 outline-none text-[#007979]" required>
                    @error('name') <p class="text-red-400 text-xs mt-1 ml-2">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-3">
                    <label class="text-sm font-semibold text-[#ca6180] ml-2">📦 Kategori</label>
                    <input type="hidden" name="category" id="category-input" value="{{ old('category', $outfit->category) }}">
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-3" id="category-group">
                        @foreach ([ 'atasan' => '👔', 'bawahan' => '👖', 'outer' => '🧥', 'dress' => '👗', 'aksesoris' => '💍' ] as $value => $icon)
                        <div class="category-card bg-white border-2 rounded-2xl p-3 text-center cursor-pointer {{ old('category', $outfit->category) === $value ? 'selected border-[#ca6180] bg-pink-50' : 'border-pink-100' }}" 
                             data-value="{{ $value }}">
                            <span class="text-2xl">{{ $icon }}</span>
                            <p class="text-xs font-semibold text-[#007979] mt-1">{{ ucfirst($value) }}</p>
                        </div>
                        @endforeach
                    </div>
                    @error('category') <p class="text-red-400 text-xs mt-1 ml-2">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-semibold text-[#ca6180] ml-2">📸 Foto Baju</label>
                    <div class="bg-pink-50/30 border-2 border-dashed border-pink-200 rounded-2xl p-6 text-center">
                        <input type="file" name="image" accept="image/*" class="w-full text-sm text-[#007979] file:mr-3 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-[#ca6180] file:text-white file:font-semibold hover:file:bg-[#b84d6a]">
                        <p class="text-xs text-gray-400 mt-2">Biarkan kosong jika tidak ingin mengganti foto</p>
                    </div>
                    @if ($outfit->image)
                        <div class="mt-3 flex items-center gap-2">
                            <span class="text-xs text-[#007979]">Foto saat ini:</span>
                            <img src="{{ asset('storage/'.$outfit->image) }}" class="h-20 w-20 rounded-xl object-cover border border-pink-100">
                        </div>
                    @endif
                    @error('image') <p class="text-red-400 text-xs mt-1 ml-2">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center justify-end gap-4 pt-6 border-t border-pink-50">
                    <a href="{{ route('wardrobe') }}" class="px-6 py-3 rounded-full font-medium text-gray-400 hover:text-gray-600 transition">Batal</a>
                    <button type="submit" class="bg-[#ca6180] hover:bg-[#b84d6a] text-white px-8 py-3 rounded-full font-bold shadow-md shadow-pink-200 transition-all transform hover:scale-105 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </section>
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
        const categoryCards = document.querySelectorAll('.category-card');
        const categoryInput = document.getElementById('category-input');
        categoryCards.forEach(card => {
            card.addEventListener('click', () => {
                categoryCards.forEach(c => c.classList.remove('selected', 'border-[#ca6180]', 'bg-pink-50'));
                card.classList.add('selected', 'border-[#ca6180]', 'bg-pink-50');
                categoryInput.value = card.dataset.value;
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

        cancelLogout.addEventListener('click', () => logoutModal.classList.remove('active'));

        logoutModal.addEventListener('click', function(e) {
            if (e.target === logoutModal) logoutModal.classList.remove('active');
        });
    </script>
</body>
</html>