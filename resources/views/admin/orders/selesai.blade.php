<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Berhasil | Admin Ade Afwa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex">
    <main class="flex-1 p-8">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">3. Pesanan Berhasil (Completed)</h1>

        <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-200">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">ID Order</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Pelanggan</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Total Bayar</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">No. Resi</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($orders as $order)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 font-bold text-gray-800">#{{ $order->id }}</td>
                        <td class="px-6 py-4">{{ $order->user->name ?? 'Guest' }}</td>
                        <td class="px-6 py-4 font-bold text-emerald-600">Rp {{ number_format($order->total_price) }}</td>
                        <td class="px-6 py-4 text-gray-500 text-sm">{{ $order->note ?? '-' }}</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 bg-emerald-100 text-emerald-600 rounded-full text-xs font-black uppercase tracking-widest">
                                BERHASIL
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-400 italic">Belum ada riwayat pesanan selesai.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>