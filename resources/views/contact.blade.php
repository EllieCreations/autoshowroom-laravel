@extends('layouts.app')

@section('title', 'Contatti | AMC-SRLS')

@section('content')

{{-- Header --}}
<section class="bg-gradient-to-r from-blue-900 to-blue-700 text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">Contattaci</h1>
        <p class="text-xl text-blue-100">Siamo qui per rispondere a tutte le tue domande</p>
    </div>
</section>

{{-- Banner Auto di Interesse --}}
@if(request('car_id'))
    @php
        $interestedCar = \App\Models\Car::with(['brand', 'images'])->find(request('car_id'));
    @endphp
    
    @if($interestedCar)
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8">
        <div class="bg-white rounded-2xl shadow-xl p-6 border-2 border-blue-500">
            <div class="flex items-center mb-3">
                <svg class="w-6 h-6 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <h3 class="text-lg font-bold text-gray-900">Stai richiedendo informazioni su:</h3>
            </div>
            <div class="flex items-center space-x-4">
                @if($interestedCar->images->first())
                <img src="{{ asset('storage/' . $interestedCar->images->first()->image_path) }}" 
                     alt="{{ $interestedCar->brand->name ?? '' }} {{ $interestedCar->model }}"
                     class="w-24 h-24 rounded-lg object-cover border-2 border-gray-200">
                @endif
                <div class="flex-1">
                    <h4 class="text-xl font-bold text-gray-900">
                        {{ $interestedCar->brand->name ?? 'Auto' }} {{ $interestedCar->model }}
                    </h4>
                    <div class="flex items-center space-x-4 text-sm text-gray-600 mt-1">
                        <span>Anno {{ $interestedCar->year }}</span>
                        <span>•</span>
                        <span>{{ number_format($interestedCar->km, 0, ',', '.') }} km</span>
                        <span>•</span>
                        <span class="text-blue-600 font-semibold">€ {{ number_format($interestedCar->price, 0, ',', '.') }}</span>
                    </div>
                </div>
                <a href="{{ route('cars.show', $interestedCar->id) }}" 
                   class="text-blue-600 hover:text-blue-700 font-medium text-sm">
                    Vedi dettagli →
                </a>
            </div>
        </div>
    </section>
    @endif
@endif

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        
        {{-- Form Contatti --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-xl p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Invia un Messaggio</h2>

                {{-- Messaggio di Successo --}}
                @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-lg">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-green-700 font-medium">{{ session('success') }}</p>
                    </div>
                </div>
                @endif

                {{-- Messaggio di Errore --}}
                @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-lg">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-red-700 font-medium">{{ session('error') }}</p>
                    </div>
                </div>
                @endif

                <form action="/contact" method="POST" class="space-y-6">
                    @csrf

                    {{-- Campo Hidden per Car ID --}}
                    @if(request('car_id'))
                        <input type="hidden" name="car_id" value="{{ request('car_id') }}">
                    @endif

                    {{-- Nome --}}
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nome Completo *
                        </label>
                        <input type="text" 
                               id="name"
                               name="name" 
                               value="{{ old('name') }}"
                               placeholder="Mario Rossi"
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all @error('name') border-red-500 @enderror">
                        @error('name')
                        <p class="text-red-600 text-sm mt-1 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                            Email *
                        </label>
                        <input type="email" 
                               id="email"
                               name="email" 
                               value="{{ old('email') }}"
                               placeholder="mario.rossi@example.com"
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all @error('email') border-red-500 @enderror">
                        @error('email')
                        <p class="text-red-600 text-sm mt-1 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    {{-- Telefono (opzionale) --}}
                    <div>
                        <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                            Telefono <span class="text-gray-400 font-normal">(opzionale)</span>
                        </label>
                        <input type="tel" 
                               id="phone"
                               name="phone" 
                               value="{{ old('phone') }}"
                               placeholder="+39 XXX XXX XXXX"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                    </div>

                    {{-- Oggetto --}}
                    <div>
                        <label for="subject" class="block text-sm font-semibold text-gray-700 mb-2">
                            Oggetto
                        </label>
                        <select id="subject"
                                name="subject"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                            <option value="info" {{ old('subject') == 'info' ? 'selected' : '' }}>Richiesta informazioni</option>
                            <option value="test_drive" {{ old('subject') == 'test_drive' ? 'selected' : '' }}>Prenotazione test drive</option>
                            <option value="valutazione" {{ old('subject') == 'valutazione' ? 'selected' : '' }}>Valutazione auto usata</option>
                            <option value="finanziamento" {{ old('subject') == 'finanziamento' ? 'selected' : '' }}>Finanziamento</option>
                            <option value="altro" {{ old('subject') == 'altro' ? 'selected' : '' }}>Altro</option>
                        </select>
                    </div>

                    {{-- Messaggio --}}
                    <div>
                        <label for="message" class="block text-sm font-semibold text-gray-700 mb-2">
                            Messaggio *
                        </label>
                        @php
                            $defaultMessage = old('message');
                            if (!$defaultMessage && request('car_id') && isset($interestedCar)) {
                                $defaultMessage = "Buongiorno,\n\nSono interessato/a al veicolo {$interestedCar->brand->name} {$interestedCar->model} ({$interestedCar->year}) in vendita a € " . number_format($interestedCar->price, 0, ',', '.') . ".\n\nVorrei ricevere maggiori informazioni riguardo:\n- Condizioni del veicolo\n- Disponibilità per un test drive\n- Documentazione e garanzie\n\nGrazie per la disponibilità.\n\nCordiali saluti";
                            }
                        @endphp
                        <textarea id="message"
                                  name="message" 
                                  rows="8"
                                  required
                                  placeholder="Scrivi qui il tuo messaggio..."
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all resize-none @error('message') border-red-500 @enderror">{{ $defaultMessage }}</textarea>
                        @error('message')
                        <p class="text-red-600 text-sm mt-1 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    {{-- Privacy --}}
                    <div class="flex items-start">
                        <input type="checkbox" 
                               id="privacy"
                               name="privacy"
                               required
                               class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500 mt-0.5">
                        <label for="privacy" class="ml-3 text-sm text-gray-600">
                            Accetto il trattamento dei dati personali secondo la 
                            <a href="#" class="text-blue-600 hover:text-blue-700 underline">Privacy Policy</a> *
                        </label>
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit" 
                            class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white px-8 py-4 rounded-lg font-semibold text-lg hover:from-blue-700 hover:to-blue-800 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl flex items-center justify-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Invia Messaggio
                    </button>
                </form>
            </div>
        </div>

        {{-- Informazioni Contatto --}}
        <div class="space-y-6">
            {{-- Info Card --}}
            <div class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-2xl shadow-xl p-8 text-white">
                <h3 class="text-2xl font-bold mb-6">Informazioni di Contatto</h3>
                
                <div class="space-y-5">
                    {{-- Indirizzo --}}
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold mb-1">Indirizzo</p>
                            <p class="text-blue-100">Via Example 123<br>20100 Milano, Italia</p>
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold mb-1">Email</p>
                            <a href="mailto:info@amc-srls.it" class="text-blue-100 hover:text-white transition-colors">
                                info@amc-srls.it
                            </a>
                        </div>
                    </div>

                    {{-- Telefono --}}
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold mb-1">Telefono</p>
                            <a href="tel:+39XXXXXXXXX" class="text-blue-100 hover:text-white transition-colors">
                                +39 XXX XXX XXXX
                            </a>
                        </div>
                    </div>

                    {{-- Orari --}}
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold mb-1">Orari di Apertura</p>
                            <p class="text-blue-100 text-sm">
                                Lun - Ven: 9:00 - 19:00<br>
                                Sabato: 9:00 - 13:00<br>
                                Domenica: Chiuso
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Social Media --}}
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Seguici sui Social</h3>
                <div class="flex space-x-3">
                    <a href="#" class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center hover:from-blue-600 hover:to-blue-700 transform hover:scale-110 transition-all duration-200 shadow-md">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>
                    <a href="#" class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center hover:from-blue-600 hover:to-blue-700 transform hover:scale-110 transition-all duration-200 shadow-md">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </a>
                    <a href="#" class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center hover:from-blue-600 hover:to-blue-700 transform hover:scale-110 transition-all duration-200 shadow-md">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                        </svg>
                    </a>
                </div>
            </div>

            {{-- CTA Rapido --}}
            <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl p-6 border-2 border-gray-200">
                <h3 class="text-lg font-bold text-gray-900 mb-3">Hai Bisogno di Aiuto Immediato?</h3>
                <p class="text-gray-600 text-sm mb-4">Chiamaci subito per parlare con un nostro consulente</p>
                <a href="tel:+39XXXXXXXXX" 
                   class="w-full flex items-center justify-center bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    Chiamaci Ora
                </a>
            </div>
        </div>
    </div>
</section>

{{-- Mappa (opzionale) --}}
<section class="bg-gray-100 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2970.024749755986!2d9.189982!3d45.464664!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNDXCsDI3JzUyLjgiTiA5wrAxMScyNC4wIkU!5e0!3m2!1sit!2sit!4v1234567890" 
                    width="100%" 
                    height="400" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade"
                    class="grayscale hover:grayscale-0 transition-all duration-300">
            </iframe>
        </div>
    </div>
</section>

@endsection

@push('scripts')
{{-- Google reCAPTCHA v3 --}}
<script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form[action="/contact"]');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            grecaptcha.ready(function() {
                grecaptcha.execute('{{ config('services.recaptcha.site_key') }}', {action: 'contact'})
                    .then(function(token) {
                        // Aggiungi il token al form
                        let input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'recaptcha_token';
                        input.value = token;
                        form.appendChild(input);
                        
                        // Invia il form
                        form.submit();
                    });
            });
        });
    }
});
</script>
@endpush