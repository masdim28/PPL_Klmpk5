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

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden max-w-5xl mx-auto">
            <div class="md:flex">
                <div class="md:w-2/5 p-8 bg-gray-50 flex flex-col items-center justify-center border-r border-gray-100">
                    <img src="{{ asset('storage/' . $product->image) }}" 
                         class="w-full rounded-2xl shadow-lg border-4 border-white object-cover aspect-square mb-4"
                         alt="{{ $product->name }}">
                    
                    <span class="px-6 py-2 rounded-full font-bold uppercase text-xs tracking-widest {{ $product->status == 'ready' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        Status: {{ $product->status }}
                    </span>
                </div>

                <div class="md:w-3/5 p-10">
                    <div class="mb-6">
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-widest">Nama Koleksi</label>
                        <h2 class="text-4xl font-black text-indigo-900 mt-1">{{ $product->name }}</h2>
                    </div>

                    <div class="grid grid-cols-2 gap-8 mb-8">
                        <div>
                            <label class="text-xs font-bold text-gray-400 uppercase tracking-widest">Harga Satuan</label>
                            <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <label class="text-xs font-bold text-gray-400 uppercase tracking-widest">Stok Tersedia</label>
                            <p class="text-2xl font-bold text-gray-800">{{ $product->stock }} <span class="text-sm font-normal text-gray-400">Pcs</span></p>
                        </div>
                    </div>

                    <div class="mb-8">
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3 block">Kategori Terkait</label>
                        <div class="flex flex-wrap gap-2">
                            {{-- Perbaikan: Menampilkan banyak kategori dari tabel pivot --}}
                            @forelse($product->categories as $category)
                                <span class="px-4 py-1.5 bg-indigo-50 text-indigo-600 text-xs rounded-lg font-bold border border-indigo-100 uppercase">
                                    {{ $category->name }}
                                </span>
                            @empty
                                <span class="text-gray-400 italic text-sm">Belum ada kategori terpilih</span>
                            @endforelse
                        </div>
                    </div>

                    <div class="pt-8 border-t border-gray-100">
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 block">Deskripsi Lengkap</label>
                        <p class="text-gray-600 leading-relaxed italic">
                            "{{ $product->description ?: 'Admin belum menambahkan deskripsi untuk produk ini.' }}"
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </main>

</body>
</html>