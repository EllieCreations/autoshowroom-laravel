<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    {{-- Meta Description Dinamica --}}
    <meta name="description" content="@yield('description', 'AMC-SRLS - Showroom auto di qualità. Scopri la nostra selezione di veicoli nuovi e usati.')">
    
    {{-- Meta Keywords --}}
    <meta name="keywords" content="@yield('keywords', 'auto usate, concessionaria auto, vendita auto, showroom auto')">
    
    {{-- Meta Author e Robots --}}
    <meta name="author" content="AMC-SRLS Auto Showroom">
    <meta name="robots" content="index, follow">
    
    {{-- Title dinamico (già ce l'hai, perfetto!) --}}
    <title>@yield('title', 'AMC-SRLS | Auto Showroom')</title>
    
    {{-- Canonical URL --}}
    <link rel="canonical" href="@yield('canonical', url()->current())">
    
    {{-- Open Graph per Social Media --}}
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:title" content="@yield('og_title', 'AMC-SRLS Auto Showroom')">
    <meta property="og:description" content="@yield('og_description', 'Scopri la nostra selezione di auto nuove e usate')">
    <meta property="og:image" content="@yield('og_image', asset('images/og-default.jpg'))">
    <meta property="og:url" content="@yield('og_url', url()->current())">
    <meta property="og:site_name" content="AMC-SRLS Auto Showroom">
    <meta property="og:locale" content="it_IT">
    
    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('twitter_title', 'AMC-SRLS Auto Showroom')">
    <meta name="twitter:description" content="@yield('twitter_description', 'Scopri la nostra selezione di auto')">
    <meta name="twitter:image" content="@yield('twitter_image', asset('images/og-default.jpg'))">
    
    {{-- Favicon (opzionale, se non ce l'hai salta) --}}
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    
    {{-- Google Fonts (già ce l'hai, perfetto!) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    @vite('resources/css/app.css')
    
    {{-- Stack per Structured Data --}}
    @stack('structured-data')
    
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        /* Scroll smooth solo per link interni */
        html:has(a[href^="#"]:hover) {
            scroll-behavior: smooth;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #3b82f6;
            border-radius: 5px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #2563eb;
        }
    </style>
    
    @stack('styles')
</head>

<body class="bg-gray-50 text-gray-900 antialiased">

    {{-- Header dinamico (pubblico o admin) --}}
    @if (str_starts_with(request()->path(), 'admin'))
        @include('partials.admin-navbar')
    @else
        @include('partials.header')
    @endif

    {{-- Contenuto principale --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer (solo per parte pubblica) --}}
    @if (!str_starts_with(request()->path(), 'admin'))
        @include('partials.footer')
    @endif
    
    @stack('scripts')
</body>
</html>