<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Ade Afwa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex">

    <aside class="w-64 bg-indigo-900 min-h-screen text-white p-6 hidden md:block">
        <h2 class="text-2xl font-bold mb-10 tracking-widest italic text-center">ADE AFWA</h2>
        <nav class="space-y-4">
            <a href="{{ route('admin.dashboard') }}" class="block py-2.5 px-4 rounded bg-indigo-800 transition shadow-lg">Dashboard</a>
            
            <a href="{{ route('admin.products.index') }}" class="block py-2.5 px-4 rounded hover:bg-indigo-700 transition">Kelola Produk</a>
            
            <div class="pt-4 pb-2 border-t border-indigo-800 mt-4">
                <p class="text-xs font-semibold text-indigo-400 uppercase px-4 tracking-wider">Kelola Pesanan</p>
            </div>
            
            <a href="{{ route('admin.orders.transaksi') }}" class="block py-2.5 px-4 rounded hover:bg-indigo-700 transition flex items-center gap-3">
                <span class="bg-indigo-700 w-6 h-6 flex items-center justify-center rounded text-xs">1</span>
                Transaksi
            </a>
            
            <a href="{{ route('admin.orders.pesanan') }}" class="block py-2.5 px-4 rounded hover:bg-indigo-700 transition flex items-center gap-3">
                <span class="bg-indigo-700 w-6 h-6 flex items-center justify-center rounded text-xs">2</span>
                Pesanan
            </a>
            
            <a href="{{ route('admin.orders.selesai') }}" class="block py-2.5 px-4 rounded hover:bg-indigo-700 transition flex items-center gap-3">
                <span class="bg-indigo-700 w-6 h-6 flex items-center justify-center rounded text-xs">3</span>
                Berhasil
            </a>
            
            <div class="pt-10">
                <a href="/" class="text-indigo-300 hover:text-white text-sm flex items-center gap-2 px-4 italic">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Lihat Website
                </a>
            </div>
        </nav>
    </aside>

    <main class="flex-1 p-8">
        <header class="flex justify-between items-center mb-10">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Ringkasan Bisnis</h1>
                <p class="text-gray-500">Selamat datang kembali, Admin Ade!</p>
            </div>
            
            <div class="flex items-center gap-6">
                <div class="text-right">
                    <p class="text-sm font-bold text-gray-800">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-green-600 font-medium italic">Online</p>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="bg-red-500 hover:bg-red-600 text-white px-5 py-2 rounded-xl text-sm font-bold transition shadow-md">
                        Logout
                    </button>
                </form>
            </div>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10">
            <div class="bg-white p-8 rounded-2xl shadow-sm border-b-4 border-indigo-600 hover:shadow-md transition">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-400 text-sm font-medium uppercase tracking-wider">Total Produk</p>
                        <h3 class="text-4xl font-black mt-1 text-gray-800">12</h3>
                    </div>
                    <div class="bg-indigo-100 p-3 rounded-lg text-indigo-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white p-8 rounded-2xl shadow-sm border-b-4 border-emerald-500 hover:shadow-md transition">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-400 text-sm font-medium uppercase tracking-wider">Pesanan Masuk</p>
                        <h3 class="text-4xl font-black mt-1 text-gray-800">5</h3>
                    </div>
                    <div class="bg-emerald-100 p-3 rounded-lg text-emerald-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white p-8 rounded-2xl shadow-sm border-b-4 border-amber-500 hover:shadow-md transition">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-400 text-sm font-medium uppercase tracking-wider">Pendapatan</p>
                        <h3 class="text-3xl font-black mt-1 text-amber-600">Rp 1.500k</h3>
                    </div>
                    <div class="bg-amber-100 p-3 rounded-lg text-amber-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3zM12 2a10 10 0 100 20 10 10 0 000-20z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-indigo-900 text-white p-10 rounded-3xl shadow-xl relative overflow-hidden">
            <div class="relative z-10">
                <h2 class="text-2xl font-bold mb-2">Siap Berjualan Hari Ini?</h2>
                <p class="text-indigo-200 max-w-md">Pantau stok produk kamu dan kelola pesanan pelanggan Butik Ade Afwa dengan cepat di panel ini.</p>
                <a href="{{ route('admin.products.index') }}" class="mt-6 inline-block bg-white text-indigo-900 px-6 py-2 rounded-full font-bold text-sm hover:bg-gray-100 transition">
                    Cek Produk Sekarang
                </a>
            </div>
            <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-indigo-800 rounded-full opacity-50"></div>
        </div>
    </main>
</body>
</html>