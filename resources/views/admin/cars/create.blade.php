@extends('layouts.app')

@section('title', 'Aggiungi Auto | Admin AMC-SRLS')

@section('content')

<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- 🆕 Breadcrumbs --}}
        <nav class="mb-4 flex items-center text-sm text-gray-600">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600 transition-colors">Dashboard</a>
            <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <a href="{{ route('admin.cars.index') }}" class="hover:text-blue-600 transition-colors">Auto</a>
            <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-gray-900 font-medium">Aggiungi Nuova</span>
        </nav>
        
        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Aggiungi Nuova Auto</h1>
            <p class="text-gray-600">Compila tutti i campi per aggiungere un'auto al catalogo</p>
        </div>

        {{-- Errori Validazione --}}
        @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-lg shadow-md">
            <div class="flex">
                <svg class="w-6 h-6 text-red-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <p class="font-bold text-red-700 mb-2">Attenzione! Correggi i seguenti errori:</p>
                    <ul class="list-disc pl-5 text-red-600 text-sm space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif

        {{-- Form --}}
        <form action="{{ route('admin.cars.store') }}" method="POST" enctype="multipart/form-data" id="carForm" class="bg-white rounded-xl shadow-lg p-8">
            @csrf

            {{-- Informazioni Principali --}}
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Informazioni Principali
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Marca --}}
                    <div>
                        <label for="brand_id" class="block text-sm font-semibold text-gray-700 mb-2">Marca *</label>
                        <select name="brand_id" id="brand_id" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                            <option value="">Seleziona marca</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Modello --}}
                    <div>
                        <label for="model" class="block text-sm font-semibold text-gray-700 mb-2">Modello *</label>
                        <input type="text" name="model" id="model" value="{{ old('model') }}" required
                               placeholder="Es: Serie 3"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                    </div>

                    {{-- Tipo Auto --}}
                    <div>
                        <label for="car_type_id" class="block text-sm font-semibold text-gray-700 mb-2">Tipo di Veicolo *</label>
                        <select name="car_type_id" id="car_type_id" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                            <option value="">Seleziona tipo</option>
                            @foreach ($carTypes as $type)
                                <option value="{{ $type->id }}" {{ old('car_type_id') == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Carburante --}}
                    <div>
                        <label for="fuel_type_id" class="block text-sm font-semibold text-gray-700 mb-2">Alimentazione *</label>
                        <select name="fuel_type_id" id="fuel_type_id" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                            <option value="">Seleziona carburante</option>
                            @foreach ($fuelTypes as $fuel)
                                <option value="{{ $fuel->id }}" {{ old('fuel_type_id') == $fuel->id ? 'selected' : '' }}>
                                    {{ $fuel->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Trasmissione --}}
                    <div>
                        <label for="transmission_id" class="block text-sm font-semibold text-gray-700 mb-2">Trasmissione *</label>
                        <select name="transmission_id" id="transmission_id" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                            <option value="">Seleziona trasmissione</option>
                            @foreach ($transmissions as $tr)
                                <option value="{{ $tr->id }}" {{ old('transmission_id') == $tr->id ? 'selected' : '' }}>
                                    {{ $tr->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Condizione --}}
                    <div>
                        <label for="car_condition" class="block text-sm font-semibold text-gray-700 mb-2">Condizione *</label>
                        <select name="car_condition" id="car_condition" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                            <option value="nuovo" {{ old('car_condition') == 'nuovo' ? 'selected' : '' }}>Nuovo</option>
                            <option value="usato" {{ old('car_condition') == 'usato' ? 'selected' : '' }}>Usato</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- Dettagli Tecnici --}}
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    Dettagli Tecnici
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    {{-- Anno --}}
                    <div>
                        <label for="year" class="block text-sm font-semibold text-gray-700 mb-2">Anno *</label>
                        <input type="number" name="year" id="year" value="{{ old('year', date('Y')) }}" required
                               min="1990" max="{{ date('Y') + 1 }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                    </div>

                    {{-- Chilometraggio --}}
                    <div>
                        <label for="km" class="block text-sm font-semibold text-gray-700 mb-2">Chilometraggio (km) *</label>
                        <input type="number" name="km" id="km" value="{{ old('km', 0) }}" required
                               min="0" placeholder="0"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                    </div>

                    {{-- Prezzo --}}
                    <div>
                        <label for="price" class="block text-sm font-semibold text-gray-700 mb-2">Prezzo (€) *</label>
                        <input type="number" name="price" id="price" step="0.01" value="{{ old('price') }}" required
                               min="0" placeholder="25000.00"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                    </div>

                    {{-- Posti --}}
                    <div>
                        <label for="seats" class="block text-sm font-semibold text-gray-700 mb-2">Posti</label>
                        <input type="number" name="seats" id="seats" value="{{ old('seats', 5) }}"
                               min="1" max="9" placeholder="5"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                    </div>

                    {{-- Potenza --}}
                    <div>
                        <label for="power_kw" class="block text-sm font-semibold text-gray-700 mb-2">Potenza (kW)</label>
                        <input type="number" name="power_kw" id="power_kw" value="{{ old('power_kw') }}"
                               min="0" placeholder="150"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                    </div>

                    {{-- Evidenziata --}}
                    <div class="flex items-center mt-8">
                        <input type="checkbox" name="highlighted" id="highlighted" value="1" 
                               {{ old('highlighted') ? 'checked' : '' }}
                               class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                        <label for="highlighted" class="ml-3 text-sm font-semibold text-gray-700">
                            Mostra in evidenza sulla home
                        </label>
                    </div>
                </div>
            </div>

            {{-- Descrizione --}}
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                    </svg>
                    Descrizione
                </h2>
                <textarea name="description" id="description" rows="5" 
                          placeholder="Inserisci una descrizione dettagliata dell'auto..."
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all resize-none">{{ old('description') }}</textarea>
            </div>

            {{-- Upload Immagini --}}
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Carica Immagini
                </h2>
                <div id="carDropzone" 
                     class="dropzone border-2 border-dashed border-blue-300 rounded-lg p-8 bg-blue-50 text-center hover:border-blue-500 hover:bg-blue-100 transition-all cursor-pointer">
                    <svg class="w-12 h-12 mx-auto text-blue-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                    <p class="text-gray-600 font-medium mb-1">Trascina qui le immagini o clicca per selezionarle</p>
                    <p class="text-sm text-gray-500">Massimo 10 immagini, max 8MB ciascuna (JPG, PNG, WEBP)</p>
                </div>
            </div>

            {{-- Pulsanti --}}
            <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.cars.index') }}" 
                   class="flex-1 inline-flex items-center justify-center bg-gray-200 text-gray-700 px-6 py-3 rounded-lg font-semibold hover:bg-gray-300 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Annulla
                </a>
                <button type="submit" 
                        class="flex-1 inline-flex items-center justify-center bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-3 rounded-lg font-semibold hover:from-blue-700 hover:to-blue-800 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Salva Auto
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Dropzone Script --}}
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css">
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>

<script>
Dropzone.autoDiscover = false;

document.addEventListener('DOMContentLoaded', function() {
    const carDropzone = new Dropzone("#carDropzone", {
        url: "{{ route('admin.cars.upload') }}",
        paramName: "file",
        maxFilesize: 8,
        maxFiles: 10,
        acceptedFiles: "image/*",
        addRemoveLinks: true,
        dictDefaultMessage: "",
        dictRemoveFile: "Rimuovi",
        dictCancelUpload: "Annulla",
        headers: { 
            "X-CSRF-TOKEN": "{{ csrf_token() }}" 
        },
        init: function() {
            this.on("success", function(file, response) {
                console.log("✅ Upload riuscito:", response);
                const input = document.createElement("input");
                input.type = "hidden";
                input.name = "temp_images[]";
                input.value = response.filename;
                input.setAttribute("data-filename", response.filename);
                document.getElementById("carForm").appendChild(input);
            });
            
            this.on("removedfile", function(file) {
                if (file.xhr) {
                    const response = JSON.parse(file.xhr.responseText);
                    const inputs = document.querySelectorAll('input[data-filename="' + response.filename + '"]');
                    inputs.forEach(input => input.remove());
                }
            });
            
            this.on("error", function(file, message) {
                console.error("❌ Errore upload:", message);
                alert("Errore durante il caricamento: " + (message.error || message));
            });
        }
    });
});
</script>

@endsection