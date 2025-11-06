<nav class="bg-gradient-to-r from-gray-900 via-gray-800 to-gray-900 text-white shadow-xl sticky top-0 z-50 border-b-2 border-blue-500">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            
            {{-- Logo/Brand --}}
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <div class="hidden sm:block">
                    <div class="text-lg font-bold">Admin Panel</div>
                    <div class="text-xs text-gray-400 -mt-1">AMC-SRLS</div>
                </div>
            </div>

            {{-- Navigation Desktop --}}
            <div class="hidden md:flex items-center space-x-1">
                <a href="{{ route('admin.dashboard') }}"
                   class="px-4 py-2 rounded-lg font-medium transition-all duration-200
                          {{ request()->routeIs('admin.dashboard') 
                             ? 'bg-blue-600 text-white' 
                             : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Dashboard
                    </span>
                </a>

                <a href="{{ route('admin.cars.index') }}"
                   class="px-4 py-2 rounded-lg font-medium transition-all duration-200
                          {{ request()->routeIs('admin.cars.index') || request()->routeIs('admin.cars.edit') 
                             ? 'bg-blue-600 text-white' 
                             : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                        </svg>
                        Gestisci Auto
                    </span>
                </a>

                <a href="{{ route('admin.cars.create') }}"
                   class="px-4 py-2 rounded-lg font-medium transition-all duration-200
                          {{ request()->routeIs('admin.cars.create') 
                             ? 'bg-blue-600 text-white' 
                             : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Aggiungi Auto
                    </span>
                </a>
            </div>

            {{-- Right Section --}}
            <div class="flex items-center space-x-3">
                {{-- View Site Button --}}
                <a href="/" target="_blank"
                   class="hidden sm:flex items-center text-gray-300 hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                </a>

                {{-- Logout Button --}}
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button class="flex items-center bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition-colors shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        <span class="hidden sm:inline">Esci</span>
                    </button>
                </form>

                {{-- Mobile Menu Button --}}
                <button id="mobile-menu-btn" class="md:hidden text-gray-300 hover:text-white focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path id="menu-icon-mobile" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div id="mobile-menu" class="hidden md:hidden pb-4 border-t border-gray-700 mt-2">
            <div class="flex flex-col space-y-2 pt-4">
                <a href="{{ route('admin.dashboard') }}"
                   class="px-4 py-3 rounded-lg font-medium transition-colors
                          {{ request()->routeIs('admin.dashboard') 
                             ? 'bg-blue-600 text-white' 
                             : 'text-gray-300 hover:bg-gray-700' }}">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Dashboard
                    </span>
                </a>

                <a href="{{ route('admin.cars.index') }}"
                   class="px-4 py-3 rounded-lg font-medium transition-colors
                          {{ request()->routeIs('admin.cars.index') || request()->routeIs('admin.cars.edit')
                             ? 'bg-blue-600 text-white' 
                             : 'text-gray-300 hover:bg-gray-700' }}">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                        </svg>
                        Gestisci Auto
                    </span>
                </a>

                <a href="{{ route('admin.cars.create') }}"
                   class="px-4 py-3 rounded-lg font-medium transition-colors
                          {{ request()->routeIs('admin.cars.create') 
                             ? 'bg-blue-600 text-white' 
                             : 'text-gray-300 hover:bg-gray-700' }}">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Aggiungi Auto
                    </span>
                </a>

                <a href="/" target="_blank"
                   class="px-4 py-3 rounded-lg font-medium text-gray-300 hover:bg-gray-700 transition-colors">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                        Visualizza Sito
                    </span>
                </a>
            </div>
        </div>
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const menuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    const menuIcon = document.getElementById('menu-icon-mobile');
    
    if (menuBtn && mobileMenu) {
        menuBtn.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
            
            // Cambia icona
            if (mobileMenu.classList.contains('hidden')) {
                menuIcon.setAttribute('d', 'M4 6h16M4 12h16M4 18h16');
            } else {
                menuIcon.setAttribute('d', 'M6 18L18 6M6 6l12 12');
            }
        });
    }
});
</script>