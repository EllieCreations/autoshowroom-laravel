<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="AMC-SRLS - Showroom auto di qualità. Scopri la nostra selezione di veicoli nuovi e usati.">
    <title>@yield('title', 'AMC-SRLS | Auto Showroom')</title>
    
    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    @vite('resources/css/app.css')
    
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