<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Ade Afwa Boutique</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,700&family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-serif { font-family: 'Playfair Display', serif; }
    </style>
</head>
<body class="bg-[#F1FBFD] flex">

    <aside class="w-64 bg-indigo-950 min-h-screen text-white p-6 hidden md:block sticky top-0 h-screen shadow-[5px_0_15px_rgba(0,0,0,0.2)] border-r border-indigo-900/50 z-20">
        <div class="mb-10 text-center">
            <h2 class="text-2xl font-black tracking-[0.15em] italic font-serif text-[#CFB53B]">ADE AFWA</h2>
            <p class="text-[9px] text-indigo-400 uppercase tracking-widest mt-1">Official Dashboard</p>
        </div>
        
        <nav class="space-y-2">
            <p class="text-[10px] font-black text-indigo-500 uppercase px-4 tracking-[0.2em] mb-2">Menu Utama</p>
            
            <a href="{{ route('admin.dashboard') }}" 
               class="block py-3 px-4 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-900 text-white shadow-lg border-l-4 border-[#CFB53B]' : 'text-indigo-300 hover:bg-indigo-900/50 hover:text-white' }}">
               Dashboard
            </a>

            <a href="{{ route('admin.products.index') }}" 
               class="block py-3 px-4 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.products.*') ? 'bg-indigo-900 text-white shadow-lg border-l-4 border-[#CFB53B]' : 'text-indigo-300 hover:bg-indigo-900/50 hover:text-white' }}">
               Kelola Produk
            </a>

            <a href="{{ route('admin.users.index') }}" 
               class="block py-3 px-4 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-indigo-900 text-white shadow-lg border-l-4 border-[#CFB53B]' : 'text-indigo-300 hover:bg-indigo-900/50 hover:text-white' }}">
               Kelola User
            </a>
            
            <div class="pt-6 pb-2 border-t border-indigo-900/50 mt-4">
                <p class="text-[10px] font-black text-indigo-500 uppercase px-4 tracking-[0.2em]">Manajemen Pesanan</p>
            </div>
            
            <a href="{{ route('admin.orders.transaksi') }}" 
               class="group block py-3 px-4 rounded-xl transition-all {{ request()->routeIs('admin.orders.transaksi') ? 'bg-indigo-900 text-white border-l-4 border-[#CFB53B]' : 'text-indigo-400 hover:bg-indigo-900/50 hover:text-white' }}">
                <div class="flex items-center gap-3">
                    <span class="bg-indigo-800 group-hover:bg-indigo-700 w-6 h-6 flex items-center justify-center rounded-lg text-[10px] font-bold">1</span>
                    <span class="text-sm">Transaksi</span>
                </div>
            </a>

            <a href="{{ route('admin.orders.pesanan') }}" 
               class="group block py-3 px-4 rounded-xl transition-all {{ request()->routeIs('admin.orders.pesanan') ? 'bg-indigo-900 text-white border-l-4 border-[#CFB53B]' : 'text-indigo-400 hover:bg-indigo-900/50 hover:text-white' }}">
                <div class="flex items-center gap-3">
                    <span class="bg-indigo-800 group-hover:bg-indigo-700 w-6 h-6 flex items-center justify-center rounded-lg text-[10px] font-bold">2</span>
                    <span class="text-sm">Pesanan</span>
                </div>
            </a>

            <a href="{{ route('admin.orders.selesai') }}" 
               class="group block py-3 px-4 rounded-xl transition-all {{ request()->routeIs('admin.orders.selesai') ? 'bg-indigo-900 text-white border-l-4 border-[#CFB53B]' : 'text-indigo-400 hover:bg-indigo-900/50 hover:text-white' }}">
                <div class="flex items-center gap-3">
                    <span class="bg-indigo-800 group-hover:bg-indigo-700 w-6 h-6 flex items-center justify-center rounded-lg text-[10px] font-bold">3</span>
                    <span class="text-sm">Berhasil</span>
                </div>
            </a>

            <div class="pt-10">
                <a href="/" target="_blank" class="group bg-indigo-900/40 p-4 rounded-2xl border border-indigo-900 flex flex-col gap-2 hover:bg-indigo-900 transition-all text-center">
                    <span class="text-[9px] text-indigo-400 font-bold uppercase tracking-widest">Customer View</span>
                    <div class="flex items-center justify-center gap-2 text-white text-xs font-bold italic">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#CFB53B]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Buka Website
                    </div>
                </a>
            </div>
        </nav>
    </aside>

    <div class="flex-1 flex flex-col min-h-screen relative">
        
        <header class="bg-indigo-950 p-8 shadow-xl border-b border-indigo-900 sticky top-0 z-10">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-black text-white italic font-serif tracking-tight uppercase">{{ $header ?? 'Dashboard' }}</h1>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse shadow-[0_0_8px_rgba(52,211,153,0.5)]"></span>
                        <p class="text-indigo-300 text-[10px] font-bold uppercase tracking-widest">Sistem Manajemen Butik</p>
                    </div>
                </div>

                <div class="flex items-center gap-6">
                    <div class="text-right border-r border-indigo-800 pr-6 hidden sm:block">
                        <p class="text-sm font-bold text-white tracking-wide">{{ Auth::user()->name }}</p>
                        <p class="text-[10px] text-[#CFB53B] font-black uppercase tracking-widest">Administrator</p>
                    </div>
                    
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-6 py-2.5 rounded-xl text-xs font-black transition-all shadow-lg shadow-red-950/40 uppercase tracking-tighter active:scale-95">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </header>

       <main class="p-8 flex-grow">
            {{-- 
                GANTI {{ $slot }} menjadi @yield('content') 
                karena Anda menggunakan struktur @extends di halaman dashboard 
            --}}
            @yield('content') 
        </main>

        <footer class="p-8 pt-0">
            <p class="text-center text-gray-400 text-[10px] uppercase tracking-widest font-bold">
                &copy; 2026 ADE AFWA BOUTIQUE 
            </p>
        </footer>

    </div>

    {{-- 
        PENTING: Tambahkan @stack('scripts') di sini!
        Ini tempat menempelnya script Chart.js dari halaman dashboard 
    --}}
    @stack('scripts')
</body>
</html>