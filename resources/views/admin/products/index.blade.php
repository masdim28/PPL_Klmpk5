<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Produk | Admin Ade Afwa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex">

    <aside class="w-64 bg-indigo-900 min-h-screen text-white p-6 hidden md:block">
        <h2 class="text-2xl font-bold mb-10 tracking-widest italic text-center">ADE AFWA</h2>
        <nav class="space-y-4">
    <a href="{{ route('admin.dashboard') }}" class="block py-2.5 px-4 rounded hover:bg-indigo-800 transition">Dashboard</a>
    
    <a href="{{ route('admin.products.index') }}" class="block py-2.5 px-4 rounded bg-indigo-800 shadow-lg transition">Kelola Produk</a>
    
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
            ← Lihat Website
        </a>
    </div>
</nav>
    </aside>

    <main class="flex-1 p-8">
        <div class="flex justify-between items-center mb-10">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Daftar Produk</h1>
                <p class="text-gray-500">Kelola stok dan koleksi butik kamu di sini.</p>
            </div>
            
            <a href="{{ route('admin.products.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl font-bold shadow-md transition flex items-center gap-2">
                <span>+</span> Tambah Produk Baru
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="p-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Gambar</th>
                        <th class="p-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Nama Produk</th>
                        <th class="p-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Kategori</th>
                        <th class="p-4 text-xs font-bold text-gray-400 uppercase tracking-widest text-center">Stok</th>
                        <th class="p-4 text-xs font-bold text-gray-400 uppercase tracking-widest text-right">Harga</th>
                        <th class="p-4 text-xs font-bold text-gray-400 uppercase tracking-widest text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($products as $p)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-4">
                            <img src="{{ asset('storage/' . $p->image) }}" class="w-20 h-20 object-cover rounded-lg border shadow-sm">
                        </td>
                        <td class="p-4">
                            <span class="font-bold text-gray-800">{{ $p->name }}</span>
                        </td>
                        <td class="p-4">
                            <span class="px-3 py-1 bg-gray-100 text-gray-600 text-xs rounded-full font-medium italic">{{ $p->category->name }}</span>
                        </td>
                        <td class="p-4 text-center">
                            <span class="font-mono {{ $p->stock < 5 ? 'text-red-500 font-bold' : 'text-gray-600' }}">
                                {{ $p->stock }}
                            </span>
                        </td>
                        <td class="p-4 text-right">
                            <span class="font-bold text-indigo-600">Rp {{ number_format($p->price, 0, ',', '.') }}</span>
                        </td>
                        <td class="p-4">
                            <div class="flex justify-center gap-3">
                                <a href="{{ route('admin.products.show', $p->id) }}" class="p-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition" title="Detail">
                                    Detail
                                </a>
                                <a href="{{ route('admin.products.edit', $p->id) }}" class="p-2 bg-amber-50 text-amber-600 rounded-lg hover:bg-amber-100 transition" title="Edit">
                                    Edit
                                </a>
                                <form action="{{ route('admin.products.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition" title="Hapus">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            @if($products->isEmpty())
            <div class="p-20 text-center">
                <p class="text-gray-400 italic">Belum ada produk yang ditambahkan.</p>
            </div>
            @endif
        </div>
    </main>

</body>
</html>