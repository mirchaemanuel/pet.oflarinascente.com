<nav class="bg-white shadow-sm sticky top-0 z-50" x-data="{ mobileMenuOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo/Brand -->
            <div class="flex-shrink-0">
                <a href="{{ route('home') }}" class="text-2xl font-semibold text-primary">
                    La Rinascente Pet
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex md:items-center md:gap-8">
                <a href="{{ route('home') }}" class="text-gray-700 hover:text-primary transition-colors duration-200 {{ request()->routeIs('home') ? 'text-primary font-medium' : '' }}">
                    Home
                </a>
                <a href="{{ route('memorials.index') }}" class="text-gray-700 hover:text-primary transition-colors duration-200 {{ request()->routeIs('memorials.*') ? 'text-primary font-medium' : '' }}">
                    Memoriali
                </a>
                <a href="{{ route('services.index') }}" class="text-gray-700 hover:text-primary transition-colors duration-200 {{ request()->routeIs('services.*') ? 'text-primary font-medium' : '' }}">
                    Servizi
                </a>
                <a href="{{ route('blog.index') }}" class="text-gray-700 hover:text-primary transition-colors duration-200 {{ request()->routeIs('blog.*') ? 'text-primary font-medium' : '' }}">
                    Blog
                </a>
                <a href="{{ route('contact') }}" class="text-gray-700 hover:text-primary transition-colors duration-200 {{ request()->routeIs('contact') ? 'text-primary font-medium' : '' }}">
                    Contatti
                </a>
            </div>

            <!-- Mobile Menu Button -->
            <div class="md:hidden">
                <button
                    @click="mobileMenuOpen = !mobileMenuOpen"
                    type="button"
                    class="text-gray-700 hover:text-primary focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 rounded-md p-2"
                    aria-label="Menu principale"
                >
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div
        x-show="mobileMenuOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-1"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-1"
        class="md:hidden border-t border-gray-200"
        style="display: none;"
    >
        <div class="px-2 pt-2 pb-3 space-y-1">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-primary hover:bg-gray-50 {{ request()->routeIs('home') ? 'text-primary bg-gray-50' : '' }}">
                Home
            </a>
            <a href="{{ route('memorials.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-primary hover:bg-gray-50 {{ request()->routeIs('memorials.*') ? 'text-primary bg-gray-50' : '' }}">
                Memoriali
            </a>
            <a href="{{ route('services.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-primary hover:bg-gray-50 {{ request()->routeIs('services.*') ? 'text-primary bg-gray-50' : '' }}">
                Servizi
            </a>
            <a href="{{ route('blog.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-primary hover:bg-gray-50 {{ request()->routeIs('blog.*') ? 'text-primary bg-gray-50' : '' }}">
                Blog
            </a>
            <a href="{{ route('contact') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-primary hover:bg-gray-50 {{ request()->routeIs('contact') ? 'text-primary bg-gray-50' : '' }}">
                Contatti
            </a>
        </div>
    </div>
</nav>
