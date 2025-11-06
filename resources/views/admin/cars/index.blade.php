@extends('layouts.app')

@section('title', 'Gestione Auto | Admin AMC-SRLS')

@section('content')

<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
            <div class="mb-4 md:mb-0">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Gestione Auto</h1>
                <p class="text-gray-600">Visualizza, modifica o elimina le auto del catalogo</p>
            </div>
            <a href="{{ route('admin.cars.create') }}"
               class="inline-flex items-center bg-gradient-to-r from-green-500 to-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:from-green-600 hover:to-green-700 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Aggiungi Auto
            </a>
        </div>

        {{-- Messaggi di successo --}}
        @if (session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-lg shadow-md">
            <div class="flex items-center">
                <svg class="w-6 h-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-green-700 font-medium">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        {{-- Filtri e Ricerca --}}
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-bold text-gray-900 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Cerca e Filtra
                </h2>
                <button id="toggle-filters" class="md:hidden text-blue-600 font-semibold text-sm">
                    Mostra
                </button>
            </div>

            <form method="GET" action="{{ route('admin.cars.index') }}" id="admin-filter-form" class="hidden md:block space-y-4">
                {{-- Ricerca Generale --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cerca Auto</label>
                    <div class="relative">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Cerca per marca, modello, anno..."
                               class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <svg class="absolute left-3 top-3 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </div>

                {{-- Filtri in Grid --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    {{-- Marca --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Marca</label>
                        <select name="brand" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="">Tutte</option>
                            @foreach(\App\Models\Brand::orderBy('name')->get() as $brand)
                                <option value="{{ $brand->id }}" {{ request('brand') == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Condizione --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Condizione</label>
                        <select name="condition" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="">Tutte</option>
                            <option value="nuovo" {{ request('condition') == 'nuovo' ? 'selected' : '' }}>Nuovo</option>
                            <option value="usato" {{ request('condition') == 'usato' ? 'selected' : '' }}>Usato</option>
                        </select>
                    </div>

                    {{-- Evidenza --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Evidenza</label>
                        <select name="highlighted" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="">Tutte</option>
                            <option value="1" {{ request('highlighted') == '1' ? 'selected' : '' }}>In evidenza</option>
                            <option value="0" {{ request('highlighted') == '0' ? 'selected' : '' }}>Standard</option>
                        </select>
                    </div>

                    {{-- Ordinamento --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Ordina per</label>
                        <select name="sort" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Più recenti</option>
                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Meno recenti</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Prezzo ↓</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Prezzo ↑</option>
                        </select>
                    </div>
                </div>

                {{-- Pulsanti --}}
                <div class="flex flex-wrap gap-3">
                    <button type="submit" 
                            class="flex-1 md:flex-none bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg font-medium transition-colors flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        Cerca
                    </button>
                    <a href="{{ route('admin.cars.index') }}" 
                       class="flex-1 md:flex-none bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2.5 rounded-lg font-medium transition-colors text-center">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        {{-- Statistiche Rapide --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white rounded-lg shadow p-4 border-l-4 border-blue-500">
                <p class="text-sm text-gray-600">Totale Auto</p>
                <p class="text-2xl font-bold text-gray-900">{{ $cars->count() }}</p>
            </div>
            <div class="bg-white rounded-lg shadow p-4 border-l-4 border-yellow-500">
                <p class="text-sm text-gray-600">In Evidenza</p>
                <p class="text-2xl font-bold text-gray-900">{{ $cars->where('highlighted', 1)->count() }}</p>
            </div>
            <div class="bg-white rounded-lg shadow p-4 border-l-4 border-green-500">
                <p class="text-sm text-gray-600">Nuove</p>
                <p class="text-2xl font-bold text-gray-900">{{ $cars->where('car_condition', 'nuovo')->count() }}</p>
            </div>
            <div class="bg-white rounded-lg shadow p-4 border-l-4 border-purple-500">
                <p class="text-sm text-gray-600">Usate</p>
                <p class="text-2xl font-bold text-gray-900">{{ $cars->where('car_condition', 'usato')->count() }}</p>
            </div>
        </div>

        {{-- Tabella Desktop --}}
        <div class="hidden md:block bg-white rounded-xl shadow-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Auto</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Dettagli</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Prezzo</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Stato</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Azioni</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($cars as $car)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-medium text-gray-900">#{{ $car->id }}</span>
                        </td>
                        
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="h-16 w-24 flex-shrink-0 rounded-lg overflow-hidden bg-gray-200">
                                    @if($car->images->first())
                                        <img src="{{ $car->images->first()->image_path }}" 
                                             alt="{{ $car->brand->name }}"
                                             class="h-full w-full object-cover">
                                    @else
                                        <div class="h-full w-full flex items-center justify-center">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-bold text-gray-900">{{ $car->brand->name ?? 'N/A' }}</div>
                                    <div class="text-sm text-gray-600">{{ $car->model }}</div>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">Anno: {{ $car->year }}</div>
                            <div class="text-sm text-gray-600">{{ number_format($car->km, 0, ',', '.') }} km</div>
                            <div class="text-xs text-gray-500 capitalize">{{ $car->car_condition }}</div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-lg font-bold text-blue-600">
                                € {{ number_format($car->price, 0, ',', '.') }}
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            @if ($car->highlighted)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    In Evidenza
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-600">
                                    Standard
                                </span>
                            @endif
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <div class="flex items-center justify-center space-x-2">
                                <a href="{{ route('admin.cars.edit', $car->id) }}"
                                   class="inline-flex items-center bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded-lg transition-colors text-sm font-medium"
                                   title="Modifica">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>

                                <form action="{{ route('admin.cars.destroy', $car->id) }}"
                                      method="POST"
                                      class="inline-block"
                                      onsubmit="return confirm('Sei sicuro di voler eliminare questa auto? Verranno cancellate anche le immagini.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-lg transition-colors text-sm font-medium"
                                            title="Elimina">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                            </svg>
                            <p class="text-gray-500 text-lg mb-4">Nessuna auto presente nel catalogo</p>
                            <a href="{{ route('admin.cars.create') }}" 
                               class="inline-flex items-center text-blue-600 hover:text-blue-700 font-medium">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Aggiungi la prima auto
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Card Mobile --}}
        <div class="md:hidden space-y-4">
            @forelse ($cars as $car)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="h-48 bg-gray-200">
                    @if($car->images->first())
                        <img src="{{ $car->images->first()->image_path }}" 
                             alt="{{ $car->brand->name }}"
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    @endif
                </div>
                <div class="p-4">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-lg font-bold text-gray-900">{{ $car->brand->name ?? 'N/A' }} {{ $car->model }}</h3>
                        @if ($car->highlighted)
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                ⭐
                            </span>
                        @endif
                    </div>
                    <div class="grid grid-cols-2 gap-2 text-sm text-gray-600 mb-4">
                        <div>Anno: {{ $car->year }}</div>
                        <div>{{ number_format($car->km, 0, ',', '.') }} km</div>
                        <div class="capitalize">{{ $car->car_condition }}</div>
                        <div class="text-right">
                            <span class="text-lg font-bold text-blue-600">€ {{ number_format($car->price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ route('admin.cars.edit', $car->id) }}"
                           class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg transition-colors text-center font-medium">
                            Modifica
                        </a>
                        <form action="{{ route('admin.cars.destroy', $car->id) }}"
                              method="POST"
                              class="flex-1"
                              onsubmit="return confirm('Eliminare questa auto?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition-colors font-medium">
                                Elimina
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-12 bg-white rounded-xl shadow-lg">
                <p class="text-gray-500 mb-4">Nessuna auto presente</p>
                <a href="{{ route('admin.cars.create') }}" 
                   class="inline-flex items-center text-blue-600 hover:text-blue-700 font-medium">
                    Aggiungi auto →
                </a>
            </div>
            @endforelse
        </div>

        {{-- Back to Dashboard --}}
        <div class="text-center mt-8">
            <a href="{{ route('admin.dashboard') }}"
               class="inline-flex items-center text-gray-600 hover:text-blue-600 font-medium transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Torna alla Dashboard
            </a>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Toggle filtri mobile
document.addEventListener('DOMContentLoaded', function() {
    const toggleBtn = document.getElementById('toggle-filters');
    const filterForm = document.getElementById('admin-filter-form');
    
    if (toggleBtn && filterForm) {
        toggleBtn.addEventListener('click', function() {
            filterForm.classList.toggle('hidden');
            this.textContent = filterForm.classList.contains('hidden') ? 'Mostra' : 'Nascondi';
        });
    }
});
</script>
@endpush

@endsection