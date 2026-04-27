<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - Ade Afwa Boutique</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#F1FBFD] text-gray-900 font-sans min-h-screen">
    
    <div class="max-w-4xl mx-auto px-4 py-12">
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
            <h2 class="text-2xl font-serif font-bold text-gray-800 uppercase tracking-tight">Keranjang Belanja</h2>
        </div>

        @if($cart && $cart->items->count())
            <form action="{{ route('checkout.index') }}" method="GET" id="cart-form">
                <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
                    @foreach($cart->items as $item)
                        @php $isSoldOut = $item->product->status == 'sold_out'; @endphp
                        
                        <div class="flex items-center p-6 border-b border-gray-50 {{ $isSoldOut ? 'bg-gray-50 opacity-75' : 'hover:bg-[#F1FBFD]/50' }} transition duration-300">
                            <div class="mr-6">
                                {{-- Checkbox dimatikan jika barang sold out --}}
                                <input type="checkbox" name="selected_items[]" value="{{ $item->id }}" 
                                    class="item-checkbox w-5 h-5 text-[#CFB53B] rounded border-gray-300 focus:ring-[#CFB53B] {{ $isSoldOut ? 'cursor-not-allowed' : 'cursor-pointer' }}"
                                    data-price="{{ $item->product->price * $item->qty }}"
                                    {{ $isSoldOut ? 'disabled' : '' }}>
                            </div>

                            <div class="flex-1 flex flex-col md:flex-row md:items-center justify-between gap-4">
                                <div class="flex items-center space-x-4">
                                    <div class="relative">
                                        <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-20 h-20 object-cover rounded-xl shadow-sm {{ $isSoldOut ? 'grayscale' : '' }}">
                                        @if($isSoldOut)
                                            <div class="absolute inset-0 bg-black/40 rounded-xl flex items-center justify-center">
                                                <span class="text-[8px] text-white font-bold uppercase tracking-tighter">Habis</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-800 text-lg capitalize tracking-tight">{{ $item->product->name }}</h4>
                                        
                                        @if($isSoldOut)
                                            <p class="text-[10px] text-red-500 font-bold uppercase tracking-widest mt-1 animate-pulse">
                                                Maaf, Produk Ini Baru Saja Habis
                                            </p>
                                        @else
                                            <p class="text-[10px] text-[#CFB53B] font-bold uppercase tracking-widest mt-1 px-2 py-0.5 bg-[#F1FBFD] inline-block rounded">
                                                Qty: {{ $item->qty }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-serif text-xl font-bold {{ $isSoldOut ? 'text-gray-400 line-through' : 'text-gray-800' }}">
                                        Rp {{ number_format($item->product->price * $item->qty, 0, ',', '.') }}
                                    </p>
                                    @if(!$isSoldOut)
                                        <p class="text-[10px] text-gray-400 uppercase tracking-widest mt-1">@ Rp {{ number_format($item->product->price, 0, ',', '.') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8 bg-white p-8 rounded-2xl shadow-lg border border-[#CFB53B]/10 flex flex-col md:flex-row justify-between items-center gap-6">
                    <div class="flex flex-col items-center md:items-start">
                        <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400">Total Belanja (Terpilih)</span>
                        <span class="text-3xl font-serif font-bold text-[#CFB53B]" id="live-total">Rp 0</span>
                    </div>
                    <div class="flex flex-col md:flex-row items-center gap-6 w-full md:w-auto">
                        <a href="/" class="group flex items-center text-gray-400 hover:text-gray-800 transition-colors uppercase text-[10px] font-bold tracking-[0.2em]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Kembali Belanja
                        </a>
                        <button type="submit" id="checkout-btn" class="w-full md:w-auto bg-gray-900 text-white px-10 py-4 rounded-sm font-bold text-xs uppercase tracking-[0.3em] hover:bg-[#CFB53B] transition-all duration-500 shadow-xl disabled:bg-gray-300 disabled:cursor-not-allowed">
                            Checkout Sekarang
                        </button>
                    </div>
                </div>
            </form>
        @else
            {{-- Bagian Keranjang Kosong Tetap Sama --}}
            <div class="text-center py-24 bg-white rounded-2xl shadow-sm border border-dashed border-gray-200">
                <div class="bg-[#F1FBFD] w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="h-10 w-10 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 11V7a4 4 0 11-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
                <p class="text-gray-400 font-serif italic mb-8 text-lg">Keranjang belanja Anda masih kosong.</p>
                <a href="/" class="inline-block bg-gray-900 text-white px-8 py-3 rounded-sm font-bold text-xs uppercase tracking-[0.2em] hover:bg-[#CFB53B] transition-all duration-500">
                    Mulai Belanja
                </a>
            </div>
        @endif
        
        <div class="mt-12 text-center border-t border-gray-100 pt-8">
            <p class="text-[9px] text-gray-400 uppercase tracking-[0.3em]">&copy; 2026 Ade Afwa Boutique - Luxury & Elegance</p>
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
                
                // Disable button jika tidak ada item yang terpilih
                if (checkedCount === 0) {
                    checkoutBtn.disabled = true;
                    checkoutBtn.classList.add('opacity-50');
                } else {
                    checkoutBtn.disabled = false;
                    checkoutBtn.classList.remove('opacity-50');
                }
            }

            checkboxes.forEach(cb => {
                cb.addEventListener('change', calculateTotal);
            });

            calculateTotal();
        });
    </script>
</body>
</html>