@extends('layouts.app')

{{-- META TAGS SEO --}}
@section('title', 'AMC-SRLS | Auto Showroom - Veicoli Nuovi e Usati Garantiti')

@section('description', 'Showroom auto. Visita il nostro catalogo online!')

@section('keywords', 'auto usate liguria, la spezia, concessionaria auto, vendita auto, auto nuove, showroom auto, auto km 0')

{{-- STRUCTURED DATA --}}
@push('structured-data')
    @include('components.structured-data-business')
@endpush

@section('content')

{{-- Hero Section --}}
<section class="relative bg-gradient-to-br from-blue-900 via-blue-800 to-gray-900 text-white overflow-hidden">
    <div class="absolute inset-0 bg-black opacity-20"></div>
    <div class="absolute inset-0">
        <div class="absolute top-10 left-10 w-72 h-72 bg-blue-500 rounded-full filter blur-3xl opacity-20 animate-pulse"></div>
        <div class="absolute bottom-10 right-10 w-96 h-96 bg-purple-500 rounded-full filter blur-3xl opacity-20 animate-pulse" style="animation-delay: 1s;"></div>
    </div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 md:py-32">
        <div class="max-w-3xl">
            <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold mb-6 leading-tight">
                Trova la Tua
                <span class="bg-gradient-to-r from-blue-400 to-cyan-300 bg-clip-text text-transparent">
                    Auto Ideale
                </span>
            </h1>
            <p class="text-xl md:text-2xl text-gray-300 mb-8 leading-relaxed">
                Oltre 100 veicoli selezionati. Qualità garantita, prezzi trasparenti e assistenza professionale per ogni tua esigenza.
            </p>
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="/inventory" 
                   class="inline-flex items-center justify-center bg-gradient-to-r from-blue-500 to-blue-600 text-white px-8 py-4 rounded-lg font-semibold text-lg hover:from-blue-600 hover:to-blue-700 transform hover:scale-105 transition-all duration-200 shadow-xl hover:shadow-2xl">
                    Scopri l'Inventario
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
                <a href="/contact" 
                   class="inline-flex items-center justify-center bg-white/10 backdrop-blur-sm text-white px-8 py-4 rounded-lg font-semibold text-lg hover:bg-white/20 border-2 border-white/30 transition-all duration-200">
                    Contattaci
                </a>
            </div>
        </div>
    </div>
    
    {{-- Wave divider --}}
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 120L60 110C120 100 240 80 360 70C480 60 600 60 720 65C840 70 960 80 1080 85C1200 90 1320 90 1380 90L1440 90V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="#F9FAFB"/>
        </svg>
    </div>
</section>

{{-- Auto in Evidenza --}}
@if($latestCars->count() > 0)
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="text-center mb-12">
        <h2 class="text-4xl font-bold text-gray-900 mb-3">
            Auto in <span class="text-blue-600">Evidenza</span>
        </h2>
        <p class="text-gray-600 text-lg">Le migliori offerte selezionate per te</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($latestCars->take(6) as $index => $car)
        {{-- Nascondi dalla 4a in poi su mobile --}}
        <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden transform hover:-translate-y-2 {{ $index >= 3 ? 'hidden lg:block' : '' }}">
            {{-- Immagine --}}
            <div class="relative h-56 overflow-hidden bg-gray-200">
                @if($car->images->first())
                    <img src="{{ asset('storage/' . $car->images->first()->image_path) }}" 
                         alt="{{ $car->brand->name ?? 'Auto' }} {{ $car->model }}"
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                @else
                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-300 to-gray-400">
                        <svg class="w-20 h-20 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                @endif
                
                {{-- Badge Condizione --}}
                <div class="absolute top-3 left-3">
                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $car->car_condition === 'nuovo' ? 'bg-green-500 text-white' : 'bg-blue-500 text-white' }}">
                        {{ ucfirst($car->car_condition) }}
                    </span>
                </div>
            </div>

            {{-- Info --}}
            <div class="p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-blue-600 transition-colors">
                    {{ $car->brand->name ?? 'Marca' }} {{ $car->model }}
                </h3>
                
                <div class="flex items-center text-sm text-gray-600 mb-4 space-x-4">
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        {{ $car->year }}
                    </span>
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        {{ number_format($car->km, 0, ',', '.') }} km
                    </span>
                </div>

                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-2xl font-bold text-blue-600">
                            € {{ number_format($car->price, 0, ',', '.') }}
                        </p>
                    </div>
                    <a href="{{ route('cars.show', $car->id) }}" 
                       class="inline-flex items-center text-blue-600 font-semibold hover:text-blue-700 transition-colors">
                        Dettagli
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="text-center mt-12">
        <a href="/inventory" 
           class="inline-flex items-center bg-gradient-to-r from-blue-600 to-blue-700 text-white px-8 py-3 rounded-lg font-semibold hover:from-blue-700 hover:to-blue-800 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl">
            Vedi Tutte le Auto
            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
            </svg>
        </a>
    </div>
</section>
@endif

{{-- Perché Sceglierci --}}
<section class="bg-gray-100 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-900 mb-3">
                Perché <span class="text-blue-600">Sceglierci</span>
            </h2>
            <p class="text-gray-600 text-lg">La tua soddisfazione è la nostra priorità</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Qualità Garantita</h3>
                <p class="text-gray-600">Ogni veicolo è accuratamente selezionato e controllato</p>
            </div>

            <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Prezzi Trasparenti</h3>
                <p class="text-gray-600">Nessun costo nascosto, massima chiarezza</p>
            </div>

            <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Assistenza Dedicata</h3>
                <p class="text-gray-600">Ti seguiamo in ogni fase dell'acquisto</p>
            </div>
        </div>
    </div>
</section>

@endsection