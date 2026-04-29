<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - Ade Afwa Boutique</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap');
        .font-serif { font-family: 'Playfair Display', serif; }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #CFB53B; border-radius: 10px; }
    </style>
</head>
<body class="bg-[#F1FBFD] text-gray-900 font-sans min-h-screen">
    
    <div class="max-w-4xl mx-auto px-4 py-12">
        {{-- Branding Section --}}
        <div class="text-center mb-12">
            <img src="{{ asset('images/logo_adeafwa.png') }}" alt="Logo Ade Afwa Boutique" class="h-24 mx-auto mb-4 object-contain">
            <div class="flex justify-center">
                <div class="h-0.5 w-16 bg-[#CFB53B]"></div>
            </div>
        </div>

        <div class="flex items-center gap-3 mb-8">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#CFB53B]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 11-8 0v4M5 9h14l1 12H4L5 9z" />
            </svg>
            <h2 class="text-2xl font-serif font-bold text-gray-800 uppercase tracking-tight">Tas Belanja</h2>
        </div>

        @if($cart && $cart->items->count())
            <form action="{{ route('checkout.index') }}" method="GET" id="cart-form">
                <div class="bg-white rounded-3xl shadow-sm overflow-hidden border border-gray-100">
                    @foreach($cart->items as $item)
                        {{-- Logika Cek Stok: Jika produk status sold_out ATAU stok varian habis --}}
                        @php 
                            $isSoldOut = $item->product->status == 'sold_out' || ($item->variant && $item->variant->stock <= 0); 
                        @endphp
                        
                        <div class="flex items-center p-6 md:p-8 border-b border-gray-50 {{ $isSoldOut ? 'bg-gray-50' : 'hover:bg-[#F1FBFD]/30' }} transition duration-300">
                            {{-- Checkbox Pemilihan --}}
                            <div class="mr-6">
                                <input type="checkbox" name="selected_items[]" value="{{ $item->id }}" 
                                    class="item-checkbox w-6 h-6 text-[#CFB53B] rounded-full border-gray-300 focus:ring-[#CFB53B] {{ $isSoldOut ? 'opacity-20 cursor-not-allowed' : 'cursor-pointer' }}"
                                    data-price="{{ $item->product->price * $item->qty }}"
                                    {{ $isSoldOut ? 'disabled' : '' }}>
                            </div>

                            <div class="flex-1 flex flex-col md:flex-row md:items-center justify-between gap-6">
                                <div class="flex items-center space-x-6">
                                    {{-- Thumbnail Produk --}}
                                    <div class="relative flex-shrink-0">
                                        <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-24 h-32 object-cover rounded-2xl shadow-sm {{ $isSoldOut ? 'grayscale' : '' }}">
                                        @if($isSoldOut)
                                            <div class="absolute inset-0 bg-black/40 rounded-2xl flex items-center justify-center">
                                                <span class="text-[10px] text-white font-black uppercase tracking-widest">Habis</span>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Info Produk & VARIAN --}}
                                    <div>
                                        <h4 class="font-bold text-gray-800 text-lg capitalize leading-tight mb-2">{{ $item->product->name }}</h4>
                                        
                                        {{-- DETAIL VARIAN YG DIPILIH --}}
                                        @if($item->variant)
                                            <div class="flex flex-wrap gap-2 mb-3">
                                                <span class="text-[10px] font-bold uppercase px-3 py-1 bg-[#F1FBFD] border border-[#CFB53B]/20 text-[#CFB53B] rounded-full shadow-sm">
                                                    Warna: {{ $item->variant->color }}
                                                </span>
                                                <span class="text-[10px] font-bold uppercase px-3 py-1 bg-white border border-gray-100 text-gray-400 rounded-full shadow-sm">
                                                    Size: {{ $item->variant->size }}
                                                </span>
                                            </div>
                                        @endif

                                        @if($isSoldOut)
                                            <p class="text-[10px] text-red-500 font-bold uppercase tracking-widest">Varian ini tidak lagi tersedia</p>
                                        @else
                                            <p class="text-[11px] text-gray-400 font-medium uppercase tracking-widest">
                                                Kuantitas: <span class="text-gray-800 font-bold">{{ $item->qty }}</span>
                                            </p>
                                        @endif
                                    </div>
                                </div>

                                {{-- Harga & Tombol Hapus --}}
                                <div class="text-right flex flex-col justify-between items-end">
                                    <div>
                                        <p class="font-serif text-2xl font-bold {{ $isSoldOut ? 'text-gray-300 line-through' : 'text-[#CFB53B]' }}">
                                            Rp {{ number_format($item->product->price * $item->qty, 0, ',', '.') }}
                                        </p>
                                        @if(!$isSoldOut)
                                            <p class="text-[10px] text-gray-400 uppercase tracking-widest mt-1 italic">@ Rp {{ number_format($item->product->price, 0, ',', '.') }}</p>
                                        @endif
                                    </div>

                                    <button type="button" onclick="removeItem('{{ $item->id }}')" class="mt-4 text-[10px] text-red-300 hover:text-red-600 uppercase font-black tracking-[0.2em] transition-all flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Hapus
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Checkout Bar --}}
                <div class="mt-10 bg-white p-8 md:p-10 rounded-[2.5rem] shadow-xl border border-[#CFB53B]/5 flex flex-col md:flex-row justify-between items-center gap-8">
                    <div class="text-center md:text-left">
                        <span class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-300 block mb-1">Total Yang Terpilih</span>
                        <span class="text-4xl font-serif font-black text-gray-800" id="live-total">Rp 0</span>
                    </div>
                    
                    <div class="flex flex-col md:flex-row items-center gap-8 w-full md:w-auto">
                        <a href="/products" class="text-gray-400 hover:text-gray-800 transition-colors uppercase text-[10px] font-black tracking-[0.3em]">
                            ← Belanja Lagi
                        </a>
                        <button type="submit" id="checkout-btn" class="w-full md:w-auto bg-gray-900 text-white px-12 py-5 rounded-full font-black text-xs uppercase tracking-[0.3em] hover:bg-[#CFB53B] transition-all duration-500 shadow-2xl disabled:bg-gray-100 disabled:text-gray-300 disabled:cursor-not-allowed">
                            Proses Checkout
                        </button>
                    </div>
                </div>
            </form>

            {{-- Form Hapus (Hidden) --}}
            <form id="delete-item-form" method="POST" class="hidden">
                @csrf
                @method('DELETE')
            </form>

        @else
            {{-- State Keranjang Kosong --}}
            <div class="text-center py-24 bg-white rounded-[3rem] shadow-sm border border-dashed border-gray-200">
                <div class="bg-[#F1FBFD] w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-8 shadow-inner">
                    <svg class="h-10 w-10 text-[#CFB53B]/30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 11-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
                <h3 class="text-xl font-serif italic text-gray-800 mb-2">Tas Belanja Anda Kosong</h3>
                <p class="text-gray-400 text-sm mb-10">Temukan koleksi eksklusif kami dan mulailah berbelanja.</p>
                <a href="/products" class="inline-block bg-gray-900 text-white px-12 py-4 rounded-full font-black text-xs uppercase tracking-[0.3em] hover:bg-[#CFB53B] transition-all duration-500 shadow-xl">
                    Jelajahi Koleksi
                </a>
            </div>
        @endif
        
        <div class="mt-20 text-center border-t border-gray-100 pt-10">
            <p class="text-[10px] text-gray-300 uppercase font-bold tracking-[0.4em] italic">Ade Afwa Boutique &copy; 2026</p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.item-checkbox:not(:disabled)');
            const totalDisplay = document.getElementById('live-total');
            const checkoutBtn = document.getElementById('checkout-btn');

            function calculateTotal() {
                let total = 0;
                let checkedCount = 0;

                checkboxes.forEach(cb => {
                    if (cb.checked) {
                        total += parseInt(cb.getAttribute('data-price'));
                        checkedCount++;
                    }
                });

                totalDisplay.innerText = 'Rp ' + total.toLocaleString('id-ID');
                
                // Aktifkan tombol jika ada yang dicentang
                if (checkedCount === 0) {
                    checkoutBtn.disabled = true;
                } else {
                    checkoutBtn.disabled = false;
                }
            }

            checkboxes.forEach(cb => {
                cb.addEventListener('change', calculateTotal);
            });

            calculateTotal();
        });

        function removeItem(itemId) {
            if (confirm('Hapus produk ini dari tas belanja Anda?')) {
                const form = document.getElementById('delete-item-form');
                form.action = '/cart/remove/' + itemId;
                form.submit();
            }
        }
    </script>
</body>
</html>