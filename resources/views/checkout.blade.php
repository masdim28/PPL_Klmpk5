<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Ade Afwa Boutique</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        #map { height: 350px; width: 100%; border-radius: 0.75rem; z-index: 1; }
        .leaflet-container { font-family: inherit; }
    </style>
</head>
<body class="bg-gray-50 text-gray-900 font-sans">

    <div class="max-w-6xl mx-auto px-4 py-12">
        <h2 class="text-3xl font-serif font-bold text-indigo-900 mb-8 text-center">Konfirmasi Pesanan</h2>

        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf
            
            @foreach($selectedIds as $id)
                <input type="hidden" name="selected_items[]" value="{{ $id }}">
            @endforeach

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                
                <div class="space-y-6">
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <h3 class="text-lg font-bold mb-4 border-b pb-2 flex items-center gap-2 text-indigo-900">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Alamat Pengiriman (Gratis Map)
                        </h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Penerima</label>
                                <input type="text" name="recipient_name" required placeholder="Contoh: Dimas Adriansah" 
                                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Cari Lokasi / Nama Jalan</label>
                                <div class="flex gap-2">
                                    <input id="search-input" type="text" placeholder="Ketik nama jalan atau tempat..." 
                                        class="flex-1 p-3 border border-indigo-200 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none shadow-sm">
                                    <button type="button" onclick="searchLocation()" class="bg-indigo-600 text-white px-4 rounded-lg hover:bg-indigo-700">Cari</button>
                                </div>
                                <p class="text-[10px] text-gray-400 mt-1">*Tekan Cari untuk memindahkan pin otomatis.</p>
                            </div>

                            <div id="map" class="shadow-inner border border-gray-200"></div>
                            <p class="text-[11px] text-center text-gray-500">Geser pin merah ke lokasi tepat rumah Anda</p>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Alamat Lengkap & Detail (RT/RW/No)</label>
                                <textarea id="address-details" name="full_address" required rows="3" 
                                    class="w-full p-3 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-indigo-500" 
                                    placeholder="Alamat akan terisi otomatis saat pin digeser..."></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-md p-6">
                        <h3 class="text-lg font-bold mb-4 border-b pb-2 text-indigo-900">Metode Pembayaran</h3>
                        <select name="payment_method" class="w-full p-3 border border-gray-300 rounded-lg bg-gray-50 outline-none">
                            <option value="Transfer Bank">Transfer Bank (Manual)</option>
                            <option value="QRIS">QRIS / E-Wallet</option>
                        </select>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <h3 class="text-lg font-bold mb-4 border-b pb-2 text-indigo-900">Rincian Barang</h3>
                        <div class="space-y-4 mb-6">
                            @foreach($items as $item)
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center space-x-3">
                                        <img src="{{ asset('storage/' . $item->product->image) }}" class="w-12 h-12 object-cover rounded shadow-sm">
                                        <div>
                                            <p class="text-sm font-bold text-gray-800">{{ $item->product->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $item->qty }} x Rp {{ number_format($item->product->price, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                    <p class="text-sm font-bold text-indigo-600">
                                        Rp {{ number_format($item->product->price * $item->qty, 0, ',', '.') }}
                                    </p>
                                </div>
                            @endforeach
                        </div>

                        <div class="mb-6 pt-4 border-t">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Jasa Pengiriman:</label>
                            <select id="courier-select" name="shipping_service" class="w-full p-3 border border-indigo-200 rounded-lg bg-indigo-50 outline-none focus:ring-2 focus:ring-indigo-500">
                                <option value="" data-cost="0">-- Pilih Kurir --</option>
                                <option value="JNE Reguler" data-cost="15000">JNE Reguler (Rp 15.000)</option>
                                <option value="J&T Express" data-cost="12000">J&T Express (Rp 12.000)</option>
                                <option value="SiCepat" data-cost="10000">SiCepat (Rp 10.000)</option>
                                <option value="Ambil Sendiri" data-cost="0">Ambil di Toko (Gratis)</option>
                            </select>
                        </div>

                        <div class="space-y-3 pt-4 border-t border-dashed">
                            <div class="flex justify-between text-gray-600">
                                <span>Subtotal Produk</span>
                                <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Biaya Pengiriman</span>
                                <span id="display-ongkir">Rp 0</span>
                            </div>
                            <div class="flex justify-between items-center pt-4 mt-2 border-t-2 border-indigo-100">
                                <span class="text-lg font-bold text-indigo-900">Total Akhir:</span>
                                <span class="text-2xl font-black text-indigo-900" id="grand-total">
                                    Rp {{ number_format($total, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        <button type="submit" class="w-full mt-8 bg-indigo-900 text-white py-4 rounded-xl font-bold text-lg hover:bg-indigo-800 transition shadow-lg flex justify-center items-center gap-2">
                            <span>Checkout ke WhatsApp</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        // 1. Setup Peta
        const defaultPos = [-6.7320, 108.5523]; // Koordinat default Cirebon
        const map = L.map('map').setView(defaultPos, 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // Tambahkan Marker yang bisa digeser
        let marker = L.marker(defaultPos, { draggable: true }).addTo(map);

        // 2. Fungsi Reverse Geocoding (Ubah Koordinat jadi Teks Alamat)
        function updateAddressText(lat, lng) {
            fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`)
                .then(res => res.json())
                .then(data => {
                    document.getElementById('address-details').value = data.display_name;
                });
        }

        // Event saat marker selesai digeser
        marker.on('dragend', function() {
            const pos = marker.getLatLng();
            updateAddressText(pos.lat, pos.lng);
        });

        // 3. Fungsi Cari Lokasi (Geocoding)
        function searchLocation() {
            const query = document.getElementById('search-input').value;
            if (query.length < 3) return;

            fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${query}`)
                .then(res => res.json())
                .then(data => {
                    if (data.length > 0) {
                        const item = data[0];
                        const newPos = [item.lat, item.lon];
                        map.setView(newPos, 16);
                        marker.setLatLng(newPos);
                        document.getElementById('address-details').value = item.display_name;
                    } else {
                        alert("Lokasi tidak ditemukan");
                    }
                });
        }

        // 4. Logika Ongkir Dinamis
        const courierSelect = document.getElementById('courier-select');
        const displayOngkir = document.getElementById('display-ongkir');
        const grandTotalDisplay = document.getElementById('grand-total');
        const subtotal = {{ $total }};

        courierSelect.addEventListener('change', function() {
            const cost = parseInt(this.options[this.selectedIndex].getAttribute('data-cost')) || 0;
            const grandTotal = subtotal + cost;

            displayOngkir.innerText = 'Rp ' + cost.toLocaleString('id-ID');
            grandTotalDisplay.innerText = 'Rp ' + grandTotal.toLocaleString('id-ID');
        });
    </script>
</body>
</html>