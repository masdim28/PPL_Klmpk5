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

        {{-- Validasi Error Alert --}}
        @if ($errors->any())
            <div class="mb-8 bg-red-50 border-l-4 border-red-500 p-4 rounded-xl shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-bold text-red-800 uppercase tracking-wider">Terjadi kesalahan input:</h3>
                        <ul class="mt-1 list-disc list-inside text-xs text-red-700 font-medium">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
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
                           class="w-full px-6 py-5 rounded-2xl bg-[#F1FBFD]/50 border-none focus:ring-2 focus:ring-[#CFB53B] outline-none text-indigo-950 font-bold shadow-inner transition-all" required>
                </div>

                {{-- Category Selection --}}
                <div class="pt-4">
                    <label class="block text-[10px] font-black text-indigo-300 uppercase tracking-[0.2em] mb-4 ml-2">Pilih Kategori Koleksi</label>
                    <div class="space-y-6">
                        @foreach($categories as $parent)
                            <div>
                                <h4 class="text-[9px] font-bold text-indigo-950 uppercase mb-3 ml-2 opacity-50">{{ $parent->name }}</h4>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                    {{-- Parent Category --}}
                                    <label class="relative group cursor-pointer">
                                        <input type="checkbox" name="category_ids[]" value="{{ $parent->id }}" 
                                            {{ $product->categories->contains($parent->id) ? 'checked' : '' }}
                                            class="peer hidden">
                                        <div class="p-4 rounded-2xl bg-[#F1FBFD]/50 border border-transparent peer-checked:border-[#CFB53B] peer-checked:bg-white peer-checked:shadow-md transition-all flex items-center justify-between group-hover:bg-white">
                                            <span class="text-[10px] font-black text-indigo-950 uppercase tracking-tighter">{{ $parent->name }}</span>
                                            <div class="w-4 h-4 rounded-full border-2 border-indigo-100 peer-checked:bg-[#CFB53B] peer-checked:border-[#CFB53B] flex items-center justify-center transition-all">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-2 w-2 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 13l4 4L19 7" /></svg>
                                            </div>
                                        </div>
                                    </label>

                                    {{-- Sub Categories --}}
                                    @foreach($parent->children as $child)
                                        <label class="relative group cursor-pointer">
                                            <input type="checkbox" name="category_ids[]" value="{{ $child->id }}" 
                                                {{ $product->categories->contains($child->id) ? 'checked' : '' }}
                                                class="peer hidden">
                                            <div class="p-4 rounded-2xl bg-[#F1FBFD]/30 border border-transparent peer-checked:border-[#CFB53B] peer-checked:bg-white peer-checked:shadow-md transition-all flex items-center justify-between group-hover:bg-white">
                                                <span class="text-[10px] font-bold text-indigo-800 uppercase tracking-tighter">{{ $child->name }}</span>
                                                <div class="w-4 h-4 rounded-full border-2 border-indigo-50 peer-checked:bg-[#CFB53B] peer-checked:border-[#CFB53B] flex items-center justify-center transition-all">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-2 w-2 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 13l4 4L19 7" /></svg>
                                                </div>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Variant Management Section --}}
                <div class="pt-4">
                    <div class="flex items-center justify-between mb-5 ml-2">
                        <label class="block text-[10px] font-black text-indigo-300 uppercase tracking-[0.2em]">Manajemen Varian (Warna & Ukuran)</label>
                        <button type="button" onclick="addVariant()" class="text-[9px] font-black bg-[#CFB53B] text-indigo-950 px-4 py-2 rounded-full uppercase tracking-wider hover:bg-indigo-950 hover:text-white transition-all">
                            + Tambah Varian Baru
                        </button>
                    </div>

                    <div id="variant-container" class="space-y-3">
                        @foreach($product->variants as $index => $variant)
                        <div class="variant-row grid grid-cols-12 gap-3 p-4 bg-[#F1FBFD]/30 rounded-2xl border border-indigo-50 items-end">
                            <input type="hidden" name="variants[{{ $index }}][id]" value="{{ $variant->id }}">
                            <div class="col-span-4">
                                <label class="text-[8px] font-bold text-indigo-300 uppercase ml-2 mb-1 block">Warna</label>
                                <input type="text" name="variants[{{ $index }}][color]" value="{{ old("variants.$index.color", $variant->color) }}" class="w-full px-4 py-3 rounded-xl bg-white border-none text-xs font-bold focus:ring-1 focus:ring-[#CFB53B] shadow-sm" placeholder="Sage Green" required>
                            </div>
                            <div class="col-span-3">
                                <label class="text-[8px] font-bold text-indigo-300 uppercase ml-2 mb-1 block">Ukuran</label>
                                <input type="text" name="variants[{{ $index }}][size]" value="{{ old("variants.$index.size", $variant->size) }}" class="w-full px-4 py-3 rounded-xl bg-white border-none text-xs font-bold focus:ring-1 focus:ring-[#CFB53B] shadow-sm" placeholder="XL / 42" required>
                            </div>
                            <div class="col-span-3">
                                <label class="text-[8px] font-bold text-indigo-300 uppercase ml-2 mb-1 block">Stok</label>
                                <input type="number" name="variants[{{ $index }}][stock]" value="{{ old("variants.$index.stock", $variant->stock) }}" class="w-full px-4 py-3 rounded-xl bg-white border-none text-xs font-bold focus:ring-1 focus:ring-[#CFB53B] shadow-sm" required>
                            </div>
                            <div class="col-span-2 text-right">
                                <button type="button" onclick="this.parentElement.parentElement.remove()" class="p-3 text-red-300 hover:text-red-500 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <div>
                        <label class="block text-[10px] font-black text-indigo-300 uppercase tracking-[0.2em] mb-3 ml-2">Harga Jual (IDR)</label>
                        <input type="number" name="price" value="{{ old('price', $product->price) }}" class="w-full px-6 py-5 rounded-2xl bg-[#F1FBFD]/50 border-none focus:ring-2 focus:ring-[#CFB53B] outline-none text-[#CFB53B] font-black text-xl shadow-inner" required>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-indigo-300 uppercase tracking-[0.2em] mb-3 ml-2">Stok Utama (Total)</label>
                        <input type="number" name="stock" id="total_stock" value="{{ old('stock', $product->stock) }}" class="w-full px-6 py-5 rounded-2xl bg-[#F1FBFD]/50 border-none focus:ring-2 focus:ring-[#CFB53B] outline-none text-indigo-950 font-black text-xl shadow-inner" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <div>
                        <label class="block text-[10px] font-black text-indigo-300 uppercase tracking-[0.2em] mb-3 ml-2">Status Ketersediaan</label>
                        <select name="status" class="w-full px-6 py-5 rounded-2xl bg-[#F1FBFD]/50 border-none focus:ring-2 focus:ring-[#CFB53B] outline-none text-indigo-900 font-black uppercase text-xs appearance-none shadow-inner">
                            <option value="ready" {{ $product->status == 'ready' ? 'selected' : '' }}>🟢 READY STOCK</option>
                            <option value="sold_out" {{ $product->status == 'sold_out' ? 'selected' : '' }}>🔴 SOLD OUT</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-indigo-300 uppercase tracking-[0.2em] mb-3 ml-2">Update Foto Utama</label>
                        <div class="flex items-center gap-4">
                            @if($product->image)
                                <img src="{{ asset('storage/'.$product->image) }}" class="w-16 h-16 object-cover rounded-xl border-2 border-indigo-50 shadow-sm" alt="current">
                            @endif
                            <input type="file" name="image" class="block w-full text-[10px] text-indigo-300 file:mr-4 file:py-3 file:px-6 file:rounded-full file:border-0 file:bg-indigo-50 file:text-indigo-950 hover:file:bg-indigo-100 cursor-pointer">
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-indigo-300 uppercase tracking-[0.2em] mb-3 ml-2">Deskripsi Produk</label>
                    <textarea name="description" rows="4" class="w-full px-6 py-5 rounded-2xl bg-[#F1FBFD]/50 border-none focus:ring-2 focus:ring-[#CFB53B] outline-none text-indigo-900 font-medium italic shadow-inner">{{ old('description', $product->description) }}</textarea>
                </div>

                <div class="pt-6 flex flex-col md:flex-row gap-4">
                    <button type="submit" class="flex-1 bg-indigo-950 text-white py-5 rounded-[1.5rem] font-black text-xs uppercase tracking-[0.3em] hover:bg-[#CFB53B] hover:text-indigo-950 shadow-2xl transition-all">
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="px-10 py-5 bg-white text-indigo-300 rounded-[1.5rem] font-black text-xs uppercase tracking-[0.3em] text-center hover:bg-red-50 border border-indigo-50">
                        Batalkan
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        let variantIndex = {{ $product->variants->count() }};
        function addVariant() {
            const container = document.getElementById('variant-container');
            const html = `
                <div class="variant-row grid grid-cols-12 gap-3 p-4 bg-[#F1FBFD]/30 rounded-2xl border border-indigo-50 items-end animate-fadeIn">
                    <div class="col-span-4"><label class="text-[8px] font-bold text-indigo-300 uppercase ml-2 mb-1 block">Warna</label><input type="text" name="variants[${variantIndex}][color]" class="w-full px-4 py-3 rounded-xl bg-white border-none text-xs font-bold shadow-sm" required></div>
                    <div class="col-span-3"><label class="text-[8px] font-bold text-indigo-300 uppercase ml-2 mb-1 block">Ukuran</label><input type="text" name="variants[${variantIndex}][size]" class="w-full px-4 py-3 rounded-xl bg-white border-none text-xs font-bold shadow-sm" required></div>
                    <div class="col-span-3"><label class="text-[8px] font-bold text-indigo-300 uppercase ml-2 mb-1 block">Stok</label><input type="number" name="variants[${variantIndex}][stock]" value="0" class="w-full px-4 py-3 rounded-xl bg-white border-none text-xs font-bold shadow-sm" required></div>
                    <div class="col-span-2 text-right"><button type="button" onclick="this.parentElement.parentElement.remove()" class="p-3 text-red-300 hover:text-red-500 transition-colors"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg></button></div>
                </div>`;
            container.insertAdjacentHTML('beforeend', html);
            variantIndex++;
        }
    </script>
@endsection