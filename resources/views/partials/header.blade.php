<header class="bg-white shadow-lg sticky top-0 z-50 border-b-2 border-blue-500">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            
            {{-- Logo --}}
            <a href="/" class="flex items-center space-x-3 group">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-blue-800 rounded-lg flex items-center justify-center transform group-hover:scale-105 transition-transform duration-300">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <div>
                    <div class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent">
                        AMC-SRLS
                    </div>
                    <div class="text-xs text-gray-500 -mt-1">Auto Showroom</div>
                </div>
            </a>

            {{-- Navigation Desktop --}}
            <nav class="hidden md:flex items-center space-x-8">
                <a href="/" 
                   class="text-gray-700 hover:text-blue-600 font-medium transition-colors duration-200 relative group">
                    Home
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 group-hover:w-full transition-all duration-300"></span>
                </a>
                <a href="/inventory" 
                   class="text-gray-700 hover:text-blue-600 font-medium transition-colors duration-200 relative group">
                    Inventario
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 group-hover:w-full transition-all duration-300"></span>
                </a>
                <a href="/contact" 
                   class="text-gray-700 hover:text-blue-600 font-medium transition-colors duration-200 relative group">
                    Contatti
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 group-hover:w-full transition-all duration-300"></span>
                </a>
                <a href="/contact" 
                   class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-2.5 rounded-lg font-medium hover:from-blue-700 hover:to-blue-800 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg">
                    Richiedi Info
                </a>
            </nav>

            {{-- Mobile Menu Button --}}
            <button id="menu-toggle" class="md:hidden text-gray-700 hover:text-blue-600 focus:outline-none">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path id="menu-icon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>

        {{-- Mobile Menu --}}
        <div id="mobile-menu" class="hidden md:hidden pb-4 border-t border-gray-100 mt-2">
            <div class="flex flex-col space-y-3 pt-4">
                <a href="/" 
                   class="text-gray-700 hover:text-blue-600 hover:bg-blue-50 px-4 py-2 rounded-lg font-medium transition-all duration-200">
                    Home
                </a>
                <a href="/inventory" 
                   class="text-gray-700 hover:text-blue-600 hover:bg-blue-50 px-4 py-2 rounded-lg font-medium transition-all duration-200">
                    Inventario
                </a>
                <a href="/contact" 
                   class="text-gray-700 hover:text-blue-600 hover:bg-blue-50 px-4 py-2 rounded-lg font-medium transition-all duration-200">
                    Contatti
                </a>
                <a href="/contact" 
                   class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-4 py-2.5 rounded-lg font-medium text-center hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-md">
                    Richiedi Info
                </a>
            </div>
        </div>
    </div>
</header>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.getElementById('menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');
    const menuIcon = document.getElementById('menu-icon');
    
    menuToggle.addEventListener('click', function() {
        mobileMenu.classList.toggle('hidden');
        
        // Cambia icona hamburger -> X
        if (mobileMenu.classList.contains('hidden')) {
            menuIcon.setAttribute('d', 'M4 6h16M4 12h16M4 18h16');
        } else {
            menuIcon.setAttribute('d', 'M6 18L18 6M6 6l12 12');
        }
    });
});
</script>