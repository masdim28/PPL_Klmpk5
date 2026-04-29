@extends('layouts.admin')

@section('content')
    {{-- TomSelect CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <style>
        .ts-control { border-radius: 1.25rem !important; padding: 1rem 1.5rem !important; border: none !important; background-color: #F1FBFD !important; box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.03) !important; }
        .ts-control .item { background-color: #CFB53B !important; color: #1e1b4b !important; border-radius: 0.75rem !important; font-weight: 800; font-size: 10px; text-transform: uppercase; padding: 4px 12px !important; }
        .ts-dropdown { border-radius: 1.25rem !important; border: 1px solid #e0e7ff !important; box-shadow: 0 20px 40px -5px rgba(0, 0, 0, 0.05) !important; margin-top: 8px !important; }
        .ts-dropdown .active { background-color: #F1FBFD !important; color: #4338ca !important; }
        
        /* Custom Style for Variant Rows */
        .variant-row { transition: all 0.3s ease; }
        .variant-row:hover { background-color: #f8fafc; }
    </style>

    <div class="max-w-4xl mx-auto">
        {{-- Header --}}
        <div class="mb-10">
            <h1 class="text-4xl font-black text-indigo-950 tracking-tighter uppercase italic">Tambah Produk Baru</h1>
            <p class="text-indigo-400 font-medium italic mt-1">Lengkapi detail di bawah untuk menambah katalog eksklusif butik.</p>
        </div>

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-6 rounded-2xl mb-8 shadow-sm">
                <div class="flex items-center gap-3 mb-2">
                    <span class="text-red-500 font-black text-lg">⚠️</span>
                    <p class="font-black text-red-800 uppercase tracking-widest text-xs">Gagal Menyimpan Data:</p>
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
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                
                {{-- Product Name --}}
                <div>
                    <label class="block text-[10px] font-black text-indigo-300 uppercase tracking-[0.2em] mb-3 ml-2">Nama Koleksi Eksklusif</label>
                    <input type="text" name="name" value="{{ old('name') }}" 
                           placeholder="Contoh: Gamis Silk Premium" 
                           class="w-full px-6 py-5 rounded-2xl bg-[#F1FBFD]/50 border-none focus:ring-2 focus:ring-[#CFB53B] outline-none text-indigo-950 font-bold shadow-inner transition-all" required>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    {{-- Price --}}
                    <div>
                        <label class="block text-[10px] font-black text-indigo-300 uppercase tracking-[0.2em] mb-3 ml-2">Harga Jual (IDR)</label>
                        <input type="number" name="price" value="{{ old('price') }}" 
                               placeholder="250000" 
                               class="w-full px-6 py-5 rounded-2xl bg-[#F1FBFD]/50 border-none focus:ring-2 focus:ring-[#CFB53B] outline-none text-[#CFB53B] font-black text-xl shadow-inner" required>
                    </div>
                    {{-- General Stock (Total) --}}
                    <div>
                        <label class="block text-[10px] font-black text-indigo-300 uppercase tracking-[0.2em] mb-3 ml-2">Total Stok Keseluruhan</label>
                        <input type="number" name="stock" value="{{ old('stock') }}" 
                               placeholder="10" 
                               class="w-full px-6 py-5 rounded-2xl bg-[#F1FBFD]/50 border-none focus:ring-2 focus:ring-[#CFB53B] outline-none text-indigo-950 font-black text-xl shadow-inner" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    {{-- Categories --}}
                    <div>
                        <label class="block text-[10px] font-black text-indigo-300 uppercase tracking-[0.2em] mb-3 ml-2">Kategori (Maks. 3)</label>
                        <select id="category-select" name="category_ids[]" multiple placeholder="Pilih kategori..." class="w-full shadow-inner" required>
                            @foreach($categories as $parent)
                                <option value="{{ $parent->id }}" {{ (collect(old('category_ids'))->contains($parent->id)) ? 'selected' : '' }}>
                                    📂 {{ strtoupper($parent->name) }}
                                </option>
                                @foreach($parent->children as $child)
                                    <option value="{{ $child->id }}" {{ (collect(old('category_ids'))->contains($child->id)) ? 'selected' : '' }}>
                                        └─ {{ $child->name }}
                                    </option>
                                @endforeach
                            @endforeach
                        </select>
                    </div>
                    {{-- Status --}}
                    <div>
                        <label class="block text-[10px] font-black text-indigo-300 uppercase tracking-[0.2em] mb-3 ml-2">Status Stok</label>
                        <div class="relative">
                            <select name="status" class="w-full px-6 py-5 rounded-2xl bg-[#F1FBFD]/50 border-none focus:ring-2 focus:ring-[#CFB53B] outline-none text-indigo-950 font-black uppercase text-xs tracking-widest appearance-none shadow-inner cursor-pointer">
                                <option value="ready" {{ old('status') == 'ready' ? 'selected' : '' }}>🟢 Ready Stock</option>
                                <option value="sold_out" {{ old('status') == 'sold_out' ? 'selected' : '' }}>🔴 Sold Out</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- VARIANT SECTION --}}
                <div class="p-8 bg-gray-50 rounded-[2rem] border border-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <label class="block text-[10px] font-black text-indigo-400 uppercase tracking-[0.2em] ml-2">Manajemen Varian (Warna & Ukuran)</label>
                        <button type="button" onclick="addVariantRow()" class="bg-[#CFB53B] text-indigo-950 px-4 py-2 rounded-xl font-black text-[9px] uppercase tracking-wider hover:bg-indigo-950 hover:text-white transition-all">
                            + Tambah Varian
                        </button>
                    </div>

                    <div id="variant-container" class="space-y-4">
                        {{-- Row Varian Pertama (Default) --}}
                        <div class="variant-row grid grid-cols-12 gap-3 p-4 bg-white rounded-2xl shadow-sm items-center border border-transparent">
                            <div class="col-span-4">
                                <input type="text" name="variants[0][color]" placeholder="Warna (ex: Merah)" class="w-full px-4 py-3 rounded-xl bg-gray-50 border-none text-xs font-bold focus:ring-1 focus:ring-[#CFB53B]">
                            </div>
                            <div class="col-span-3">
                                <input type="text" name="variants[0][size]" placeholder="Ukuran (ex: XL)" class="w-full px-4 py-3 rounded-xl bg-gray-50 border-none text-xs font-bold focus:ring-1 focus:ring-[#CFB53B]">
                            </div>
                            <div class="col-span-3">
                                <input type="number" name="variants[0][stock]" placeholder="Stok" class="w-full px-4 py-3 rounded-xl bg-gray-50 border-none text-xs font-bold focus:ring-1 focus:ring-[#CFB53B]">
                            </div>
                            <div class="col-span-2 text-right">
                                <span class="text-gray-300 text-[10px] font-bold">Wajib</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Photo Upload --}}
                <div>
                    <label class="block text-[10px] font-black text-indigo-300 uppercase tracking-[0.2em] mb-3 ml-2">Unggah Galeri Foto (1-5 Foto)</label>
                    <div class="p-10 bg-[#F1FBFD]/30 rounded-[2.5rem] border-2 border-dashed border-indigo-100 flex flex-col items-center group hover:border-[#CFB53B] transition-colors">
                        <div class="mb-4 p-4 bg-white rounded-full shadow-sm text-indigo-200 group-hover:text-[#CFB53B] transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <input type="file" name="images[]" multiple 
                               class="block w-full text-xs text-indigo-300 file:mr-4 file:py-2 file:px-6 file:rounded-full file:border-0 file:text-[10px] file:font-black file:bg-[#CFB53B] file:text-indigo-950 hover:file:bg-[#b89f33] cursor-pointer">
                        <p class="mt-4 text-[9px] text-indigo-300 italic font-medium uppercase tracking-widest">Tahan 'Ctrl' untuk memilih banyak foto sekaligus</p>
                    </div>
                </div>

                {{-- Description --}}
                <div>
                    <label class="block text-[10px] font-black text-indigo-300 uppercase tracking-[0.2em] mb-3 ml-2">Deskripsi Produk</label>
                    <textarea name="description" rows="4" 
                              class="w-full px-6 py-5 rounded-2xl bg-[#F1FBFD]/50 border-none focus:ring-2 focus:ring-[#CFB53B] outline-none text-indigo-900 font-medium italic shadow-inner transition-all" 
                              placeholder="Jelaskan keanggunan bahan dan detail desain produk ini...">{{ old('description') }}</textarea>
                </div>

                {{-- Action Buttons --}}
                <div class="pt-6 flex flex-col md:flex-row gap-4">
                    <button type="submit" class="flex-1 bg-indigo-950 text-white py-5 rounded-[1.5rem] font-black text-xs uppercase tracking-[0.3em] hover:bg-[#CFB53B] hover:text-indigo-950 shadow-2xl shadow-indigo-100 transition-all active:scale-95 transform">
                        Simpan Koleksi
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="px-10 py-5 bg-white text-indigo-300 rounded-[1.5rem] font-black text-xs uppercase tracking-[0.3em] text-center hover:bg-red-50 hover:text-red-400 transition-all border border-indigo-50">
                        Batal
                    </a>
                </div>
            </form>
        </div>
        
        <p class="text-center mt-10 text-[10px] font-black text-indigo-200 uppercase tracking-[0.5em]">Umimasta Project • Informatics 2388010027</p>
    </div>

    {{-- TomSelect JS --}}
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Initialize TomSelect
            new TomSelect("#category-select", {
                maxItems: 3,
                plugins: ['remove_button'],
                persist: false,
                create: false,
                render: {
                    option: function(data, escape) {
                        return '<div class="px-4 py-2 font-bold text-xs uppercase tracking-tight">' + escape(data.text) + '</div>';
                    },
                    item: function(data, escape) {
                        return '<div class="flex items-center">' + escape(data.text) + '</div>';
                    }
                }
            });
        });

        // Dynamic Variant Management
        let variantIdx = 1;
        function addVariantRow() {
            const container = document.getElementById('variant-container');
            const newRow = document.createElement('div');
            newRow.className = 'variant-row grid grid-cols-12 gap-3 p-4 bg-white rounded-2xl shadow-sm items-center border border-indigo-50';
            newRow.innerHTML = `
                <div class="col-span-4">
                    <input type="text" name="variants[${variantIdx}][color]" placeholder="Warna" class="w-full px-4 py-3 rounded-xl bg-gray-50 border-none text-xs font-bold focus:ring-1 focus:ring-[#CFB53B]">
                </div>
                <div class="col-span-3">
                    <input type="text" name="variants[${variantIdx}][size]" placeholder="Ukuran" class="w-full px-4 py-3 rounded-xl bg-gray-50 border-none text-xs font-bold focus:ring-1 focus:ring-[#CFB53B]">
                </div>
                <div class="col-span-3">
                    <input type="number" name="variants[${variantIdx}][stock]" placeholder="Stok" class="w-full px-4 py-3 rounded-xl bg-gray-50 border-none text-xs font-bold focus:ring-1 focus:ring-[#CFB53B]">
                </div>
                <div class="col-span-2 text-right">
                    <button type="button" onclick="this.parentElement.parentElement.remove()" class="text-red-400 hover:text-red-600 font-black text-[10px] uppercase">Hapus</button>
                </div>
            `;
            container.appendChild(newRow);
            variantIdx++;
        }
    </script>
@endsection