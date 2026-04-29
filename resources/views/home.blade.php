<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ade Afwa Boutique | Koleksi Elegan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .font-serif-ade { font-family: 'Playfair Display', serif; }
        .bg-ade-green { background-color: #F0F4F1; } 
        .bg-ade-krem { background-color: #FDF9F0; } 
        .text-ade-gold { color: #CFB53B; }
        .bg-ade-gold { background-color: #CFB53B; }
        .no-scrollbar::-webkit-scrollbar { display: none; }

        /* Sidebar Transition Logic */
        #mobile-sidebar { transition: transform 0.3s ease-in-out; }
        .sidebar-open { transform: translateX(0) !important; }
    </style>
</head>
<body class="bg-ade-green text-gray-900 overflow-x-hidden">

    <div id="sidebar-overlay" onclick="toggleMobileMenu()" class="fixed inset-0 bg-black/40 z-[60] hidden"></div>

    <div id="mobile-sidebar" class="fixed inset-y-0 left-0 w-72 bg-white z-[70] transform -translate-x-full shadow-2xl p-6 overflow-y-auto lg:hidden">
        <div class="flex justify-between items-center mb-8 border-b pb-4">
            <h2 class="font-serif-ade text-xl text-ade-gold uppercase tracking-widest">Menu</h2>
            <button onclick="toggleMobileMenu()" class="text-gray-400">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <nav class="space-y-4">
            @foreach(\App\Models\Category::whereNull('parent_id')->with('children')->get() as $category)
                <div class="border-b border-gray-50 pb-2">
                    <div class="flex justify-between items-center py-2">
                        <a href="{{ route('category.show', $category->slug) }}" class="text-xs font-bold text-gray-700 hover:text-ade-gold uppercase tracking-widest">
                            {{ $category->name }}
                        </a>
                        @if($category->children->count() > 0)
                            <button onclick="toggleSubMenu('side-sub-{{ $category->id }}', this)" class="text-ade-gold transition-transform duration-300">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </button>
                        @endif
                    </div>
                    @if($category->children->count() > 0)
                        <div id="side-sub-{{ $category->id }}" class="hidden pl-4 mt-2 space-y-3 pb-2">
                            @foreach($category->children as $child)
                                <a href="{{ route('category.show', $child->slug) }}" class="block text-[10px] text-gray-500 uppercase tracking-widest hover:text-ade-gold">
                                    {{ $child->name }}
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        </nav>
    </div>

    <nav class="bg-ade-krem shadow-sm sticky top-0 z-50 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                
                <div class="flex-1 flex items-center md:hidden">
                    <button type="button" class="text-ade-gold p-2" onclick="toggleMobileMenu()">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>

                <div class="flex-1 hidden md:flex"></div>

                <div class="flex-shrink-0 flex justify-center">
                    <a href="/">
                        <img src="{{ asset('images/logo_adeafwa.png') }}" alt="Ade Afwa Boutique" class="h-9 md:h-12 transition-all">
                    </a>
                </div>

                <div class="flex-1 flex justify-end items-center space-x-3 md:space-x-6">
                    <button class="text-ade-gold hover:text-gray-900 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:h-6 md:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </button>

                    @auth
                        <a href="{{ route('profile.edit') }}" class="text-ade-gold hover:text-gray-900">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:h-6 md:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                        </a>
                        <a href="{{ route('cart.index') }}" class="relative text-ade-gold hover:text-gray-900">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:h-6 md:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                            @if(Auth::user()->cartItems && Auth::user()->cartItems->count() > 0)
                                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[8px] md:text-[10px] font-bold px-1.5 py-0.5 rounded-full">{{ Auth::user()->cartItems->count() }}</span>
                            @endif
                        </a>
                    @endauth

                    @guest
                        <div class="flex items-center space-x-1.5 md:space-x-3">
                            <a href="{{ route('login') }}" class="bg-[#A0D9E1] text-gray-800 px-3 md:px-4 py-1.5 rounded text-[10px] md:text-xs font-bold uppercase hover:bg-cyan-200 transition-all">Login</a>
                            <a href="{{ route('register') }}" class="bg-[#E2C78E] text-gray-800 px-3 md:px-4 py-1.5 rounded text-[10px] md:text-xs font-bold uppercase hover:bg-amber-200 transition-all">Join</a>
                        </div>
                    @endguest
                </div>
            </div>

            <div class="hidden md:flex justify-center items-center space-x-10 py-3 border-t border-gray-50">
                @foreach(\App\Models\Category::whereNull('parent_id')->with('children')->get() as $category)
                    <div class="relative group">
                        <a href="{{ route('category.show', $category->slug) }}" class="text-ade-gold hover:text-gray-900 font-bold uppercase text-[11px] tracking-widest flex items-center gap-1">
                            {{ $category->name }}
                            @if($category->children->count() > 0)
                                <svg class="w-3 h-3 group-hover:rotate-180 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            @endif
                        </a>
                        @if($category->children->count() > 0)
                            <div class="absolute hidden group-hover:block bg-white shadow-xl mt-0 py-3 w-48 rounded-b-lg border border-gray-50 z-[60]">
                                @foreach($category->children as $child)
                                    <a href="{{ route('category.show', $child->slug) }}" class="block px-4 py-2 text-xs text-gray-600 hover:bg-ade-krem hover:text-ade-gold uppercase tracking-tighter transition-colors">
                                        {{ $child->name }}
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </nav>

    @if(!isset($currentCategory))
    <div class="relative overflow-hidden w-full h-[250px] md:h-[600px]">
        <div id="slider" class="flex transition-transform duration-[1500ms] ease-in-out h-full">
            <div class="w-full h-full flex-shrink-0"><img src="{{ asset('images/foto1.png') }}" class="w-full h-full object-cover"></div>
            <div class="w-full h-full flex-shrink-0"><img src="{{ asset('images/foto2.png') }}" class="w-full h-full object-cover"></div>
            <div class="w-full h-full flex-shrink-0"><img src="{{ asset('images/foto3.png') }}" class="w-full h-full object-cover"></div>
            <div class="w-full h-full flex-shrink-0"><img src="{{ asset('images/foto4.png') }}" class="w-full h-full object-cover"></div>
        </div>
        <div class="absolute bottom-5 left-1/2 transform -translate-x-1/2 flex space-x-2">
            @for($i=0; $i<4; $i++)
                <div class="w-2 h-2 rounded-full bg-white/50 transition-all duration-300" id="dot-{{ $i }}"></div>
            @endfor
        </div>
    </div>
    @endif

    <main class="max-w-7xl mx-auto px-4 py-10 md:py-20">
        @if(isset($currentCategory))
            <div class="text-center mb-16">
                <h3 class="text-3xl font-serif-ade font-bold text-gray-800 uppercase tracking-[0.2em]">{{ $currentCategory->name }}</h3>
                <div class="h-0.5 w-24 bg-ade-gold mx-auto mt-4"></div>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-8">
                @forelse($products as $p)
                    <div class="bg-white/80 backdrop-blur-sm p-3 rounded-md group transition-all shadow-sm">
                        <div class="relative overflow-hidden aspect-[3/4] rounded-sm mb-4">
                            <img src="{{ asset('storage/' . $p->image) }}" alt="{{ $p->name }}" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-700">
                            <a href="{{ route('products.detail', $p->id) }}" class="absolute inset-0 bg-black/10 opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-4">
                                <span class="w-full bg-white/90 backdrop-blur py-2 text-center text-[10px] font-bold uppercase tracking-widest text-ade-gold">Detail Produk</span>
                            </a>
                        </div>
                        <h4 class="text-[11px] md:text-sm font-semibold text-gray-800 mb-1 group-hover:text-ade-gold transition-colors">{{ $p->name }}</h4>
                        <p class="text-ade-gold font-bold text-xs md:text-base">Rp {{ number_format($p->price, 0, ',', '.') }}</p>
                    </div>
                @empty
                    <div class="col-span-full text-center py-20 text-gray-400 font-light italic">Belum ada koleksi tersedia.</div>
                @endforelse
            </div>
        @else
             @foreach($categoriesWithProducts as $category)
                @if($category->products->count() > 0)
                    <div class="mb-24">
                        <div class="flex justify-between items-end mb-8 border-b border-gray-100 pb-4">
                            <div>
                                <h3 class="text-xl md:text-2xl font-serif-ade font-bold text-gray-800 uppercase tracking-widest">{{ $category->name }}</h3>
                                <div class="h-1 w-12 bg-ade-gold mt-2"></div>
                            </div>
                            <a href="{{ route('category.show', $category->slug) }}" class="text-ade-gold hover:text-gray-900 text-[10px] md:text-xs font-bold uppercase flex items-center gap-2 transition-all">
                                Lihat Semua <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                            </a>
                        </div>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-8">
                            @foreach($category->products as $p)
                                <div class="group cursor-pointer">
                                    <div class="relative overflow-hidden rounded-sm aspect-[3/4] mb-5 shadow-sm">
                                        <img src="{{ asset('storage/' . $p->image) }}" alt="{{ $p->name }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-1000">
                                        <a href="{{ route('products.detail', $p->id) }}" class="absolute inset-0 bg-black/5 opacity-0 group-hover:opacity-100 transition flex items-end p-4">
                                            <span class="w-full bg-white/90 backdrop-blur py-2 text-center text-[10px] font-bold uppercase tracking-widest text-ade-gold">Detail Produk</span>
                                        </a>
                                    </div>
                                    <h4 class="text-[10px] md:text-xs font-medium text-gray-500 uppercase tracking-widest mb-1">{{ $p->name }}</h4>
                                    <p class="text-ade-gold font-bold text-xs md:text-base">Rp {{ number_format($p->price, 0, ',', '.') }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
        @endif
    </main>

    <footer class="bg-ade-krem border-t border-gray-100 py-16 text-center">
        <div class="max-w-7xl mx-auto px-4">
            <img src="{{ asset('images/logo_adeafwa.png') }}" alt="Logo" class="h-10 mx-auto mb-8 grayscale opacity-50">
            <p class="text-gray-400 text-[10px] uppercase tracking-[0.3em]">© 2026 Ade Afwa Boutique. Dibuat dengan ❤️ oleh Kelompok 5 Informatika UINSSC.</p>
        </div>
    </footer>

    <script>
        function toggleMobileMenu() {
            const sidebar = document.getElementById('mobile-sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            sidebar.classList.toggle('sidebar-open');
            overlay.classList.toggle('hidden');
            document.body.classList.toggle('overflow-hidden');
        }

        function toggleSubMenu(id, btn) {
            const sub = document.getElementById(id);
            sub.classList.toggle('hidden');
            btn.classList.toggle('rotate-180');
        }

        let slideIndex = 0;
        const slider = document.getElementById('slider');
        if(slider) {
            const slides = slider.children.length;
            function updateDots() {
                for (let i = 0; i < slides; i++) {
                    const dot = document.getElementById(`dot-${i}`);
                    if (dot) {
                        if (i === slideIndex) {
                            dot.classList.replace('bg-white/50', 'bg-white');
                            dot.classList.add('scale-150');
                        } else {
                            dot.classList.replace('bg-white', 'bg-white/50');
                            dot.classList.remove('scale-150');
                        }
                    }
                }
            }
            setInterval(() => {
                slideIndex = (slideIndex + 1) % slides;
                slider.style.transform = `translateX(-${slideIndex * 100}%)`;
                updateDots();
            }, 5000); 
            updateDots();
        }
    </script>
</body>
</html>