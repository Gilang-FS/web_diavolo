<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">
    <div class="min-h-screen grid grid-cols-2">

        {{-- KIRI --}}
        <div class="bg-black flex flex-col justify-center gap-16 p-16 relative overflow-hidden">
            <a href="/" class="font-bebas text-xl tracking-[4px] text-white no-underline hover:opacity-50 transition-opacity absolute top-16 left-16">
                DIAVOLO
            </a>
            <div class="relative z-10">
                <p class="text-white/30 text-[10px] font-montserrat tracking-[4px] uppercase mb-4">
                    Diavolo Apparel — 2026
                </p>
                <h2 class="font-bebas text-[56px] leading-[1] tracking-[1px] text-white mb-6">
                    TRAIN HARD.<br>LOOK SHARP.
                </h2>
                <p class="text-white/30 text-xs font-montserrat tracking-[2px] leading-relaxed max-w-[200px] uppercase">
                    Perlengkapan bela diri untuk mereka yang serius.
                </p>
            </div>
            <div class="absolute bottom-0 left-0 pointer-events-none select-none overflow-hidden">
                <p class="font-bebas text-[140px] leading-none text-white opacity-[0.04] whitespace-nowrap">DIAVOLO</p>
            </div>
            <p class="text-white/20 text-[10px] font-montserrat tracking-wider absolute bottom-16 left-16">
                © 2026 DIAVOLO
            </p>
        </div>

        {{-- KANAN --}}
        <div class="bg-white flex flex-col justify-center px-20">
            {{ $slot }}
        </div>

    </div>
</body>
</html>