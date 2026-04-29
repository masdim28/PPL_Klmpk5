<x-app-layout>
    <div class="pt-6 pb-12 bg-[#F1FBFD] min-h-screen">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-8">
                <a href="/products" class="group flex items-center text-[#CFB53B] hover:text-gray-900 transition-colors uppercase text-[10px] font-bold tracking-[0.2em]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Koleksi
                </a>
            </div>

            <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
                <div class="grid grid-cols-1 md:grid-cols-2">
                    
                    {{-- Section Kiri: Gambar --}}
                    <div class="bg-gray-50 p-4">
                        <div class="relative group">
                            <img id="main-display-image" 
                                 src="{{ asset('storage/' . $product->image) }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-full h-full object-cover aspect-[3/4] rounded-xl shadow-sm transition-all duration-300">
                            
                            <div class="absolute top-6 left-6 bg-[#CFB53B] text-white px-4 py-1 text-[10px] font-bold uppercase tracking-widest shadow-sm">
                                Koleksi Eksklusif
                            </div>
                        </div>

                        <div class="flex gap-3 mt-4 overflow-x-auto pb-2 scrollbar-hide">
                            {{-- Thumbnail Foto Utama --}}
                            <div class="flex-shrink-0 cursor-pointer group" onclick="updateMainImage('{{ asset('storage/' . $product->image) }}')">
                                <img src="{{ asset('storage/' . $product->image) }}" 
                                     class="w-20 h-24 object-cover rounded-lg border-2 border-transparent group-hover:border-[#CFB53B] transition-all shadow-sm">
                            </div>
                            @foreach($product->images as $img)
                                <div class="flex-shrink-0 cursor-pointer group" onclick="updateMainImage('{{ asset('storage/' . $img->image_path) }}')">
                                    <img src="{{ asset('storage/' . $img->image_path) }}" 
                                         class="w-20 h-24 object-cover rounded-lg border-2 border-transparent group-hover:border-[#CFB53B] transition-all shadow-sm">
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Section Kanan: Detail --}}
                    <div class="p-8 md:p-14 flex flex-col justify-center">
                        <div class="mb-6">
                            <h1 class="text-4xl font-serif text-gray-800 mb-4 tracking-tight leading-tight capitalize">
                                {{ $product->name }}
                            </h1>
                            <p class="text-2xl font-light text-[#CFB53B]">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </p>
                        </div>

                        <div class="flex flex-wrap gap-2 mb-8">
                            @foreach($product->categories as $category)
                                <span class="text-[9px] font-bold uppercase tracking-widest bg-[#F1FBFD] text-[#CFB53B] px-3 py-1 border border-[#CFB53B]/10 rounded">
                                    {{ $category->name }}
                                </span>
                            @endforeach
                        </div>

                        <div class="border-t border-gray-100 pt-8">
                            <h3 class="text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400 mb-4">Deskripsi Produk</h3>
                            <p class="text-gray-600 leading-relaxed text-sm italic mb-8">
                                "{{ $product->description ?: 'Keanggunan eksklusif dari koleksi Ade Afwa Boutique.' }}"
                            </p>
                        </div>

                        {{-- Tombol Trigger Modal --}}
                        <div class="space-y-4">
                            @if($product->status == 'sold_out' || $product->stock <= 0)
                                <button type="button" class="w-full bg-gray-400 text-white py-5 rounded-sm font-bold text-xs uppercase tracking-[0.3em] cursor-not-allowed shadow-xl flex justify-center items-center gap-3" disabled>
                                    Stok Habis
                                </button>
                            @else
                                <button type="button" onclick="openCartModal()" class="w-full bg-gray-900 text-white py-5 rounded-sm font-bold text-xs uppercase tracking-[0.3em] hover:bg-[#CFB53B] transition-all duration-500 shadow-xl flex justify-center items-center gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 11-8 0v4M5 9h14l1 12H4L5 9z" />
                                    </svg>
                                    Tambah ke Keranjang
                                </button>
                            @endif
                            
                            <div class="flex items-center justify-center gap-3 text-[9px] text-gray-400 uppercase tracking-widest pt-6">
                                Jaminan Kualitas Ade Afwa Boutique
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- MODAL PILIH VARIAN --}}
    <div id="cartModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        {{-- Overlay --}}
        <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="closeCartModal()"></div>

        <div class="flex min-h-full items-end justify-center p-0 text-center sm:items-center sm:p-4">
            <div class="relative transform overflow-hidden rounded-t-[2rem] sm:rounded-2xl bg-white text-left shadow-2xl transition-all w-full sm:max-w-lg animate-slide-up">
                
                {{-- Header Modal --}}
                <div class="px-6 py-6 border-b border-gray-50 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-serif text-gray-800">Pilih Varian</h3>
                        <p class="text-[10px] text-gray-400 uppercase tracking-widest font-bold">Sesuaikan dengan keinginan Anda</p>
                    </div>
                    <button onclick="closeCartModal()" class="text-gray-400 hover:text-gray-600 p-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <form action="/cart/add/{{ $product->id }}" method="POST">
                    @csrf
                    <div class="px-6 py-8">
                        <div class="grid grid-cols-1 gap-4 max-h-[40vh] overflow-y-auto pr-2 custom-scrollbar">
                            @forelse($product->variants as $variant)
                                <label class="relative flex items-center justify-between p-4 border-2 border-gray-50 rounded-2xl cursor-pointer hover:border-[#CFB53B]/30 transition-all group has-[:checked]:border-[#CFB53B] has-[:checked]:bg-[#F1FBFD]">
                                    <input type="radio" name="product_variant_id" value="{{ $variant->id }}" class="sr-only" {{ $variant->stock <= 0 ? 'disabled' : '' }} required>
                                    
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 bg-white rounded-xl shadow-sm border border-gray-50 flex items-center justify-center font-bold text-xs text-gray-800">
                                            {{ $variant->size }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-800">{{ $variant->color }}</p>
                                            <p class="text-[10px] text-[#CFB53B] font-bold uppercase">Stok: {{ $variant->stock }} unit</p>
                                        </div>
                                    </div>

                                    <div class="w-6 h-6 rounded-full border-2 border-gray-100 flex items-center justify-center group-has-[:checked]:border-[#CFB53B] transition-all">
                                        <div class="w-3 h-3 rounded-full bg-[#CFB53B] scale-0 group-has-[:checked]:scale-100 transition-transform"></div>
                                    </div>

                                    @if($variant->stock <= 0)
                                        <div class="absolute inset-0 bg-white/70 backdrop-blur-[1px] flex items-center justify-center rounded-2xl cursor-not-allowed">
                                            <span class="text-[10px] font-black text-red-500 uppercase tracking-widest">Habis Terjual</span>
                                        </div>
                                    @endif
                                </label>
                            @empty
                                <div class="text-center py-8">
                                    <p class="text-sm text-gray-400 italic">Varian belum tersedia untuk produk ini.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div class="px-6 py-6 bg-gray-50 flex flex-col gap-3">
                        <button type="submit" class="w-full bg-gray-900 text-white py-4 rounded-xl font-bold text-xs uppercase tracking-[0.2em] hover:bg-[#CFB53B] transition-all shadow-lg">
                            Tambahkan Ke Keranjang
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
        
        @keyframes slide-up {
            from { transform: translateY(100%); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        .animate-slide-up { animation: slide-up 0.4s cubic-bezier(0.16, 1, 0.3, 1); }
    </style>

    <script>
        function updateMainImage(src) {
            const mainImg = document.getElementById('main-display-image');
            mainImg.style.opacity = '0';
            setTimeout(() => {
                mainImg.src = src;
                mainImg.style.opacity = '1';
            }, 200);
        }

        function openCartModal() {
            const modal = document.getElementById('cartModal');
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeCartModal() {
            const modal = document.getElementById('cartModal');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    </script>
</x-app-layout>