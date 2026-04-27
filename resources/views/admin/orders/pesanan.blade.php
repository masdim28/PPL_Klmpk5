@extends('layouts.admin')

@section('content')
    <div class="max-w-7xl mx-auto">
        {{-- Header & Status Indicator --}}
        <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h1 class="text-4xl font-black text-indigo-950 tracking-tighter uppercase italic leading-none">Pesanan Diproses</h1>
                <p class="text-indigo-400 font-medium italic mt-2">
                    Segera input nomor resi untuk pesanan yang sudah siap dikirim ke pelanggan.
                </p>
            </div>
            
            <div class="flex items-center gap-4 bg-white px-8 py-4 rounded-[1.5rem] border border-blue-50 shadow-[0_10px_30px_rgba(0,0,0,0.02)]">
                <div class="relative flex">
                    <div class="bg-blue-500 h-3 w-3 rounded-full animate-ping absolute opacity-75"></div>
                    <div class="bg-blue-600 h-3 w-3 rounded-full relative"></div>
                </div>
                <span class="text-[10px] font-black text-indigo-900 uppercase tracking-[0.2em]">
                    Logistik: <span class="text-blue-600">Siap Kirim</span>
                </span>
            </div>
        </div>

        {{-- Main Table Card --}}
        <div class="bg-white rounded-[2.5rem] shadow-[0_40px_80px_rgba(0,0,0,0.03)] border border-white overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-indigo-50/30 text-indigo-900 uppercase text-[10px] font-black tracking-[0.25em]">
                            <th class="px-10 py-8">ID Order</th>
                            <th class="px-10 py-8">Pelanggan</th>
                            <th class="px-10 py-8 text-center">Metode Bayar</th>
                            <th class="px-10 py-8 text-center">Shipping</th>
                            <th class="px-10 py-8">Input Nomor Resi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($orders as $order)
                        <tr class="hover:bg-[#F1FBFD]/40 transition-colors group">
                            <td class="px-10 py-8">
                                <span class="font-black text-indigo-950 tracking-tighter text-lg">#{{ $order->id }}</span>
                                <p class="text-[9px] text-indigo-300 font-bold mt-1 uppercase">{{ $order->created_at->format('d M Y') }}</p>
                            </td>

                            <td class="px-10 py-8">
                                <div class="flex flex-col">
                                    <span class="font-black text-indigo-900 uppercase tracking-tighter text-sm group-hover:text-indigo-600 transition-colors">
                                        {{ $order->user->name ?? 'Guest User' }}
                                    </span>
                                    <span class="text-[10px] text-indigo-300 font-bold uppercase italic mt-0.5">Verified Account</span>
                                </div>
                            </td>

                            <td class="px-10 py-8 text-center">
                                <span class="inline-block bg-indigo-50 text-indigo-600 px-4 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest border border-indigo-100 shadow-sm">
                                    {{ $order->payment_method }}
                                </span>
                            </td>

                            <td class="px-10 py-8 text-center">
                                <span class="inline-flex items-center px-4 py-2 {{ $order->status_shipping == 'processing' ? 'bg-amber-50 text-amber-600 border-amber-100' : 'bg-blue-50 text-blue-600 border-blue-100' }} border rounded-xl text-[9px] font-black uppercase tracking-widest shadow-sm">
                                    {{ $order->status_shipping }}
                                </span>
                            </td>

                            <td class="px-10 py-8">
                                <form action="{{ route('admin.orders.resi', $order->id) }}" method="POST" class="flex items-center gap-3">
                                    @csrf
                                    <div class="relative flex-1">
                                        <input type="text" name="resi" placeholder="JNE / J&T / SICEPAT" 
                                            class="w-full bg-[#F1FBFD] border-none rounded-2xl px-5 py-4 text-xs font-bold text-indigo-950 focus:ring-2 focus:ring-[#CFB53B] outline-none shadow-inner placeholder:text-indigo-200 placeholder:italic placeholder:text-[10px]" 
                                            required>
                                    </div>
                                    <button type="submit" 
                                        class="bg-indigo-950 text-white px-8 py-4 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] hover:bg-[#CFB53B] hover:text-indigo-950 transition-all shadow-xl active:scale-95 group-hover:shadow-indigo-100">
                                        Update
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-10 py-32 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-24 h-24 bg-indigo-50 rounded-full flex items-center justify-center mb-6 animate-bounce">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-indigo-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-black text-indigo-900 uppercase italic">Logistik Bersih</h3>
                                    <p class="text-indigo-300 font-bold uppercase tracking-widest text-[10px] mt-2">Semua pesanan saat ini sudah dikirim ke pelanggan.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <footer class="mt-16 text-center">
            <div class="inline-block p-1 bg-gradient-to-r from-transparent via-indigo-100 to-transparent w-full h-px mb-6"></div>
            <p class="text-[9px] text-indigo-200 font-black uppercase tracking-[0.6em] italic">
                &copy; 2026 ADE AFWA BOUTIQUE 
        </footer>
    </div>
@endsection