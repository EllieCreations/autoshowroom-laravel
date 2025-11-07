@extends('layouts.app')

{{-- ✅ AGGIUNGI QUESTI META TAGS SEO --}}
@section('title', 'Inventario Auto - Scopri Tutte le Nostre Auto Nuove e Usate | AMC-SRLS')

@section('description', 'Esplora il nostro inventario completo di auto nuove e usate. Filtri per marca, anno, prezzo e carburante.')

@section('keywords', 'inventario auto, auto in vendita, catalogo auto, auto usate, ricerca auto, concessionaria')

@section('content')

{{-- Header Inventario --}}
<section class="bg-gradient-to-r from-blue-900 to-blue-700 text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">Inventario Completo</h1>
        <p class="text-xl text-blue-100">Esplora la nostra selezione di veicoli premium</p>
    </div>
</section>

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    
    {{-- Filtri --}}
    <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-900 flex items-center">
                <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                </svg>
                Filtra Risultati
            </h2>
            <button id="toggle-filters" class="md:hidden text-blue-600 font-semibold">
                Mostra Filtri
            </button>
        </div>

        <form method="GET" action="{{ route('inventory') }}" id="filter-form" class="hidden md:block">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                
                {{-- Ricerca Generale --}}
                <div class="lg:col-span-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cerca Auto</label>
                    <div class="relative">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Es: BMW, Mercedes, 2020..."
                               class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                        <svg class="absolute left-3 top-3 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </div>

                {{-- Marca --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Marca</label>
                    <select name="brand" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Tutte le marche</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ request('brand') == $brand->id ? 'selected' : '' }}>
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Tipo Auto --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tipo</label>
                    <select name="car_type" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Tutti i tipi</option>
                        @foreach($carTypes as $type)
                            <option value="{{ $type->id }}" {{ request('car_type') == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Carburante --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Carburante</label>
                    <select name="fuel_type" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Tutti</option>
                        @foreach($fuelTypes as $fuel)
                            <option value="{{ $fuel->id }}" {{ request('fuel_type') == $fuel->id ? 'selected' : '' }}>
                                {{ $fuel->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Condizione --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Condizione</label>
                    <select name="condition" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Tutte</option>
                        <option value="nuovo" {{ request('condition') == 'nuovo' ? 'selected' : '' }}>Nuovo</option>
                        <option value="usato" {{ request('condition') == 'usato' ? 'selected' : '' }}>Usato</option>
                    </select>
                </div>

                {{-- Prezzo Min --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Prezzo Min (€)</label>
                    <input type="number" 
                           name="price_min" 
                           value="{{ request('price_min') }}"
                           placeholder="0"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                {{-- Prezzo Max --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Prezzo Max (€)</label>
                    <input type="number" 
                           name="price_max" 
                           value="{{ request('price_max') }}"
                           placeholder="100000"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                {{-- Anno Min --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Anno Min</label>
                    <input type="number" 
                           name="year_min" 
                           value="{{ request('year_min') }}"
                           placeholder="2000"
                           min="1990"
                           max="{{ date('Y') }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                {{-- Anno Max --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Anno Max</label>
                    <input type="number" 
                           name="year_max" 
                           value="{{ request('year_max') }}"
                           placeholder="{{ date('Y') }}"
                           min="1990"
                           max="{{ date('Y') }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>

            {{-- Pulsanti Azione --}}
            <div class="flex flex-wrap gap-3 mt-6">
                <button type="submit" 
                        class="flex-1 md:flex-none bg-gradient-to-r from-blue-600 to-blue-700 text-white px-8 py-2.5 rounded-lg font-semibold hover:from-blue-700 hover:to-blue-800 transition-all shadow-md hover:shadow-lg">
                    <span class="flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        Cerca
                    </span>
                </button>
                <a href="{{ route('inventory') }}" 
                   class="flex-1 md:flex-none bg-gray-200 text-gray-700 px-8 py-2.5 rounded-lg font-semibold hover:bg-gray-300 transition-all text-center">
                    Reset
                </a>
            </div>
        </form>
    </div>

    {{-- Risultati Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <p class="text-gray-600">
                <span class="font-semibold text-gray-900">{{ $cars->count() }}</span> auto trovate
            </p>
        </div>
        <div class="flex items-center space-x-2">
            <label class="text-sm text-gray-600">Ordina per:</label>
            <select name="sort" 
                    onchange="document.getElementById('filter-form').submit()"
                    class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                <option value="newest">Più recenti</option>
                <option value="price_asc">Prezzo: basso → alto</option>
                <option value="price_desc">Prezzo: alto → basso</option>
                <option value="year_desc">Anno: nuovo → vecchio</option>
                <option value="km_asc">Km: meno → più</option>
            </select>
        </div>
    </div>

    {{-- Griglia Auto --}}
    @if($cars->count() > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
        @foreach($cars as $car)
        <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden transform hover:-translate-y-2">
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

                @if($car->highlighted)
                <div class="absolute top-3 right-3">
                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-400 text-yellow-900">
                        ⭐ In Evidenza
                    </span>
                </div>
                @endif
            </div>

            {{-- Info --}}
            <div class="p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-blue-600 transition-colors">
                    {{ $car->brand->name ?? 'Marca' }} {{ $car->model }}
                </h3>
                
                <div class="grid grid-cols-2 gap-2 text-sm text-gray-600 mb-4">
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-1.5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        {{ $car->year }}
                    </span>
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-1.5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        {{ number_format($car->km, 0, ',', '.') }} km
                    </span>
                    <span class="flex items-center col-span-2">
                        <svg class="w-4 h-4 mr-1.5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        {{ $car->fuelType->name ?? 'N/A' }}
                    </span>
                </div>

                <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                    <div>
                        <p class="text-2xl font-bold text-blue-600">
                            € {{ number_format($car->price, 0, ',', '.') }}
                        </p>
                    </div>
                    <a href="{{ route('cars.show', $car->id) }}" 
                       class="inline-flex items-center bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
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

    {{-- Paginazione --}}
    @if(method_exists($cars, 'links'))
    <div class="mt-8 space-y-4">
        {{-- Info Paginazione Italiana --}}
        <div class="text-center text-sm text-gray-600">
            Visualizzate da <span class="font-semibold">{{ $cars->firstItem() ?? 0 }}</span> 
            a <span class="font-semibold">{{ $cars->lastItem() ?? 0 }}</span> 
            di <span class="font-semibold">{{ $cars->total() }}</span> auto totali
        </div>
        
        {{-- Links Paginazione Personalizzati --}}
        <div class="flex justify-center items-center space-x-2">
            {{-- Precedente --}}
            @if ($cars->onFirstPage())
                <span class="px-4 py-2 bg-gray-200 text-gray-400 rounded-lg cursor-not-allowed">
                    ← Precedente
                </span>
            @else
                <a href="{{ $cars->previousPageUrl() }}" 
                   class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">
                    ← Precedente
                </a>
            @endif

            {{-- Numeri Pagina --}}
            <div class="hidden sm:flex space-x-1">
                @foreach(range(1, $cars->lastPage()) as $page)
                    @if($page == $cars->currentPage())
                        <span class="px-4 py-2 bg-blue-600 text-white rounded-lg font-bold">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $cars->url($page) }}" 
                           class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-medium transition-colors">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            </div>

            {{-- Pagina corrente (mobile) --}}
            <div class="sm:hidden px-4 py-2 bg-gray-100 rounded-lg">
                <span class="font-semibold">{{ $cars->currentPage() }}</span> / {{ $cars->lastPage() }}
            </div>

            {{-- Successivo --}}
            @if ($cars->hasMorePages())
                <a href="{{ $cars->nextPageUrl() }}" 
                   class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">
                    Successivo →
                </a>
            @else
                <span class="px-4 py-2 bg-gray-200 text-gray-400 rounded-lg cursor-not-allowed">
                    Successivo →
                </span>
            @endif
        </div>
        
        {{-- Reset Button Mobile (sticky bottom) --}}
        @if(request()->hasAny(['search', 'brand', 'car_type', 'fuel_type', 'condition', 'price_min', 'price_max', 'year_min', 'year_max']))
        <div class="md:hidden fixed bottom-4 right-4 z-40">
            <a href="{{ route('inventory') }}" 
               class="flex items-center justify-center bg-red-600 hover:bg-red-700 text-white w-14 h-14 rounded-full shadow-2xl transition-all transform hover:scale-110"
               title="Reset filtri">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </a>
        </div>
        @endif
    </div>
    @endif

    @else
    {{-- Nessun risultato --}}
    <div class="text-center py-16">
        <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <h3 class="text-2xl font-bold text-gray-900 mb-2">Nessuna auto trovata</h3>
        <p class="text-gray-600 mb-6">Prova a modificare i filtri di ricerca</p>
        <a href="{{ route('inventory') }}" 
           class="inline-flex items-center bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
            Reset Filtri
        </a>
    </div>
    @endif
</section>

@push('scripts')
<script>
// Toggle filtri mobile
document.getElementById('toggle-filters').addEventListener('click', function() {
    const form = document.getElementById('filter-form');
    const button = this;
    
    form.classList.toggle('hidden');
    button.textContent = form.classList.contains('hidden') ? 'Mostra Filtri' : 'Nascondi Filtri';
});
</script>
@endpush

@endsection