@extends('layouts.admin')

@section('content')
    <div class="max-w-7xl mx-auto">
        {{-- Header & Warning Indicator --}}
        <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h1 class="text-4xl font-black text-indigo-950 tracking-tighter uppercase italic leading-none">Transaksi Pending</h1>
                <p class="text-indigo-400 font-medium italic mt-2">
                    Segera verifikasi bukti pembayaran agar pesanan koleksi butik bisa diproses ke tahap pengemasan.
                </p>
            </div>
            
            <div class="flex items-center gap-4 bg-white px-8 py-4 rounded-[1.5rem] border border-amber-100 shadow-[0_10px_30px_rgba(251,191,36,0.05)]">
                <div class="relative flex h-3 w-3">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-amber-500"></span>
                </div>
                <span class="text-[10px] font-black text-amber-700 uppercase tracking-[0.2em]">
                    Status: <span class="text-amber-600">Menunggu Verifikasi</span>
                </span>
            </div>
        </div>

        {{-- Transactions Table Card --}}
        <div class="bg-white rounded-[2.5rem] shadow-[0_40px_80px_rgba(0,0,0,0.02)] border border-white overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-indigo-50/30 text-indigo-900 uppercase text-[10px] font-black tracking-[0.25em]">
                            <th class="px-10 py-8">Order ID</th>
                            <th class="px-10 py-8">Pelanggan</th>
                            <th class="px-10 py-8">Item Koleksi</th>
                            <th class="px-10 py-8">Total Tagihan</th>
                            <th class="px-10 py-8 text-center">Verifikasi Pembayaran</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($orders as $order)
                        <tr class="hover:bg-[#F1FBFD]/40 transition-colors group">
                            <td class="px-10 py-8">
                                <span class="font-black text-indigo-950 tracking-tighter text-lg group-hover:text-amber-600 transition-colors">#{{ $order->id }}</span>
                                <p class="text-[9px] text-indigo-300 font-bold uppercase tracking-widest mt-1 italic">UID-{{ str_pad($order->user_id, 4, '0', STR_PAD_LEFT) }}</p>
                            </td>

                            <td class="px-10 py-8">
                                <div class="flex flex-col">
                                    <span class="font-black text-indigo-900 uppercase tracking-tighter text-sm">
                                        {{ $order->user->name ?? 'User Anonim' }}
                                    </span>
                                    <span class="text-[10px] text-indigo-300 font-bold italic mt-0.5">{{ $order->user->email ?? '-' }}</span>
                                </div>
                            </td>

                            <td class="px-10 py-8">
                                <div class="space-y-1.5">
                                    @foreach($order->items as $item)
                                        <div class="flex items-center gap-2">
                                            <div class="h-1.5 w-1.5 rounded-full bg-indigo-200"></div>
                                            <span class="text-[11px] font-bold text-indigo-800 uppercase italic">
                                                {{ $item->product->name }} <span class="text-indigo-300 not-italic text-[9px] ml-1">({{ $item->qty }}x)</span>
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            </td>

                            <td class="px-10 py-8">
                                <span class="text-lg font-black text-[#CFB53B] tracking-tighter group-hover:scale-110 transition-transform inline-block">
                                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                </span>
                            </td>

                            <td class="px-10 py-8">
                                <div class="flex justify-center gap-3">
                                    <form action="{{ route('admin.orders.konfirmasi', $order->id) }}" method="POST">
                                        @csrf
                                        <button class="bg-indigo-950 text-white px-6 py-3 rounded-2xl text-[9px] font-black uppercase tracking-[0.15em] hover:bg-[#CFB53B] hover:text-indigo-950 transition-all active:scale-95 shadow-lg shadow-indigo-100/50">
                                            Konfirmasi Bayar
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.orders.batal', $order->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan transaksi ini?')">
                                        @csrf @method('DELETE')
                                        <button class="bg-white text-red-400 border border-red-50 px-6 py-3 rounded-2xl text-[9px] font-black uppercase tracking-[0.15em] hover:bg-red-50 hover:text-red-600 transition-all active:scale-95">
                                            Batalkan
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-10 py-32 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="text-5xl mb-6 opacity-10 font-black italic tracking-tighter text-indigo-950">NO INCOMING</div>
                                    <h3 class="text-lg font-black text-indigo-900 uppercase italic">Arus Kas Bersih</h3>
                                    <p class="text-indigo-300 font-bold uppercase tracking-widest text-[10px] mt-2">Tidak ada transaksi tertunda yang perlu diverifikasi.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Footer Brand --}}
        <footer class="mt-16 text-center">
            <div class="inline-block p-1 bg-gradient-to-r from-transparent via-indigo-50 to-transparent w-full h-px mb-6"></div>
            <p class="text-[9px] text-indigo-200 font-black uppercase tracking-[0.6em] italic">
                &copy; 2026 ADE AFWA BOUTIQUE 
            </p>
        </footer>
    </div>
@endsection