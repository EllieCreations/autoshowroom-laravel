<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin | AMC-SRLS</title>
    @vite('resources/css/app.css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
    </style>
</head>

<body class="bg-gradient-to-br from-blue-900 via-blue-800 to-gray-900 min-h-screen flex items-center justify-center p-4">
    
    {{-- Background decorativo --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 left-20 w-72 h-72 bg-blue-500 rounded-full filter blur-3xl opacity-20 animate-pulse"></div>
        <div class="absolute bottom-20 right-20 w-96 h-96 bg-purple-500 rounded-full filter blur-3xl opacity-20 animate-pulse" style="animation-delay: 1s;"></div>
    </div>

    <div class="relative w-full max-w-md">
        
        {{-- Logo e Link al sito --}}
        <div class="text-center mb-8">
            <a href="/" class="inline-flex items-center space-x-3 group mb-6">
                <div class="w-12 h-12 bg-white rounded-lg flex items-center justify-center transform group-hover:scale-110 transition-transform duration-300 shadow-lg">
                    <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <div class="text-left">
                    <div class="text-2xl font-bold text-white">AMC-SRLS</div>
                    <div class="text-xs text-blue-200">Auto Showroom</div>
                </div>
            </a>
        </div>

        {{-- Card Login --}}
        <div class="bg-white rounded-2xl shadow-2xl p-8 backdrop-blur-sm">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Accesso Admin</h1>
                <p class="text-gray-600">Inserisci le tue credenziali per accedere</p>
            </div>

            {{-- Errori --}}
            @error('login')
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-lg">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-red-700 font-medium">{{ $message }}</p>
                </div>
            </div>
            @enderror

            {{-- Form --}}
            <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-6">
                @csrf

                {{-- Username --}}
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                        Username
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <input type="text" 
                               id="username"
                               name="username" 
                               value="{{ old('username') }}"
                               placeholder="Inserisci username"
                               required
                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                    </div>
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Password
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <input type="password" 
                               id="password"
                               name="password" 
                               placeholder="Inserisci password"
                               required
                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                    </div>
                </div>

                {{-- Remember Me (opzionale) --}}
                <div class="flex items-center">
                    <input type="checkbox" 
                           id="remember"
                           name="remember"
                           class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                    <label for="remember" class="ml-2 text-sm text-gray-600">
                        Ricordami
                    </label>
                </div>

                {{-- Submit Button --}}
                <button type="submit" 
                        class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-3 rounded-lg font-semibold text-lg hover:from-blue-700 hover:to-blue-800 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                    </svg>
                    Accedi
                </button>
            </form>

            {{-- Divider --}}
            <div class="mt-8 pt-6 border-t border-gray-200">
                <a href="/" 
                   class="flex items-center justify-center text-gray-600 hover:text-blue-600 font-medium transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Torna al sito
                </a>
            </div>
        </div>

        {{-- Info Footer --}}
        <div class="mt-8 text-center text-sm text-blue-100">
            <p class="mb-2">Accesso riservato allo staff AMC-SRLS</p>
            <p>
                Hai bisogno di assistenza? 
                <a href="mailto:info@amc-srls.it" class="text-white hover:underline font-medium">
                    Contatta il supporto
                </a>
            </p>
        </div>
    </div>

</body>
</html>