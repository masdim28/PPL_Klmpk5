@extends('layouts.admin')

@section('content')
    {{-- 1. Ringkasan Bisnis --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <div class="bg-white p-6 rounded-2xl shadow-sm border-b-4 border-emerald-400 hover:shadow-md transition">
            <p class="text-gray-400 text-xs font-bold uppercase tracking-wider">Produk Ready</p>
            <h3 class="text-3xl font-black text-gray-800 mt-1">{{ $readyStockCount }}</h3>
        </div>
        
        <div class="bg-white p-6 rounded-2xl shadow-sm border-b-4 border-red-400 hover:shadow-md transition">
            <p class="text-gray-400 text-xs font-bold uppercase tracking-wider">Sold Out</p>
            <h3 class="text-3xl font-black text-gray-800 mt-1">{{ $soldOutCount }}</h3>
        </div>
        
        <div class="bg-white p-6 rounded-2xl shadow-sm border-b-4 border-indigo-600 hover:shadow-md transition">
            <p class="text-gray-400 text-xs font-bold uppercase tracking-wider">Total User</p>
            <h3 class="text-3xl font-black text-gray-800 mt-1">{{ $totalUser }}</h3>
        </div>
        
        <div class="bg-white p-6 rounded-2xl shadow-sm border-b-4 border-[#CFB53B] hover:shadow-md transition">
            <p class="text-gray-400 text-xs font-bold uppercase tracking-wider">Total Pendapatan</p>
            <h3 class="text-xl font-black text-[#CFB53B] mt-2">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
        </div>
    </div>

    {{-- 2. Analisa Penjualan (Chart) --}}
    <div class="bg-white p-8 rounded-3xl shadow-sm mb-10">
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <h2 class="text-xl font-bold text-gray-800 italic font-serif">Analisa Penjualan</h2>
            <div class="flex bg-gray-100 p-1 rounded-xl">
                <button class="px-4 py-1.5 text-xs font-bold uppercase rounded-lg hover:bg-white transition">1 Bln</button>
                <button class="px-4 py-1.5 text-xs font-bold uppercase rounded-lg bg-white shadow-sm">3 Bln</button>
                <button class="px-4 py-1.5 text-xs font-bold uppercase rounded-lg hover:bg-white transition">1 Thn</button>
            </div>
        </div>
        <div class="h-72">
            <canvas id="salesChart"></canvas>
        </div>
    </div>

    {{-- 3. Statistik Produk --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-white p-6 rounded-3xl shadow-sm">
            <h3 class="text-lg font-bold text-gray-800 mb-6 border-l-4 border-indigo-600 pl-4 uppercase tracking-tighter">5 Terlaris (Checkout)</h3>
            <div class="space-y-4">
                @foreach($topCheckout as $product)
                <div class="flex items-center justify-between p-3 hover:bg-[#F1FBFD] rounded-2xl transition">
                    <div class="flex items-center gap-4">
                        <img src="{{ asset('storage/'.$product->image) }}" class="w-12 h-12 rounded-xl object-cover shadow-sm">
                        <div>
                            <p class="text-sm font-bold text-gray-800">{{ $product->name }}</p>
                            <p class="text-[10px] text-gray-400 uppercase tracking-widest">Total Terjual</p>
                        </div>
                    </div>
                    <span class="text-sm font-black text-indigo-600 bg-indigo-50 px-3 py-1 rounded-full">{{ $product->total_sold }} Pcs</span>
                </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl shadow-sm">
            <h3 class="text-lg font-bold text-gray-800 mb-6 border-l-4 border-[#CFB53B] pl-4 uppercase tracking-tighter">3 Paling Sering Dilirik (Klik)</h3>
            <div class="space-y-6">
                @foreach($mostClicked as $index => $product)
                <div class="relative group overflow-hidden rounded-2xl bg-gray-50 flex items-center">
                    <div class="bg-[#CFB53B] text-white text-[10px] font-bold px-3 py-10 rounded-r-xl">#{{ $index + 1 }}</div>
                    <img src="{{ asset('storage/'.$product->image) }}" class="w-20 h-20 object-cover ml-4">
                    <div class="p-4 flex-1">
                        <p class="text-sm font-bold text-gray-800 uppercase tracking-tight">{{ $product->name }}</p>
                        <p class="text-xs font-bold text-[#CFB53B] mt-1">{{ number_format($product->clicks) }} Pengunjung</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('salesChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($salesData->pluck('month')) !!},
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: {!! json_encode($salesData->pluck('total')) !!},
                borderColor: '#4f46e5',
                backgroundColor: 'rgba(79, 70, 229, 0.05)',
                borderWidth: 3,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#CFB53B',
                pointRadius: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true, grid: { color: '#f3f4f6' } },
                x: { grid: { display: false } }
            }
        }
    });
</script>
@endpush