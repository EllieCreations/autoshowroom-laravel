@extends('layouts.app')

@section('title', 'Modifica Auto | Admin AMC-SRLS')

@section('content')

<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">
                Modifica: {{ $car->brand->name ?? '-' }} {{ $car->model }}
            </h1>
            <p class="text-gray-600">Aggiorna le informazioni dell'auto</p>
        </div>

        {{-- Messaggi --}}
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

        @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-lg shadow-md">
            <div class="flex">
                <svg class="w-6 h-6 text-red-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <p class="font-bold text-red-700 mb-2">Correggi i seguenti errori:</p>
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
        <form action="{{ route('admin.cars.update', $car->id) }}" method="POST" enctype="multipart/form-data" id="carForm" class="bg-white rounded-xl shadow-lg p-8">
            @csrf
            @method('PUT')

            {{-- Informazioni Principali --}}
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Informazioni Principali
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="brand_id" class="block text-sm font-semibold text-gray-700 mb-2">Marca *</label>
                        <select name="brand_id" id="brand_id" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}" {{ $car->brand_id == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="model" class="block text-sm font-semibold text-gray-700 mb-2">Modello *</label>
                        <input type="text" name="model" id="model" value="{{ old('model', $car->model) }}" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                    </div>

                    <div>
                        <label for="car_type_id" class="block text-sm font-semibold text-gray-700 mb-2">Tipo di Veicolo *</label>
                        <select name="car_type_id" id="car_type_id" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                            @foreach ($carTypes as $type)
                                <option value="{{ $type->id }}" {{ $car->car_type_id == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="fuel_type_id" class="block text-sm font-semibold text-gray-700 mb-2">Alimentazione *</label>
                        <select name="fuel_type_id" id="fuel_type_id" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                            @foreach ($fuelTypes as $fuel)
                                <option value="{{ $fuel->id }}" {{ $car->fuel_type_id == $fuel->id ? 'selected' : '' }}>
                                    {{ $fuel->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="transmission_id" class="block text-sm font-semibold text-gray-700 mb-2">Trasmissione *</label>
                        <select name="transmission_id" id="transmission_id" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                            @foreach ($transmissions as $tr)
                                <option value="{{ $tr->id }}" {{ $car->transmission_id == $tr->id ? 'selected' : '' }}>
                                    {{ $tr->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="car_condition" class="block text-sm font-semibold text-gray-700 mb-2">Condizione *</label>
                        <select name="car_condition" id="car_condition" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                            <option value="nuovo" {{ $car->car_condition == 'nuovo' ? 'selected' : '' }}>Nuovo</option>
                            <option value="usato" {{ $car->car_condition == 'usato' ? 'selected' : '' }}>Usato</option>
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
                    <div>
                        <label for="year" class="block text-sm font-semibold text-gray-700 mb-2">Anno *</label>
                        <input type="number" name="year" id="year" value="{{ old('year', $car->year) }}" required
                               min="1990" max="{{ date('Y') + 1 }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                    </div>

                    <div>
                        <label for="km" class="block text-sm font-semibold text-gray-700 mb-2">Chilometraggio (km) *</label>
                        <input type="number" name="km" id="km" value="{{ old('km', $car->km) }}" required
                               min="0"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                    </div>

                    <div>
                        <label for="price" class="block text-sm font-semibold text-gray-700 mb-2">Prezzo (€) *</label>
                        <input type="number" name="price" id="price" step="0.01" value="{{ old('price', $car->price) }}" required
                               min="0"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                    </div>

                    <div>
                        <label for="seats" class="block text-sm font-semibold text-gray-700 mb-2">Posti</label>
                        <input type="number" name="seats" id="seats" value="{{ old('seats', $car->seats) }}"
                               min="1" max="9"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                    </div>

                    <div>
                        <label for="power_kw" class="block text-sm font-semibold text-gray-700 mb-2">Potenza (kW)</label>
                        <input type="number" name="power_kw" id="power_kw" value="{{ old('power_kw', $car->power_kw) }}"
                               min="0"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                    </div>

                    <div class="flex items-center mt-8">
                        <input type="checkbox" name="highlighted" id="highlighted" value="1" 
                               {{ $car->highlighted ? 'checked' : '' }}
                               class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                        <label for="highlighted" class="ml-3 text-sm font-semibold text-gray-700">
                            Mostra in evidenza
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
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all resize-none">{{ old('description', $car->description) }}</textarea>
            </div>

            {{-- Immagini Esistenti --}}
            @if($car->images->count() > 0)
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Immagini Esistenti
                </h2>
                <p class="text-sm text-gray-600 mb-4">Trascina le immagini per riordinarle</p>
                <div id="existingImages" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                    @foreach ($car->images->sortBy('position') as $image)
                    <div class="relative group cursor-move rounded-lg overflow-hidden border-2 border-gray-200 hover:border-blue-500 transition-all" 
                         data-id="{{ $image->id }}">
                        <img src="{{ $image->image_path }}" 
                             alt="Immagine auto"
                             class="w-full h-40 object-cover">
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition-all flex items-center justify-center">
                            <button type="button"
                                    onclick="deleteImage({{ $image->id }})"
                                    class="opacity-0 group-hover:opacity-100 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition-all transform scale-90 group-hover:scale-100">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Aggiungi Nuove Immagini --}}
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Aggiungi Nuove Immagini
                </h2>
                <div id="carDropzone" 
                     class="dropzone border-2 border-dashed border-blue-300 rounded-lg p-8 bg-blue-50 text-center hover:border-blue-500 hover:bg-blue-100 transition-all cursor-pointer">
                    <svg class="w-12 h-12 mx-auto text-blue-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                    <p class="text-gray-600 font-medium mb-1">Trascina qui le immagini o clicca per selezionarle</p>
                    <p class="text-sm text-gray-500">Massimo 10 immagini, max 8MB ciascuna</p>
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
                    Salva Modifiche
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Scripts --}}
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css">
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", () => {
    // Rimuovi istanze precedenti di Dropzone
    if (Dropzone.instances.length > 0) {
        Dropzone.instances.forEach(instance => instance.destroy());
    }

    // Inizializza Dropzone
    const carDropzone = new Dropzone("#carDropzone", {
        url: "{{ route('admin.cars.upload') }}",
        paramName: "file",
        params: { car_id: {{ $car->id }} },
        maxFilesize: 8,
        maxFiles: 10,
        acceptedFiles: "image/*",
        addRemoveLinks: true,
        dictDefaultMessage: "",
        dictRemoveFile: "Rimuovi",
        headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
        init: function() {
            this.on("success", function(file, response) {
                console.log("✅ Upload OK:", response);
                location.reload(); // Ricarica per mostrare la nuova immagine
            });
            this.on("error", function(file, message) {
                console.error("❌ Errore:", message);
                alert("Errore caricamento: " + (message.error || message));
            });
        }
    });

    // Sortable per riordinare immagini
    const el = document.getElementById("existingImages");
    if (el) {
        new Sortable(el, {
            animation: 150,
            ghostClass: "opacity-50",
            onEnd: function() {
                const order = Array.from(el.children).map(div => div.dataset.id);
                fetch('{{ route("admin.cars.reorderImages") }}', {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({ order })
                })
                .then(res => res.json())
                .then(data => console.log("✅ Ordine aggiornato"))
                .catch(err => console.error("Errore:", err));
            }
        });
    }

    // Funzione elimina immagine
    window.deleteImage = function(id) {
        if (!confirm('Eliminare questa immagine?')) return;
        
        fetch('{{ route("admin.cars.deleteImage", ":id") }}'.replace(':id', id), {
            method: "DELETE",
            headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" }
        }).then(r => {
            if (r.ok) location.reload();
        });
    };
});
</script>

@endsection