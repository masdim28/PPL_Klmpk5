<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pesanan | Admin Ade Afwa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex">
    <main class="flex-1 p-8">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">2. Pesanan (Siap Dikirim)</h1>

        <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-200">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">ID Order</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Pelanggan</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Metode</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Status Shipping</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($orders as $order)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 font-bold text-indigo-600">#{{ $order->id }}</td>
                        <td class="px-6 py-4 text-gray-700">{{ $order->user->name ?? 'Guest' }}</td>
                        <td class="px-6 py-4"><span class="px-2 py-1 bg-blue-100 text-blue-600 rounded-md text-xs font-bold">{{ strtoupper($order->payment_method) }}</span></td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 {{ $order->status_shipping == 'processing' ? 'bg-amber-100 text-amber-600' : 'bg-blue-100 text-blue-600' }} rounded-md text-xs font-bold">
                                {{ ucfirst($order->status_shipping) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <form action="{{ route('admin.orders.resi', $order->id) }}" method="POST" class="flex gap-2">
                                @csrf
                                <input type="text" name="resi" placeholder="Input No. Resi" class="border rounded-lg px-3 py-1 text-sm focus:ring-2 focus:ring-indigo-500 outline-none w-40" required>
                                <button type="submit" class="bg-indigo-600 text-white px-4 py-1 rounded-lg text-sm font-bold hover:bg-indigo-700 transition">
                                    Update
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-400 italic">Tidak ada pesanan yang perlu diproses.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>