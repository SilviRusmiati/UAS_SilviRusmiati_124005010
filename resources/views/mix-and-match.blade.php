<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Match STYLE | Mix & Match</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/interactjs/dist/interact.min.js"></script>
    <style>
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(24px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fade-in-up { animation: fadeInUp 0.6s cubic-bezier(0.23, 1, 0.32, 1) forwards; opacity: 0; }
        .delay-100 { animation-delay: 0.1s; } .delay-200 { animation-delay: 0.2s; }
        .nav-link { transition: all 0.3s ease; border-radius: 0.75rem; }
        .nav-link:hover { background: linear-gradient(90deg, rgba(0,121,121,0.12) 0%, rgba(202,97,128,0.08) 80%); color: #ca6180; }
        .nav-link.active { background: linear-gradient(90deg, rgba(0,121,121,0.25) 0%, rgba(202,97,128,0.1) 70%); color: #007979; font-weight: 600; box-shadow: 0 4px 12px rgba(0,121,121,0.12); }
        ::-webkit-scrollbar { width: 5px; } ::-webkit-scrollbar-track { background: #fff5f5; } ::-webkit-scrollbar-thumb { background: #ca6180; border-radius: 10px; }
        
        .canvas-container {
            background: #fff;
            border: 2px dashed #f9a8d4;
            min-height: 500px;
            position: relative;
            overflow: hidden;
            border-radius: 1.5rem;
        }
        .draggable-item {
            position: absolute;
            cursor: move;
            transition: box-shadow 0.2s;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(202,97,128,0.2);
            background: white;
            padding: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            user-select: none;
            touch-action: none;
            box-sizing: border-box;
        }
        .draggable-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 8px;
            pointer-events: none;
        }
        .resize-handle {
            position: absolute;
            width: 14px;
            height: 14px;
            background: #ca6180;
            border-radius: 50%;
            bottom: -7px;
            right: -7px;
            cursor: se-resize;
            z-index: 10;
        }
        .delete-item-btn {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #ef4444;
            color: white;
            border-radius: 50%;
            width: 22px;
            height: 22px;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 10;
            transition: 0.2s;
        }
        .delete-item-btn:hover { background: #dc2626; }
        .wardrobe-item { transition: all 0.15s; cursor: grab; }
        .wardrobe-item:active { cursor: grabbing; }

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
            <a href="{{ route('wardrobe') }}" class="nav-link flex items-center gap-3 px-4 py-3 text-gray-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg> Wardrobe
            </a>
            <a href="#" class="nav-link active flex items-center gap-3 px-4 py-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg> Mix & Match
            </a>
        </nav>
        <a href="#" id="logout-link" class="nav-link flex items-center gap-3 px-4 py-3 text-red-400 hover:text-red-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
            Log Out
        </a>
    </aside>

    <main class="flex-1 ml-72 p-8 relative z-10 flex flex-col">
        <header class="mb-6 animate-fade-in-up">
            @php $userName = optional(auth()->user())->name; @endphp
            <h1 class="text-3xl font-bold text-[#ca6180] tracking-tight">Mix & Match {{ $userName ?? 'Silvi' }}</h1>
            <p class="text-[#007979] font-medium text-base mt-0.5">drag & drop baju ke kanvas, atur gayamu ✨</p>
        </header>

        <div class="flex gap-6 flex-1 h-full">
            <div class="w-72 shrink-0 bg-white/80 backdrop-blur-sm rounded-2xl p-5 shadow-sm border border-pink-100 flex flex-col animate-fade-in-up delay-100" style="max-height: calc(100vh - 180px);">
                <h3 class="font-bold text-[#007979] mb-3 flex items-center gap-2"><span>👚</span> Lemari</h3>
                <div class="relative mb-4">
                    <svg class="w-4 h-4 text-[#ca6180] absolute left-3 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input id="wardrobe-search" type="text" placeholder="Cari baju..." class="w-full pl-9 pr-4 py-2 rounded-xl border border-pink-100 text-sm text-[#007979] placeholder-[#007979]/50 focus:outline-none focus:border-[#ca6180] focus:ring-2 focus:ring-pink-50">
                </div>

                <div class="flex-1 overflow-y-auto" id="wardrobe-list">
                    @php
                        $categories = ['atasan', 'bawahan', 'outer', 'dress', 'aksesoris'];
                        $categoryLabels = ['atasan'=>'Atasan', 'bawahan'=>'Bawahan', 'outer'=>'Outer', 'dress'=>'Dress', 'aksesoris'=>'Aksesoris'];
                        $emojis = ['atasan'=>'👔','bawahan'=>'👖','outer'=>'🧥','dress'=>'👗','aksesoris'=>'💍'];
                    @endphp
                    @foreach($categories as $cat)
                        @if($outfits->where('category', $cat)->count())
                        <div class="mb-4 category-group" data-category="{{ $cat }}">
                            <h4 class="text-sm font-semibold text-[#ca6180] mb-2">{{ $categoryLabels[$cat] }}</h4>
                            <div class="space-y-2">
                                @foreach($outfits->where('category', $cat) as $item)
                                <div class="wardrobe-item flex items-center gap-3 p-2 rounded-xl border border-pink-100 bg-white"
                                     draggable="true"
                                     data-id="{{ $item->id }}"
                                     data-name="{{ $item->name }}"
                                     data-category="{{ $item->category }}"
                                     data-image="{{ $item->image ? asset('storage/'.$item->image) : '' }}">
                                    <div class="w-10 h-10 bg-pink-50 rounded-lg flex items-center justify-center overflow-hidden shrink-0">
                                        @if($item->image)
                                            <img src="{{ asset('storage/'.$item->image) }}" class="w-full h-full object-cover" alt="{{ $item->name }}">
                                        @else
                                            <span class="text-lg">{{ $emojis[$item->category] ?? '👕' }}</span>
                                        @endif
                                    </div>
                                    <span class="text-xs font-medium text-[#007979] truncate">{{ $item->name }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>

                <button id="clear-canvas-btn" class="w-full mt-4 bg-red-50 hover:bg-red-100 text-red-400 py-2 rounded-full text-sm font-medium transition">
                    Bersihkan Kanvas
                </button>
            </div>

            <div class="flex-1 animate-fade-in-up delay-200">
                <div id="canvas" class="canvas-container w-full" style="height: calc(100vh - 200px);"></div>
                <p class="text-xs text-gray-400 mt-2 text-center">✨ Seret baju ke kanvas, lalu atur posisi & ukuran. Klik tombol merah untuk hapus.</p>
            </div>
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
        document.addEventListener('DOMContentLoaded', function () {
            const canvas = document.getElementById('canvas');
            let zIndex = 10;

            // Search functionality
            const searchInput = document.getElementById('wardrobe-search');
            searchInput.addEventListener('input', function() {
                const query = this.value.trim().toLowerCase();
                const items = document.querySelectorAll('.wardrobe-item');
                const groups = document.querySelectorAll('.category-group');

                items.forEach(item => {
                    const name = item.dataset.name.toLowerCase();
                    const category = item.dataset.category.toLowerCase();
                    item.style.display = (!query || name.includes(query) || category.includes(query)) ? '' : 'none';
                });

                groups.forEach(group => {
                    const visibleItems = group.querySelectorAll('.wardrobe-item[style*="display: none"]');
                    const totalItems = group.querySelectorAll('.wardrobe-item');
                    group.style.display = (visibleItems.length === totalItems.length) ? 'none' : '';
                });
            });

            // Drag from sidebar
            const wardrobeItems = document.querySelectorAll('.wardrobe-item');
            wardrobeItems.forEach(item => {
                item.addEventListener('dragstart', function(e) {
                    e.dataTransfer.setData('text/plain', JSON.stringify({
                        id: this.dataset.id,
                        name: this.dataset.name,
                        category: this.dataset.category,
                        image: this.dataset.image || ''
                    }));
                    e.dataTransfer.effectAllowed = 'move';
                });
            });

            canvas.addEventListener('dragover', e => e.preventDefault());
            canvas.addEventListener('drop', function(e) {
                e.preventDefault();
                const data = JSON.parse(e.dataTransfer.getData('text/plain'));
                if (!data) return;
                createCanvasItem(data, e.clientX, e.clientY);
            });

            function createCanvasItem(data, clientX, clientY) {
                const rect = canvas.getBoundingClientRect();
                const x = Math.max(0, clientX - rect.left - 60);
                const y = Math.max(0, clientY - rect.top - 60);

                const div = document.createElement('div');
                div.className = 'draggable-item';
                div.style.left = x + 'px';
                div.style.top = y + 'px';
                div.style.width = '120px';
                div.style.height = '120px';
                div.style.zIndex = zIndex++;
                div.dataset.id = data.id;
                div.dataset.name = data.name;
                div.dataset.category = data.category;
                div.dataset.image = data.image;

                const deleteBtn = document.createElement('span');
                deleteBtn.className = 'delete-item-btn';
                deleteBtn.innerHTML = '✕';
                deleteBtn.addEventListener('click', e => { e.stopPropagation(); div.remove(); });
                div.appendChild(deleteBtn);

                if (data.image) {
                    const img = document.createElement('img');
                    img.src = data.image;
                    img.alt = data.name;
                    div.appendChild(img);
                } else {
                    const emojiSpan = document.createElement('span');
                    const emojiMap = { atasan: '👔', bawahan: '👖', outer: '🧥', dress: '👗', aksesoris: '💍' };
                    emojiSpan.textContent = emojiMap[data.category] || '👕';
                    emojiSpan.style.fontSize = '3rem';
                    div.appendChild(emojiSpan);
                }

                const resizeHandle = document.createElement('div');
                resizeHandle.className = 'resize-handle';
                div.appendChild(resizeHandle);

                canvas.appendChild(div);
                enableInteract(div);
            }

            function enableInteract(element) {
                interact(element)
                    .draggable({
                        inertia: true,
                        modifiers: [
                            interact.modifiers.restrictRect({ restriction: 'parent', endOnly: true })
                        ],
                        autoScroll: true,
                        listeners: { move: dragMoveListener }
                    })
                    .resizable({
                        edges: { bottom: true, right: true },
                        listeners: {
                            move(event) {
                                let { x, y } = event.target.dataset;
                                x = (parseFloat(x) || 0) + event.deltaRect.left;
                                y = (parseFloat(y) || 0) + event.deltaRect.top;

                                Object.assign(event.target.style, {
                                    width: `${event.rect.width}px`,
                                    height: `${event.rect.height}px`,
                                });
                                Object.assign(event.target.dataset, { x, y });
                            }
                        },
                        modifiers: [
                            interact.modifiers.restrictSize({ min: { width: 60, height: 60 }, max: { width: 300, height: 300 } })
                        ]
                    });
            }

            function dragMoveListener(event) {
                const target = event.target;
                const x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx;
                const y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy;
                target.style.transform = `translate(${x}px, ${y}px)`;
                target.setAttribute('data-x', x);
                target.setAttribute('data-y', y);
            }

            document.getElementById('clear-canvas-btn').addEventListener('click', () => {
                canvas.querySelectorAll('.draggable-item').forEach(el => el.remove());
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
        });
    </script>
</body>
</html>