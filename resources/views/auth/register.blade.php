<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Ade Afwa Boutique</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* CSS Tambahan untuk kustomisasi lebih detail */
        .bg-ade-afwa { background-color: #FDF9F0; } /* Warna krem lembut khas Ade Afwa */
        .text-ade-afwa-gold { color: #CFB53B; } /* Warna emas untuk teks khusus */
        .font-serif-ade { font-family: 'Playfair Display', serif; } /* Font serif untuk kesan elegan */
        
        /* Gaya input agar konsisten dan menarik */
        .ade-input {
            width: 100%;
            padding: 0.75rem 1rem;
            background-color: #F4F0E8; /* Sedikit lebih gelap dari bg untuk kontras */
            border-radius: 0.5rem;
            outline: none;
            transition: all 0.2s;
        }
        .ade-input:focus {
            background-color: #FFFFFF;
            box-shadow: 0 0 0 2px rgba(207, 181, 59, 0.5); /* Ring emas saat fokus */
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body class="bg-ade-afwa text-gray-900 font-sans antialiased relative min-h-screen">

    <header class="p-4 border-b border-gray-100 bg-white shadow-sm flex items-center justify-between">
        <a href="/" class="text-sm text-ade-afwa-gold hover:text-gray-900 transition font-medium">← Kembali ke Toko</a>
        
        <div class="flex items-center space-x-2">
    <span class="text-xl font-medium">Register</span>
    <img src="{{ asset('images/logo_adeafwa.png') }}" alt="Logo Ade Afwa" class="h-10 w-auto">
</div>
    </header>

    <div class="max-w-4xl mx-auto px-4 py-16">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-serif-ade font-bold text-ade-afwa-gold mb-3">Buat Akun Baru</h1>
            <p class="text-gray-600">Silakan lengkapi informasi di bawah ini untuk bergabung dengan **Ade Afwa Boutique**.</p>
        </div>

        <div class="bg-white rounded-2xl shadow-xl overflow-hidden p-8 md:p-12">
            
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-lg">
                    <ul class="list-disc list-inside text-sm text-red-600 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                    
                    <div class="space-y-6">
                        <h2 class="text-lg font-semibold text-gray-800 border-b pb-2">Data Pribadi</h2>
                        
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">Nama Lengkap</label>
                            <input type="text" id="name" name="name" required value="{{ old('name') }}" placeholder="Contoh: Siti Aisyah" class="ade-input">
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1.5">No. HP / WhatsApp (Aktif)</label>
                            <input type="tel" id="phone" name="phone" required value="{{ old('phone') }}" placeholder="Contoh: 08123456789" class="ade-input">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2.5">Jenis Kelamin</label>
                            <div class="flex items-center space-x-8">
                                <label class="flex items-center space-x-3 cursor-pointer">
                                    <input type="radio" name="gender" value="female" required class="w-5 h-5 text-ade-afwa-gold border-gray-300 focus:ring-ade-afwa-gold">
                                    <span class="text-gray-800">Perempuan</span>
                                </label>
                                <label class="flex items-center space-x-3 cursor-pointer">
                                    <input type="radio" name="gender" value="male" class="w-5 h-5 text-ade-afwa-gold border-gray-300 focus:ring-ade-afwa-gold">
                                    <span class="text-gray-800">Laki-laki</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <h2 class="text-lg font-semibold text-gray-800 border-b pb-2">Alamat & Kredensial</h2>
                        
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-1.5">Alamat Lengkap Pengiriman</label>
                            <textarea id="address" name="address" required rows="4" placeholder="Nama Jalan, No Rumah, RT/RW, Kec/Kab" class="ade-input">{{ old('address') }}</textarea>
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Alamat Email</label>
                            <input type="email" id="email" name="email" required value="{{ old('email') }}" placeholder="Contoh: sitiaisyah@email.com" class="ade-input">
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                            <input type="password" id="password" name="password" required placeholder="Minimal 8 karakter" class="ade-input">
                        </div>
                        
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1.5">Konfirmasi Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="Ulangi password Anda" class="ade-input">
                        </div>
                    </div>
                </div>

                <div class="mt-12 text-center space-y-5">
                    <button type="submit" class="w-full md:w-auto md:px-12 bg-ade-afwa-gold text-white py-4 rounded-xl font-bold text-lg hover:bg-yellow-600 transition shadow-lg flex justify-center items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z" clip-rule="evenodd" />
                        </svg>
                        <span>Daftar Akun Sekarang</span>
                    </button>
                    
                    <p class="text-sm text-gray-600">
                        Sudah punya akun? 
                        <a href="{{ route('login') }}" class="font-medium text-ade-afwa-gold hover:underline">Masuk di sini</a>
                    </p>
                </div>
            </form>
        </div>

        <footer class="mt-16 text-center text-sm text-gray-500">
            &copy; {{ date('Y') }} Ade Afwa Boutique. Semua hak dilindungi.
        </footer>
    </div>

</body>
</html>