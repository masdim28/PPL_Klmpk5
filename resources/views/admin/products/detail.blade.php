<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail {{ $product->name }} | Admin Ade Afwa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex">

    <aside class="w-64 bg-indigo-900 min-h-screen text-white p-6 hidden md:block">
        <h2 class="text-2xl font-bold mb-10 tracking-widest italic text-center">ADE AFWA</h2>
        <nav class="space-y-4">
            <a href="{{ route('admin.dashboard') }}" class="block py-2.5 px-4 rounded hover:bg-indigo-800 transition text-sm">Dashboard</a>
            <a href="{{ route('admin.products.index') }}" class="block py-2.5 px-4 rounded bg-indigo-800 shadow-lg transition text-sm font-semibold">Kelola Produk</a>
        </nav>
    </aside>

    <main class="flex-1 p-8">
        <div class="mb-8 flex items-center justify-between">
            <div>
                <a href="{{ route('admin.products.index') }}" class="text-indigo-600 hover:text-indigo-800 flex items-center gap-2 font-semibold mb-2">
                    ← Kembali ke Daftar
                </a>
                <h1 class="text-3xl font-bold text-gray-800">Detail Informasi Produk</h1>
            </div>
            <a href="{{ route('admin.products.edit', $product->id) }}" class="bg-amber-500 hover:bg-amber-600 text-white px-6 py-2 rounded-xl font-bold shadow-sm transition">
                Edit Data
            </a>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden max-w-6xl mx-auto">
            <div class="md:flex">
                <div class="md:w-1/2 p-8 bg-gray-50 border-r border-gray-100">
                    <div class="mb-6">
                        <img src="{{ asset('storage/' . $product->image) }}" 
                             id="mainImage"
                             class="w-full rounded-2xl shadow-lg border-4 border-white object-cover aspect-square"
                             alt="{{ $product->name }}">
                    </div>
                    
                    <div class="flex flex-wrap gap-3 justify-center">
                        {{-- Menampilkan semua gambar dari relasi images --}}
                        @foreach($product->images as $img)
                            <img src="{{ asset('storage/' . $img->image_path) }}" 
                                 onclick="changeImage('{{ asset('storage/' . $img->image_path) }}')"
                                 class="w-20 h-20 rounded-xl cursor-pointer hover:ring-4 hover:ring-indigo-500 transition-all border-2 border-white shadow-sm object-cover">
                        @endforeach
                    </div>
                    <p class="text-center text-[10px] text-gray-400 mt-4 italic font-medium uppercase tracking-widest">Klik gambar kecil untuk memperbesar</p>
                </div>

                <div class="md:w-1/2 p-10">
                    <div class="mb-6">
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-widest">Nama Koleksi</label>
                        <h2 class="text-4xl font-black text-indigo-900 mt-1 uppercase">{{ $product->name }}</h2>
                    </div>

                    <div class="grid grid-cols-2 gap-8 mb-8">
                        <div>
                            <label class="text-xs font-bold text-gray-400 uppercase tracking-widest">Harga Jual</label>
                            <p class="text-2xl font-black text-indigo-600">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <label class="text-xs font-bold text-gray-400 uppercase tracking-widest">Stok Barang</label>
                            <p class="text-2xl font-black text-gray-800">{{ $product->stock }} <span class="text-sm font-normal text-gray-400">Pcs</span></p>
                        </div>
                    </div>

                    <div class="mb-8">
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3 block">Kategori Produk</label>
                        <div class="flex flex-wrap gap-2">
                            @forelse($product->categories as $category)
                                <span class="px-4 py-1.5 bg-indigo-50 text-indigo-600 text-[10px] rounded-lg font-black border border-indigo-100 uppercase tracking-wider">
                                    {{ $category->name }}
                                </span>
                            @empty
                                <span class="text-gray-400 italic text-sm">Tanpa kategori</span>
                            @endforelse
                        </div>
                    </div>

                    <div class="mb-8">
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 block">Status Ketersediaan</label>
                        <span class="inline-flex items-center px-4 py-2 rounded-xl font-bold uppercase text-xs tracking-widest {{ $product->status == 'ready' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $product->status == 'ready' ? '🟢 Ready Stock' : '🔴 Sold Out' }}
                        </span>
                    </div>

                    <div class="pt-8 border-t border-gray-100">
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 block">Deskripsi Produk</label>
                        <p class="text-gray-600 leading-relaxed">
                            {{ $product->description ?: 'Tidak ada deskripsi.' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        function changeImage(path) {
            document.getElementById('mainImage').src = path;
        }
    </script>

</body>
</html>