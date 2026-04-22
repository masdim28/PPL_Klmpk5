<x-app-layout>
    <div class="py-12 bg-[#F1FBFD] min-h-screen">
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
                            @foreach($product->images as $img)
                                <div class="flex-shrink-0 cursor-pointer group" onclick="updateMainImage('{{ asset('storage/' . $img->image_path) }}')">
                                    <img src="{{ asset('storage/' . $img->image_path) }}" 
                                         class="w-20 h-24 object-cover rounded-lg border-2 border-transparent group-hover:border-[#CFB53B] transition-all shadow-sm"
                                         alt="Thumbnail {{ $product->name }}">
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="p-8 md:p-14 flex flex-col justify-center">
                        <div class="mb-8">
                            <h1 class="text-4xl font-serif text-gray-800 mb-4 tracking-tight leading-tight capitalize">
                                {{ $product->name }}
                            </h1>
                            <p class="text-2xl font-light text-[#CFB53B]">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </p>
                        </div>

                        <div class="flex flex-wrap gap-2 mb-6">
                            @foreach($product->categories as $category)
                                <span class="text-[9px] font-bold uppercase tracking-widest bg-[#F1FBFD] text-[#CFB53B] px-3 py-1 border border-[#CFB53B]/10 rounded">
                                    {{ $category->name }}
                                </span>
                            @endforeach
                        </div>

                        <div class="border-t border-gray-100 pt-8 mb-8">
                            <h3 class="text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400 mb-4">Deskripsi Produk</h3>
                            <p class="text-gray-600 leading-relaxed text-sm italic">
                                "{{ $product->description }}"
                            </p>
                        </div>

                        <div class="flex items-center gap-4 mb-10">
                            <div class="bg-[#F1FBFD] border border-[#CFB53B]/20 px-5 py-3 rounded-lg">
                                <span class="text-[9px] text-[#CFB53B] uppercase block font-bold tracking-widest mb-1">Status Ketersediaan</span>
                                <span class="text-gray-800 font-bold flex items-center gap-2">
                                    <span class="h-2 w-2 rounded-full bg-green-500 animate-pulse"></span>
                                    {{ $product->stock }} Item Tersedia
                                </span>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <form action="/cart/add/{{ $product->id }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full bg-gray-900 text-white py-5 rounded-sm font-bold text-xs uppercase tracking-[0.3em] hover:bg-[#CFB53B] transition-all duration-500 shadow-xl flex justify-center items-center gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 11-8 0v4M5 9h14l1 12H4L5 9z" />
                                    </svg>
                                    Tambah ke Keranjang
                                </button>
                            </form>
                            
                            <div class="flex items-center justify-center gap-3 text-[9px] text-gray-400 uppercase tracking-widest pt-6 border-t border-gray-50">
                                <svg class="w-4 h-4 text-[#CFB53B]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                                Jaminan Kualitas Ade Afwa Boutique
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        function updateMainImage(src) {
            const mainImg = document.getElementById('main-display-image');
            mainImg.style.opacity = '0';
            setTimeout(() => {
                mainImg.src = src;
                mainImg.style.opacity = '1';
            }, 200);
        }
    </script>
</x-app-layout>