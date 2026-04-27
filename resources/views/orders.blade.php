<x-app-layout>
    <x-slot name="header">
        Riwayat Pesanan Saya
    </x-slot>

    <div class="py-12 bg-[#F8FAFC] min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-8 px-4 sm:px-0">
                <h1 class="text-3xl font-black text-indigo-950 tracking-tighter uppercase italic">Pesanan Saya</h1>
                <p class="text-indigo-400 font-medium italic">Pantau status koleksi butik yang sedang menuju ke rumahmu.</p>
            </div>

            <div class="space-y-6">
                @forelse($orders as $order)
                <div class="bg-white rounded-[2rem] shadow-sm border border-indigo-50 overflow-hidden hover:shadow-md transition-shadow">
                    <div class="bg-indigo-50/50 px-8 py-4 flex flex-wrap justify-between items-center gap-4 border-b border-indigo-50">
                        <div class="flex items-center gap-4">
                            <span class="text-xs font-black text-indigo-300 uppercase tracking-[0.2em]">Order ID</span>
                            <span class="font-bold text-indigo-900">#{{ $order->id }}</span>
                            <span class="text-indigo-200 text-xs font-bold">{{ $order->created_at->format('d M Y') }}</span>
                        </div>
                        
                        <div>
                            @if($order->status_payment == 'pending')
                                <span class="bg-yellow-100 text-yellow-700 px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest border border-yellow-200">Menunggu Pembayaran</span>
                            @elseif($order->status_shipping == 'processing')
                                <span class="bg-blue-100 text-blue-700 px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest border border-blue-200">Sedang Diproses</span>
                            @elseif($order->status_shipping == 'shipped')
                                <span class="bg-indigo-600 text-white px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest shadow-lg shadow-indigo-100">Dalam Pengiriman</span>
                            @else
                                <span class="bg-emerald-100 text-emerald-700 px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest border border-emerald-200 text-center">Selesai</span>
                            @endif
                        </div>
                    </div>

                    <div class="p-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                            <div class="space-y-4">
                                @foreach($order->items as $item)
                                <div class="flex items-center gap-4">
                                    <div class="h-16 w-16 rounded-2xl bg-indigo-50 flex-shrink-0 overflow-hidden border border-indigo-100 p-1">
                                        <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="h-full w-full object-cover rounded-xl">
                                    </div>
                                    <div>
                                        <h4 class="font-black text-indigo-950 uppercase tracking-tighter">{{ $item->product->name }}</h4>
                                        <p class="text-xs text-indigo-400 font-bold uppercase italic">{{ $item->qty }} x <span class="text-indigo-900">Rp {{ number_format($item->price, 0, ',', '.') }}</span></p>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <div class="flex flex-col md:items-end gap-2">
                                <p class="text-[10px] font-black text-indigo-300 uppercase tracking-widest leading-none">Total Belanja</p>
                                <p class="text-2xl font-black text-[#CFB53B] tracking-tighter">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                                
                                @if($order->status_shipping == 'shipped' || $order->status_shipping == 'delivered')
                                <div class="mt-4 bg-[#F1FBFD] border border-blue-100 px-4 py-2 rounded-xl flex items-center gap-3">
                                    <span class="text-[10px] font-black text-blue-400 uppercase tracking-widest italic">Resi:</span>
                                    <span class="font-mono text-xs font-bold text-blue-700 uppercase">{{ $order->note ?? 'Menghubungi Kurir...' }}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-20 bg-white rounded-[2.5rem] border-2 border-dashed border-indigo-50">
                    <div class="text-6xl mb-6">🛍️</div>
                    <h3 class="text-xl font-black text-indigo-950 uppercase italic">Belum Ada Pesanan</h3>
                    <p class="text-indigo-300 mt-2 font-medium italic">Sepertinya kamu belum memilih koleksi butik terbaik kami.</p>
                    <a href="{{ route('products.index') }}" class="mt-8 inline-block bg-indigo-950 text-white px-8 py-3 rounded-xl text-[10px] font-black uppercase tracking-[0.2em] hover:bg-[#CFB53B] hover:text-indigo-950 transition-all shadow-xl">Mulai Belanja</a>
                </div>
                @endforelse
            </div>

            <footer class="mt-16 text-center">
                <p class="text-[9px] text-indigo-200 font-black uppercase tracking-[0.5em] italic">
                    &copy; 2026 ADE AFWA BOUTIQUE • USER SHOPPING EXPERIENCE
                </p>
            </footer>
        </div>
    </div>
</x-app-layout>