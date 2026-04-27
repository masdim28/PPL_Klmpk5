@extends('layouts.admin')

@section('content')
    <div class="max-w-7xl mx-auto">
        {{-- Header & Success Indicator --}}
        <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h1 class="text-4xl font-black text-indigo-950 tracking-tighter uppercase italic leading-none">Pesanan Selesai</h1>
                <p class="text-indigo-400 font-medium italic mt-2">
                    Daftar seluruh transaksi yang telah berhasil dikirim dan diterima oleh pelanggan.
                </p>
            </div>
            
            <div class="bg-emerald-50 px-8 py-4 rounded-[1.5rem] border border-emerald-100 shadow-[0_10px_30px_rgba(16,185,129,0.05)] flex items-center gap-4">
                <div class="bg-emerald-500 text-white w-8 h-8 rounded-full flex items-center justify-center text-xs shadow-lg shadow-emerald-200">
                    ✓
                </div>
                <span class="text-[10px] font-black text-emerald-700 uppercase tracking-[0.2em]">
                    Status: <span class="opacity-75">Completed</span>
                </span>
            </div>
        </div>

        {{-- Table Archive Card --}}
        <div class="bg-white rounded-[2.5rem] shadow-[0_40px_80px_rgba(0,0,0,0.02)] border border-white overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-indigo-50/30 text-indigo-900 uppercase text-[10px] font-black tracking-[0.25em]">
                            <th class="px-10 py-8">ID Order</th>
                            <th class="px-10 py-8">Pelanggan</th>
                            <th class="px-10 py-8 text-center">Total Pendapatan</th>
                            <th class="px-10 py-8">Informasi Resi</th>
                            <th class="px-10 py-8 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($orders as $order)
                        <tr class="hover:bg-emerald-50/20 transition-colors group">
                            <td class="px-10 py-8">
                                <span class="font-black text-indigo-950 tracking-tighter text-lg">#{{ $order->id }}</span>
                                <p class="text-[9px] text-indigo-300 font-bold mt-1 uppercase">{{ $order->created_at->format('d M Y • H:i') }}</p>
                            </td>

                            <td class="px-10 py-8">
                                <div class="flex flex-col">
                                    <span class="font-black text-indigo-900 uppercase tracking-tighter text-sm group-hover:text-emerald-600 transition-colors">
                                        {{ $order->user->name ?? 'Guest User' }}
                                    </span>
                                    <span class="text-[10px] text-indigo-300 font-bold italic mt-0.5">{{ $order->user->email ?? 'no-email@store.com' }}</span>
                                </div>
                            </td>

                            <td class="px-10 py-8 text-center">
                                <span class="text-lg font-black text-emerald-600 tracking-tighter">
                                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                </span>
                            </td>

                            <td class="px-10 py-8">
                                <div class="inline-flex items-center gap-3 bg-gray-50 px-4 py-2.5 rounded-xl border border-gray-100 shadow-inner group-hover:bg-white transition-colors">
                                    <span class="text-[9px] text-gray-400 font-black tracking-widest uppercase">No. Resi:</span>
                                    <span class="font-mono text-xs font-bold text-indigo-600">{{ $order->note ?? 'N/A' }}</span>
                                </div>
                            </td>

                            <td class="px-10 py-8 text-center">
                                <div class="flex justify-center">
                                    <span class="inline-block px-5 py-2.5 bg-emerald-500 text-white rounded-xl text-[9px] font-black uppercase tracking-[0.2em] shadow-lg shadow-emerald-100 transform group-hover:scale-105 transition-transform">
                                        Delivered
                                    </span>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-10 py-32 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="text-6xl mb-6 grayscale opacity-20 transform hover:grayscale-0 hover:opacity-100 transition-all duration-700 cursor-default">💎</div>
                                    <h3 class="text-xl font-black text-indigo-950 uppercase italic tracking-tighter">Belum Ada Riwayat</h3>
                                    <p class="text-indigo-300 font-bold uppercase tracking-widest text-[10px] mt-2">Daftar transaksi yang berhasil akan muncul secara otomatis di sini.</p>
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