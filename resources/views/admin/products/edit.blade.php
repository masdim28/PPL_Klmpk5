<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk | Admin Ade Afwa</title>
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
        <div class="max-w-4xl mx-auto">
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Edit Produk</h1>
                    <p class="text-gray-500">Ubah detail koleksi: <span class="font-bold text-indigo-600">{{ $product->name }}</span></p>
                </div>
                <a href="{{ route('admin.products.index') }}" class="text-gray-400 hover:text-gray-600 font-medium">
                    &times; Batal & Tutup
                </a>
            </div>

            @if ($errors->any())
                <div class="bg-red-500 text-white p-4 rounded-2xl mb-6 shadow-lg">
                    <p class="font-bold mb-1">Terjadi kesalahan input:</p>
                    <ul class="list-disc list-inside text-sm opacity-90">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white rounded-3xl shadow-sm p-8 border border-gray-100">
                <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Nama Koleksi Produk</label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}" 
                               class="w-full px-5 py-4 rounded-2xl bg-gray-50 border-none focus:ring-2 focus:ring-indigo-500 outline-none text-gray-700 font-medium" 
                               placeholder="Contoh: Gamis Silk Premium" required>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Harga Jual (Rp)</label>
                            <input type="number" name="price" value="{{ old('price', $product->price) }}" 
                                   class="w-full px-5 py-4 rounded-2xl bg-gray-50 border-none focus:ring-2 focus:ring-indigo-500 outline-none text-gray-700 font-medium" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Jumlah Stok</label>
                            <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" 
                                   class="w-full px-5 py-4 rounded-2xl bg-gray-50 border-none focus:ring-2 focus:ring-indigo-500 outline-none text-gray-700 font-medium" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Pilih Kategori (Bisa lebih dari satu)</label>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 p-6 bg-gray-50 rounded-2xl border border-gray-100">
                            @foreach($categories as $cat)
                                <label class="flex items-center space-x-3 cursor-pointer group">
                                    <div class="relative flex items-center">
                                        <input type="checkbox" 
                                               name="category_ids[]" 
                                               value="{{ $cat->id }}" 
                                               class="w-5 h-5 rounded-lg border-gray-300 text-indigo-600 focus:ring-indigo-500 transition cursor-pointer"
                                               {{ in_array($cat->id, $product->categories->pluck('id')->toArray()) ? 'checked' : '' }}>
                                    </div>
                                    <span class="text-sm text-gray-600 group-hover:text-indigo-600 transition font-semibold uppercase tracking-tight">
                                        {{ $cat->name }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                        <p class="mt-3 text-xs text-gray-400 italic font-medium">* Centang kategori yang sesuai agar produk muncul di halaman terkait.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Update Foto Produk</label>
                            <div class="flex items-center space-x-6 p-4 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                                <img src="{{ asset('storage/' . $product->image) }}" class="w-20 h-20 object-cover rounded-xl shadow-sm border-2 border-white">
                                <input type="file" name="image" class="block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-indigo-100 file:text-indigo-700 hover:file:bg-indigo-200 cursor-pointer">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Status Ketersediaan</label>
                            <select name="status" class="w-full px-5 py-4 rounded-2xl bg-gray-50 border-none focus:ring-2 focus:ring-indigo-500 outline-none text-gray-700 font-bold appearance-none">
                                <option value="ready" {{ $product->status == 'ready' ? 'selected' : '' }}>🟢 READY STOCK</option>
                                <option value="sold_out" {{ $product->status == 'sold_out' ? 'selected' : '' }}>🔴 SOLD OUT</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Deskripsi Singkat</label>
                        <textarea name="description" rows="4" 
                                  class="w-full px-5 py-4 rounded-2xl bg-gray-50 border-none focus:ring-2 focus:ring-indigo-500 outline-none text-gray-600 leading-relaxed" 
                                  placeholder="Jelaskan detail bahan atau ukuran koleksi ini...">{{ old('description', $product->description) }}</textarea>
                    </div>

                    <div class="pt-6 flex flex-col md:flex-row gap-4">
                        <button type="submit" class="flex-1 bg-indigo-900 text-white py-4 rounded-2xl font-black text-sm uppercase tracking-widest hover:bg-indigo-800 shadow-xl shadow-indigo-100 transition-all active:scale-95">
                            Simpan Perubahan Data
                        </button>
                        <a href="{{ route('admin.products.index') }}" class="px-10 py-4 bg-gray-100 text-gray-400 rounded-2xl font-bold text-sm uppercase tracking-widest text-center hover:bg-gray-200 transition">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </main>

</body>
</html>