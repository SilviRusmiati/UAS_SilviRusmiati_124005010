<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Match STYLE | Tambah Baju</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(24px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fade-in-up { animation: fadeInUp 0.6s cubic-bezier(0.23, 1, 0.32, 1) forwards; opacity: 0; }
        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }
        .nav-link { transition: all 0.3s ease; border-radius: 0.75rem; }
        .nav-link:hover { background: linear-gradient(90deg, rgba(0,121,121,0.12) 0%, rgba(202,97,128,0.08) 80%); color: #ca6180; }
        .nav-link.active { background: linear-gradient(90deg, rgba(0,121,121,0.25) 0%, rgba(202,97,128,0.1) 70%); color: #007979; font-weight: 600; box-shadow: 0 4px 12px rgba(0,121,121,0.12); }
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: #fff5f5; }
        ::-webkit-scrollbar-thumb { background: #ca6180; border-radius: 10px; }
        .category-card { transition: all 0.3s ease; }
        .category-card.selected { border-color: #ca6180; background: rgba(202,97,128,0.05); box-shadow: 0 4px 12px rgba(202,97,128,0.15); }
        .category-card:hover { border-color: #ca6180; background: rgba(202,97,128,0.03); }
        .drop-area { transition: all 0.25s; }
        .drop-area.drag-over { border-color: #ca6180; background: rgba(202,97,128,0.05); }
        .drop-area.has-image { border-style: solid; }

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
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Home
            </a>
            <a href="{{ route('wardrobe') }}" class="nav-link active flex items-center gap-3 px-4 py-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                Wardrobe
            </a>
            <a href="{{ route('mix-and-match') }}" class="nav-link flex items-center gap-3 px-4 py-3 text-gray-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                Mix & Match
            </a>
        </nav>
        <a href="#" id="logout-link" class="nav-link flex items-center gap-3 px-4 py-3 text-red-400 hover:text-red-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
            Log Out
        </a>
    </aside>

    <main class="flex-1 ml-72 p-8 relative z-10">
        <header class="flex items-center justify-between mb-10 animate-fade-in-up">
            <div>
                @php $userName = optional(auth()->user())->name; @endphp
                <h1 class="text-3xl font-bold text-[#ca6180] tracking-tight">hallo {{ $userName ?? 'silvi' }}!!</h1>
                <p class="text-[#007979] font-medium text-base mt-0.5">tambah koleksi barumu yuk! ✨</p>
            </div>
            <div class="bg-white/70 backdrop-blur-md px-4 py-2 rounded-full shadow-sm border border-pink-100 flex items-center gap-2">
                <svg class="w-4 h-4 text-[#ca6180]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span id="live-clock" class="text-[#007979] font-semibold text-xs tracking-wide">--:--</span>
            </div>
        </header>

        <section class="max-w-3xl mx-auto">
            <form action="{{ route('outfits.store') }}" method="POST" enctype="multipart/form-data" class="bg-white/80 backdrop-blur-xl rounded-3xl p-8 shadow-sm border border-pink-100 space-y-8 animate-fade-in-up delay-100">
                @csrf
                <div class="flex items-center gap-3 pb-4 border-b border-pink-50">
                    <div class="w-10 h-10 bg-pink-100 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-[#ca6180]" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    </div>
                    <h2 class="text-2xl font-bold text-[#007979]">Detail Baju Baru</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-[#ca6180] ml-2 flex items-center gap-1"><span>👚</span> Nama Baju</label>
                        <input type="text" name="name" placeholder="Kemeja Rajut Ivory" class="w-full bg-white px-5 py-3 rounded-2xl border border-pink-100 focus:border-[#ca6180] focus:ring-4 focus:ring-pink-50 outline-none transition-all text-[#007979] placeholder-[#007979]/40" required>
                        @error('name') <p class="text-red-400 text-xs mt-1 ml-2">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-[#ca6180] ml-2 flex items-center gap-1"><span>🎨</span> Warna</label>
                        <input type="text" name="color" placeholder="Merah Marun, Putih, dll" class="w-full bg-white px-5 py-3 rounded-2xl border border-pink-100 focus:border-[#ca6180] focus:ring-4 focus:ring-pink-50 outline-none transition-all text-[#007979] placeholder-[#007979]/40">
                    </div>
                </div>

                <div class="space-y-3">
                    <label class="text-sm font-semibold text-[#ca6180] ml-2 flex items-center gap-1"><span>📦</span> Kategori</label>
                    <input type="hidden" name="category" id="category-input" value="atasan">
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-3" id="category-group">
                        <div class="category-card selected bg-white border-2 border-pink-200 rounded-2xl p-3 text-center cursor-pointer" data-value="atasan">
                            <span class="text-2xl">👔</span>
                            <p class="text-xs font-semibold text-[#007979] mt-1">Atasan</p>
                        </div>
                        <div class="category-card bg-white border-2 border-pink-100 rounded-2xl p-3 text-center cursor-pointer" data-value="bawahan">
                            <span class="text-2xl">👖</span>
                            <p class="text-xs font-semibold text-[#007979] mt-1">Bawahan</p>
                        </div>
                        <div class="category-card bg-white border-2 border-pink-100 rounded-2xl p-3 text-center cursor-pointer" data-value="outer">
                            <span class="text-2xl">🧥</span>
                            <p class="text-xs font-semibold text-[#007979] mt-1">Outer</p>
                        </div>
                        <div class="category-card bg-white border-2 border-pink-100 rounded-2xl p-3 text-center cursor-pointer" data-value="dress">
                            <span class="text-2xl">👗</span>
                            <p class="text-xs font-semibold text-[#007979] mt-1">Dress</p>
                        </div>
                        <div class="category-card bg-white border-2 border-pink-100 rounded-2xl p-3 text-center cursor-pointer" data-value="aksesoris">
                            <span class="text-2xl">💍</span>
                            <p class="text-xs font-semibold text-[#007979] mt-1">Aksesoris</p>
                        </div>
                    </div>
                    @error('category') <p class="text-red-400 text-xs mt-1 ml-2">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-semibold text-[#ca6180] ml-2 flex items-center gap-1"><span>📸</span> Foto Baju</label>
                    <div id="drop-area" class="drop-area w-full border-2 border-dashed border-pink-200 rounded-2xl p-6 flex flex-col items-center justify-center text-center cursor-pointer transition-all relative">
                        <input type="file" name="image" id="file-input" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer" required>
                        <div id="drop-content" class="flex flex-col items-center">
                            <svg class="w-12 h-12 text-[#ca6180] mb-3 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <p class="text-[#007979] font-medium text-sm">Klik atau seret foto ke sini</p>
                            <p class="text-[#ca6180]/60 text-xs mt-1">JPEG, PNG (max 5MB)</p>
                        </div>
                        <img id="preview-image" class="hidden max-h-48 rounded-xl mx-auto" alt="preview">
                    </div>
                    @error('image') <p class="text-red-400 text-xs mt-1 ml-2">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center justify-end gap-4 pt-6 border-t border-pink-50">
                    <a href="{{ route('wardrobe') }}" class="px-6 py-3 rounded-full font-medium text-gray-400 hover:text-gray-600 transition">Batal</a>
                    <button type="submit" class="bg-[#ca6180] hover:bg-[#b84d6a] text-white px-8 py-3 rounded-full font-bold shadow-md shadow-pink-200 transition-all transform hover:scale-105 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        Simpan ke Lemari
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
        function updateClock() {
            const now = new Date();
            document.getElementById('live-clock').textContent =
                `${String(now.getHours()).padStart(2,'0')}:${String(now.getMinutes()).padStart(2,'0')}:${String(now.getSeconds()).padStart(2,'0')}`;
        }
        updateClock();
        setInterval(updateClock, 1000);

        const categoryCards = document.querySelectorAll('.category-card');
        const categoryInput = document.getElementById('category-input');
        categoryCards.forEach(card => {
            card.addEventListener('click', () => {
                categoryCards.forEach(c => c.classList.remove('selected', 'border-[#ca6180]', 'bg-pink-50'));
                card.classList.add('selected', 'border-[#ca6180]', 'bg-pink-50');
                categoryInput.value = card.dataset.value;
            });
        });

        const dropArea = document.getElementById('drop-area');
        const fileInput = document.getElementById('file-input');
        const preview = document.getElementById('preview-image');
        const dropContent = document.getElementById('drop-content');

        function showPreview(file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                dropContent.classList.add('hidden');
                dropArea.classList.add('has-image');
            };
            reader.readAsDataURL(file);
        }

        fileInput.addEventListener('change', (e) => {
            if (e.target.files.length > 0) showPreview(e.target.files[0]);
        });

        dropArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropArea.classList.add('drag-over');
        });
        dropArea.addEventListener('dragleave', () => dropArea.classList.remove('drag-over'));
        dropArea.addEventListener('drop', (e) => {
            e.preventDefault();
            dropArea.classList.remove('drag-over');
            const files = e.dataTransfer.files;
            if (files.length) {
                fileInput.files = files;
                showPreview(files[0]);
            }
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