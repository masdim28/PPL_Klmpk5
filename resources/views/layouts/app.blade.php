<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Ade Afwa Boutique') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,900&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="font-sans antialiased bg-[#F1FBFD] text-gray-900">
        <div class="min-h-screen">
            
            {{-- 
                LOGIKA: Sembunyikan navigasi jika berada di halaman:
                1. Detail Produk (products/*)
                2. Semua Produk (products) 
            --}}
            @if(!Request::is('products*'))
                @include('layouts.navigation')
            @endif

            <main>
                {{ $slot }}
            </main>

            {{-- Sembunyikan footer juga di halaman produk agar bersih --}}
            @if(!Request::is('products*'))
                <footer class="py-10 text-center border-t border-indigo-50 mt-12 bg-white/30">
                    <p class="text-[10px] font-black text-indigo-300 uppercase tracking-[0.5em] italic">
                        &copy; 2026 ADE AFWA BOUTIQUE • DIMAS ADRIANSAH
                    </p>
                </footer>
            @endif
        </div>
    </body>
</html>