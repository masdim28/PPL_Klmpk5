@extends('layouts.admin')

@section('content')
    <div class="max-w-4xl mx-auto">
        {{-- Header Section --}}
        <div class="mb-10 flex items-center justify-between">
            <div>
                <h1 class="text-4xl font-black text-indigo-950 tracking-tighter uppercase italic">Perbarui Koleksi</h1>
                <p class="text-indigo-400 font-medium italic mt-1">
                    Sedang mengubah: <span class="text-indigo-900 font-black underline decoration-[#CFB53B] decoration-2">{{ $product->name }}</span>
                </p>
            </div>
            <a href="{{ route('admin.products.index') }}" class="bg-white p-3 rounded-2xl border border-indigo-50 shadow-sm text-gray-400 hover:text-red-500 transition-all hover:rotate-90 group">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </a>
        </div>

        {{-- Error Handling --}}
        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-6 rounded-2xl mb-8 shadow-sm">
                <div class="flex items-center gap-3 mb-2">
                    <span class="text-red-500 font-black text-lg">⚠️</span>
                    <p class="font-black text-red-800 uppercase tracking-widest text-xs">Periksa Kembali Input Anda:</p>
                </div>
                <ul class="list-disc list-inside text-xs text-red-600/80 font-medium space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form Card --}}
        <div class="bg-white rounded-[2.5rem] shadow-[0_30px_60px_rgba(0,0,0,0.02)] p-10 border border-white">
            <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-10">
                @csrf
                @method('PUT')
                
                {{-- Product Name --}}
                <div>
                    <label class="block text-[10px] font-black text-indigo-300 uppercase tracking-[0.2em] mb-3 ml-2">Nama Koleksi Eksklusif</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" 
                           class="w-full px-6 py-5 rounded-2xl bg-[#F1FBFD]/50 border-none focus:ring-2 focus:ring-[#CFB53B] outline-none text-indigo-950 font-bold placeholder-indigo-200 shadow-inner transition-all" 
                           placeholder="Contoh: Gamis Silk Premium" required>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    {{-- Price --}}
                    <div>
                        <label class="block text-[10px] font-black text-indigo-300 uppercase tracking-[0.2em] mb-3 ml-2">Harga Jual (IDR)</label>
                        <input type="number" name="price" value="{{ old('price', $product->price) }}" 
                               class="w-full px-6 py-5 rounded-2xl bg-[#F1FBFD]/50 border-none focus:ring-2 focus:ring-[#CFB53B] outline-none text-[#CFB53B] font-black text-xl shadow-inner transition-all" required>
                    </div>
                    {{-- Stock --}}
                    <div>
                        <label class="block text-[10px] font-black text-indigo-300 uppercase tracking-[0.2em] mb-3 ml-2">Jumlah Stok</label>
                        <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" 
                               class="w-full px-6 py-5 rounded-2xl bg-[#F1FBFD]/50 border-none focus:ring-2 focus:ring-[#CFB53B] outline-none text-indigo-950 font-black text-xl shadow-inner transition-all" required>
                    </div>
                </div>

                {{-- Categories --}}
                <div>
                    <label class="block text-[10px] font-black text-indigo-300 uppercase tracking-[0.2em] mb-5 ml-2">Pilih Kategori Produk</label>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 p-8 bg-[#F1FBFD]/30 rounded-[2rem] border border-indigo-50">
                        @foreach($categories as $cat)
                            <label class="flex items-center space-x-3 cursor-pointer group">
                                <input type="checkbox" name="category_ids[]" value="{{ $cat->id }}" 
                                       class="w-5 h-5 rounded-lg border-indigo-100 text-[#CFB53B] focus:ring-[#CFB53B] transition cursor-pointer"
                                       {{ in_array($cat->id, $product->categories->pluck('id')->toArray()) ? 'checked' : '' }}>
                                <span class="text-xs text-indigo-900 group-hover:text-[#CFB53B] transition font-black uppercase tracking-tight">
                                    {{ $cat->name }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    {{-- Images --}}
                    <div>
                        <label class="block text-[10px] font-black text-indigo-300 uppercase tracking-[0.2em] mb-3 ml-2">Update Galeri Foto</label>
                        <div class="p-6 bg-[#F1FBFD]/30 rounded-[2rem] border border-dashed border-indigo-100">
                            <div class="flex flex-wrap gap-2 mb-4">
                                @foreach($product->images as $img)
                                    <div class="relative group">
                                        <img src="{{ asset('storage/' . $img->image_path) }}" class="w-12 h-12 object-cover rounded-xl shadow-sm border-2 border-white">
                                        <div class="absolute inset-0 bg-indigo-950/40 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                            <span class="text-[6px] text-white font-black uppercase">Stored</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <input type="file" name="images[]" multiple 
                                   class="block w-full text-[10px] text-indigo-300 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-black file:bg-[#CFB53B] file:text-indigo-950 hover:file:bg-[#b89f33] cursor-pointer">
                        </div>
                    </div>

                    {{-- Status --}}
                    <div>
                        <label class="block text-[10px] font-black text-indigo-300 uppercase tracking-[0.2em] mb-3 ml-2">Status Ketersediaan</label>
                        <div class="relative">
                            <select name="status" class="w-full px-6 py-5 rounded-2xl bg-[#F1FBFD]/50 border-none focus:ring-2 focus:ring-[#CFB53B] outline-none text-indigo-900 font-black uppercase text-xs tracking-widest appearance-none cursor-pointer shadow-inner">
                                <option value="ready" {{ $product->status == 'ready' ? 'selected' : '' }}>🟢 READY STOCK</option>
                                <option value="sold_out" {{ $product->status == 'sold_out' ? 'selected' : '' }}>🔴 SOLD OUT</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Description --}}
                <div>
                    <label class="block text-[10px] font-black text-indigo-300 uppercase tracking-[0.2em] mb-3 ml-2">Deskripsi Produk</label>
                    <textarea name="description" rows="5" 
                              class="w-full px-6 py-5 rounded-2xl bg-[#F1FBFD]/50 border-none focus:ring-2 focus:ring-[#CFB53B] outline-none text-indigo-900 font-medium italic shadow-inner transition-all" 
                              placeholder="Tuliskan keistimewaan bahan dan desain koleksi ini...">{{ old('description', $product->description) }}</textarea>
                </div>

                {{-- Actions --}}
                <div class="pt-6 flex flex-col md:flex-row gap-4">
                    <button type="submit" class="flex-1 bg-indigo-950 text-white py-5 rounded-[1.5rem] font-black text-xs uppercase tracking-[0.3em] hover:bg-[#CFB53B] hover:text-indigo-950 shadow-2xl shadow-indigo-100 transition-all active:scale-95 transform">
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="px-10 py-5 bg-white text-indigo-300 rounded-[1.5rem] font-black text-xs uppercase tracking-[0.3em] text-center hover:bg-red-50 hover:text-red-400 transition-all border border-indigo-50">
                        Batalkan
                    </a>
                </div>
            </form>
        </div>
        
        <p class="text-center mt-10 text-[10px] font-black text-indigo-200 uppercase tracking-[0.5em]">Ade Afwa Boutique</p>
    </div>
@endsection