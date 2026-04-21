<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Ade Afwa Boutique</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=playfair-display:700|poppins:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            /* Custom Warna & Font sesuai tema Butik */
            .font-serif-ade { font-family: 'Playfair Display', serif; }
            .bg-ade-cream { background-color: #FDF9F0; }
            .text-ade-gold { color: #CFB53B; }
        </style>
    </head>
    <body class="font-sans antialiased bg-ade-cream">
        <div class="min-h-screen">
            

            @isset($header)
                <header class="bg-white shadow-sm border-b border-gray-100">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 font-serif-ade text-2xl text-gray-800">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main>
                {{ $slot }}
            </main>

            <footer class="bg-white border-t border-gray-100 py-10 mt-12">
                <div class="max-w-7xl mx-auto px-4 text-center">
                    <p class="text-[10px] text-gray-400 uppercase tracking-[0.3em]">
                        © 2026 ADE AFWA BOUTIQUE. DIBUAT DENGAN ❤️ OLEH KELOMPOK 5 INFORMATIKA UINSSC
                    </p>
                </div>
            </footer>
        </div>
    </body>
</html>