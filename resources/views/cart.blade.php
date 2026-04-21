<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - Ade Afwa Boutique</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-900 font-sans">
    
    <div class="max-w-4xl mx-auto px-4 py-12">
        <h2 class="text-3xl font-serif font-bold text-indigo-900 mb-8">Keranjang Belanja</h2>

        @if($cart && $cart->items->count())
            <form action="{{ route('checkout.index') }}" method="GET">
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    @foreach($cart->items as $item)
                        <div class="flex items-center p-6 border-b hover:bg-gray-50 transition">
                            <div class="mr-6">
                                <input type="checkbox" name="selected_items[]" value="{{ $item->id }}" 
                                    class="item-checkbox w-5 h-5 text-indigo-600 rounded border-gray-300 focus:ring-indigo-500 cursor-pointer"
                                    data-price="{{ $item->product->price * $item->qty }}">
                            </div>

                            <div class="flex-1 flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-16 h-16 object-cover rounded-lg">
                                    <div>
                                        <h4 class="font-bold text-gray-800">{{ $item->product->name }}</h4>
                                        <p class="text-sm text-gray-500 italic">Qty: {{ $item->qty }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-indigo-600">
                                        Rp {{ number_format($item->product->price * $item->qty, 0, ',', '.') }}
                                    </p>
                                    <p class="text-xs text-gray-400">@ Rp {{ number_format($item->product->price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8 bg-white p-6 rounded-xl shadow-md flex justify-between items-center">
                    <div class="flex flex-col">
                        <span class="text-sm text-gray-500">Total Belanja (Terpilih):</span>
                        <span class="text-2xl font-black text-indigo-900" id="live-total">Rp 0</span>
                    </div>
                    <div class="flex items-center space-x-6">
                        <a href="/" class="text-indigo-600 font-medium hover:underline">← Kembali Belanja</a>
                        <button type="submit" class="bg-indigo-900 text-white px-8 py-3 rounded-full font-bold hover:bg-indigo-800 transition shadow-lg">
                            Checkout Sekarang
                        </button>
                    </div>
                </div>
            </form>
        @else
            <div class="text-center py-20 bg-white rounded-xl shadow-sm">
                <p class="text-gray-500 mb-6">Keranjang kamu masih kosong nih.</p>
                <a href="/" class="bg-indigo-900 text-white px-6 py-2 rounded-full font-bold">Mulai Belanja</a>
            </div>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.item-checkbox');
            const totalDisplay = document.getElementById('live-total');

            function calculateTotal() {
                let total = 0;
                checkboxes.forEach(cb => {
                    if (cb.checked) {
                        total += parseInt(cb.getAttribute('data-price'));
                    }
                });
                // Update teks total dengan format rupiah
                totalDisplay.innerText = 'Rp ' + total.toLocaleString('id-ID');
            }

            // Jalankan fungsi setiap ada perubahan checkbox
            checkboxes.forEach(cb => {
                cb.addEventListener('change', calculateTotal);
            });

            // Jalankan sekali saat halaman dimuat (jika ada yang otomatis tercentang)
            calculateTotal();
        });
    </script>
</body>
</html>