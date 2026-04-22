<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Koleksi | Admin Ade Afwa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <style>
        /* Penyesuaian agar senada dengan UI Anda */
        .ts-control { border-radius: 0.75rem !important; padding: 0.75rem !important; border-color: #e5e7eb !important; }
        .ts-control .item { background-color: #4338ca !important; color: white !important; border-radius: 0.5rem !important; }
    </style>
</head>
<body class="bg-gray-100 flex">

    <aside class="w-64 bg-indigo-900 min-h-screen text-white p-6 hidden md:block">
        <h2 class="text-2xl font-bold mb-10 tracking-widest italic text-center">ADE AFWA</h2>
        <nav class="space-y-4">
            <a href="{{ route('admin.dashboard') }}" class="block py-2.5 px-4 rounded hover:bg-indigo-800 transition">Dashboard</a>
            <a href="{{ route('admin.products.index') }}" class="block py-2.5 px-4 rounded bg-indigo-800 shadow-lg transition">Kelola Produk</a>
        </nav>
    </aside>

    <main class="flex-1 p-8">
        <div class="max-w-3xl mx-auto">
            <div class="mb-10">
                <h1 class="text-3xl font-bold text-gray-800">Tambah Produk Baru</h1>
                <p class="text-gray-500">Isi data di bawah ini untuk menambah katalog butik.</p>
            </div>

            @if ($errors->any())
                <div class="bg-red-500 text-white p-4 rounded-xl mb-6 shadow-lg">
                    <strong class="block mb-2 font-bold text-lg">Gagal Menyimpan:</strong>
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-sm p-8 border border-gray-100">
                <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Nama Produk</label>
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="Misal: Gamis Silk" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none" required>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Harga (Tanpa Titik)</label>
                            <input type="number" name="price" value="{{ old('price') }}" placeholder="Contoh: 250000" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Stok</label>
                            <input type="number" name="stock" value="{{ old('stock') }}" placeholder="10" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Kategori (Bisa pilih 2-3)</label>
                            <select id="category-select" name="category_ids[]" multiple placeholder="Pilih kategori..." class="w-full" required autocomplete="off">
                                @foreach($categories as $parent)
                                    <option value="{{ $parent->id }}" {{ (collect(old('category_ids'))->contains($parent->id)) ? 'selected' : '' }}>
                                        📂 {{ strtoupper($parent->name) }} (Utama)
                                    </option>
                                    @foreach($parent->children as $child)
                                        <option value="{{ $child->id }}" {{ (collect(old('category_ids'))->contains($child->id)) ? 'selected' : '' }}>
                                            └─ {{ $child->name }}
                                        </option>
                                    @endforeach
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Status</label>
                            <select name="status" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none">
                                <option value="ready" {{ old('status') == 'ready' ? 'selected' : '' }}>Ready</option>
                                <option value="sold_out" {{ old('status') == 'sold_out' ? 'selected' : '' }}>Sold Out</option>
                            </select>
                        </div>
                    </div>

                    <div>
    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Unggah Galeri Foto (Pilih 1-5 Foto)</label>
    <div class="p-6 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
        <input type="file" name="images[]" multiple 
               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-indigo-100 file:text-indigo-700 hover:file:bg-indigo-200 cursor-pointer">
        <p class="mt-2 text-[10px] text-gray-400 italic">* Tahan tombol 'Ctrl' (Windows) untuk memilih lebih dari satu foto.</p>
    </div>
</div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Deskripsi</label>
                        <textarea name="description" rows="3" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none">{{ old('description') }}</textarea>
                    </div>

                    <div class="pt-4 flex gap-4">
                        <button type="submit" class="flex-1 bg-indigo-900 text-white py-3 rounded-xl font-bold hover:bg-indigo-800 shadow-lg transition">Simpan Produk</button>
                        <a href="{{ route('admin.products.index') }}" class="px-6 py-3 bg-gray-100 text-gray-600 rounded-xl font-bold text-center">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    <script>
        new TomSelect("#category-select", {
            maxItems: 3, // Batasi maksimal 3 kategori agar tidak berlebihan
            plugins: ['remove_button'], // Tombol 'x' untuk menghapus pilihan
            persist: false,
            create: false,
        });
    </script>
</body>
</html>