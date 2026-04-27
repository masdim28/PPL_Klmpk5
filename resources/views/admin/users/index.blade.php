@extends('layouts.admin')

@section('content')
    {{-- Header Content --}}
    <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-4xl font-black text-indigo-950 tracking-tighter uppercase italic">Kelola Pelanggan</h1>
            <p class="text-indigo-400 font-medium italic mt-1">
                Daftar pelanggan berdasarkan tingkat <span class="text-[#CFB53B] font-black underline">loyalitas belanja</span>.
            </p>
        </div>
        
        <div class="flex gap-4">
            <div class="bg-white px-6 py-4 rounded-[1.5rem] border border-indigo-50 shadow-sm flex items-center gap-4">
                <div class="bg-[#F1FBFD] p-3 rounded-xl text-2xl">👥</div>
                <div>
                    <p class="text-[10px] font-black text-indigo-300 uppercase tracking-widest leading-none">Total User</p>
                    <p class="text-xl font-black text-indigo-950">{{ $users->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="bg-white rounded-[2.5rem] shadow-[0_30px_60px_rgba(0,0,0,0.02)] border border-white overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-indigo-50/50 text-indigo-900 uppercase text-[10px] font-black tracking-[0.2em]">
                        <th class="px-8 py-6 text-center">Peringkat</th>
                        <th class="px-8 py-6">Profil Pelanggan</th>
                        <th class="px-8 py-6">Informasi Kontak</th>
                        <th class="px-8 py-6 text-center">Produk Dibeli</th>
                        <th class="px-8 py-6">Member Sejak</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($users as $index => $user)
                    <tr class="hover:bg-[#F1FBFD]/50 transition-colors group">
                        <td class="px-8 py-6">
                            <div class="flex justify-center">
                                @if($index == 0 && $user->total_checkout > 0)
                                    <div class="bg-yellow-50 text-yellow-600 px-4 py-2 rounded-2xl border border-yellow-100 flex items-center gap-2 shadow-sm">
                                        <span class="text-lg">🥇</span>
                                        <span class="font-black text-xs uppercase italic">TOP 1</span>
                                    </div>
                                @elseif($index == 1 && $user->total_checkout > 0)
                                    <div class="bg-slate-50 text-slate-500 px-4 py-2 rounded-2xl border border-slate-100 flex items-center gap-2 shadow-sm">
                                        <span class="text-lg">🥈</span>
                                        <span class="font-black text-xs uppercase italic">TOP 2</span>
                                    </div>
                                @elseif($index == 2 && $user->total_checkout > 0)
                                    <div class="bg-orange-50 text-orange-600 px-4 py-2 rounded-2xl border border-orange-100 flex items-center gap-2 shadow-sm">
                                        <span class="text-lg">🥉</span>
                                        <span class="font-black text-xs uppercase italic">TOP 3</span>
                                    </div>
                                @else
                                    <span class="text-indigo-200 font-black italic text-lg group-hover:text-indigo-400 transition-colors">
                                        #{{ $index + 1 }}
                                    </span>
                                @endif
                            </div>
                        </td>

                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-500 font-black text-xs uppercase">
                                    {{ substr($user->name, 0, 2) }}
                                </div>
                                <div>
                                    <p class="font-black text-indigo-950 uppercase tracking-tighter">{{ $user->name }}</p>
                                    <p class="text-[10px] text-indigo-300 font-bold uppercase">Customer</p>
                                </div>
                            </div>
                        </td>

                        <td class="px-8 py-6">
                            <span class="text-sm font-medium text-indigo-900 shadow-inner px-3 py-1 bg-gray-50 rounded-lg">
                                {{ $user->email }}
                            </span>
                        </td>

                        <td class="px-8 py-6 text-center">
                            <span class="bg-white border-2 border-[#F1FBFD] group-hover:border-[#CFB53B] text-indigo-950 px-5 py-2 rounded-2xl font-black text-xs transition-all shadow-sm inline-block">
                                {{ $user->total_checkout }} <span class="text-[#CFB53B] italic uppercase text-[10px]">Items</span>
                            </span>
                        </td>

                        <td class="px-8 py-6">
                            <div class="flex flex-col">
                                <span class="text-xs font-black text-indigo-900 uppercase tracking-tighter">{{ $user->created_at->format('d M Y') }}</span>
                                <span class="text-[9px] text-indigo-300 font-bold uppercase italic">{{ $user->created_at->diffForHumans() }}</span>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection