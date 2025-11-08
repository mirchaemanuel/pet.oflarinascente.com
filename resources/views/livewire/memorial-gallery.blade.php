<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Header -->
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">Cimitero Virtuale</h1>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto">
            Onoriamo la memoria dei nostri amici che ci hanno lasciato
        </p>
    </div>

    <!-- Search Bar -->
    <div class="mb-8">
        <div class="max-w-xl mx-auto">
            <label for="search" class="sr-only">Cerca un memoriale</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input
                    type="text"
                    id="search"
                    wire:model.live="search"
                    placeholder="Cerca per nome, dedica o storia..."
                    class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"
                >
            </div>
        </div>
    </div>

    <!-- Species Filter -->
    @if(count($this->availableSpecies) > 0)
        <div class="mb-8">
            <div class="flex flex-wrap justify-center gap-2">
                <button
                    wire:click="filterBySpecies(null)"
                    class="px-4 py-2 rounded-full transition-all duration-200 {{ $species === null ? 'bg-primary text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}"
                >
                    Tutti
                </button>
                @foreach($this->availableSpecies as $speciesOption)
                    <button
                        wire:click="filterBySpecies(@js($speciesOption))"
                        class="px-4 py-2 rounded-full transition-all duration-200 {{ $species === $speciesOption ? 'bg-primary text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}"
                    >
                        {{ $speciesOption->getLabel() }}
                    </button>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Loading State -->
    <div wire:loading class="text-center py-8">
        <div class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-gray-300 border-t-primary"></div>
        <p class="mt-2 text-gray-600">Caricamento...</p>
    </div>

    <!-- Memorial Grid -->
    <div wire:loading.remove>
        @if($this->memorials->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach($this->memorials as $memorial)
                    <a
                        href="{{ route('memorials.show', $memorial) }}"
                        class="bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-lg transition-shadow duration-200"
                        wire:key="memorial-{{ $memorial->id }}"
                    >
                        <!-- Photo -->
                        <div class="aspect-square bg-gray-200 flex items-center justify-center overflow-hidden">
                            @if($memorial->primary_photo)
                                <img
                                    src="{{ $memorial->primary_photo->url }}"
                                    alt="{{ $memorial->name }}"
                                    class="w-full h-full object-cover"
                                >
                            @else
                                <svg class="h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            @endif
                        </div>

                        <!-- Content -->
                        <div class="p-4">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="font-semibold text-gray-900 text-lg">{{ $memorial->name }}</h3>
                                <span class="text-sm bg-gray-100 px-2 py-1 rounded">
                                    {{ $memorial->species->getLabel() }}
                                </span>
                            </div>

                            @if($memorial->death_date)
                                <p class="text-sm text-gray-600 mb-3">
                                    @if($memorial->birth_date)
                                        {{ $memorial->birth_date->format('Y') }} - {{ $memorial->death_date->format('Y') }}
                                    @else
                                        {{ $memorial->death_date->format('d/m/Y') }}
                                    @endif
                                </p>
                            @endif

                            <div class="flex items-center gap-4 text-sm text-gray-500">
                                <span class="flex items-center gap-1">
                                    <svg class="h-4 w-4 text-heart" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                    </svg>
                                    {{ $memorial->hearts_count ?? 0 }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <svg class="h-4 w-4 text-candle" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"/>
                                    </svg>
                                    {{ $memorial->candles_count ?? 0 }}
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $this->memorials->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Nessun memoriale trovato</h3>
                <p class="mt-1 text-sm text-gray-500">
                    @if($search || $species)
                        Prova a modificare i filtri di ricerca.
                    @else
                        Non ci sono ancora memoriali pubblicati.
                    @endif
                </p>
                @if($search || $species)
                    <div class="mt-6">
                        <button
                            wire:click="$set('search', ''); filterBySpecies(null)"
                            class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary hover:bg-opacity-90"
                        >
                            Rimuovi filtri
                        </button>
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>
