@extends('layouts.app')

@section('title', 'La Rinascente Pet - Onoranze Funebri per Animali')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-b from-gray-100 to-white py-20 lg:py-32">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-gray-900 mb-6">
                Ama fino alla fine chi ti ha amato incondizionatamente
            </h1>
            <p class="text-xl sm:text-2xl text-gray-600 mb-8 max-w-3xl mx-auto">
                Servizi funebri dedicati agli animali domestici.
                Onoriamo la memoria dei vostri compagni fedeli con rispetto e amore.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('services.index') }}" class="inline-block px-8 py-3 bg-primary text-white rounded-lg hover:bg-opacity-90 transition-all duration-200 font-medium">
                    Scopri i Nostri Servizi
                </a>
                <a href="{{ route('memorials.index') }}" class="inline-block px-8 py-3 bg-white text-primary border-2 border-primary rounded-lg hover:bg-primary hover:text-white transition-all duration-200 font-medium">
                    Visita i Memoriali
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Services Grid -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">
                I Nostri Servizi
            </h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Offriamo servizi completi per onorare la memoria del vostro amico a quattro zampe
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Service 1: Cremazione -->
            <div class="bg-gray-50 rounded-lg p-8 hover:shadow-lg transition-shadow duration-200">
                <div class="w-16 h-16 bg-candle/20 rounded-full flex items-center justify-center mb-6">
                    <svg class="h-8 w-8 text-candle" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Cremazione</h3>
                <p class="text-gray-600 mb-4">
                    Servizio di cremazione individuale o collettiva con la possibilità di conservare le ceneri in urne eleganti e personalizzate.
                </p>
                <a href="{{ route('services.index') }}" class="text-primary hover:text-secondary font-medium inline-flex items-center gap-2">
                    Scopri di più
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>

            <!-- Service 2: Sepoltura -->
            <div class="bg-gray-50 rounded-lg p-8 hover:shadow-lg transition-shadow duration-200">
                <div class="w-16 h-16 bg-secondary/20 rounded-full flex items-center justify-center mb-6">
                    <svg class="h-8 w-8 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Sepoltura</h3>
                <p class="text-gray-600 mb-4">
                    Servizio di sepoltura in cimiteri dedicati agli animali, con possibilità di lapidi personalizzate e cura perpetua del luogo.
                </p>
                <a href="{{ route('services.index') }}" class="text-primary hover:text-secondary font-medium inline-flex items-center gap-2">
                    Scopri di più
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>

            <!-- Service 3: Cimitero Virtuale -->
            <div class="bg-gray-50 rounded-lg p-8 hover:shadow-lg transition-shadow duration-200">
                <div class="w-16 h-16 bg-heart/20 rounded-full flex items-center justify-center mb-6">
                    <svg class="h-8 w-8 text-heart" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Cimitero Virtuale</h3>
                <p class="text-gray-600 mb-4">
                    Crea un memoriale online per il tuo amico, con foto, dediche e la possibilità per amici e familiari di lasciare ricordi.
                </p>
                <a href="{{ route('services.index') }}" class="text-primary hover:text-secondary font-medium inline-flex items-center gap-2">
                    Scopri di più
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Recent Memorials Section -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">
                Memoriali Recenti
            </h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Ricordiamo insieme i nostri amici che ci hanno lasciato
            </p>
        </div>

        @php
            $recentMemorials = \App\Models\Pet::published()
                ->with(['photos' => function($query) {
                    $query->orderBy('order');
                }])
                ->withCount(['heartReactions as hearts_count', 'virtualCandles as candles_count'])
                ->latest('published_at')
                ->take(4)
                ->get();
        @endphp

        @if($recentMemorials->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($recentMemorials as $memorial)
                    <a href="{{ route('memorials.show', $memorial) }}" class="bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-200">
                        <div class="aspect-square bg-gray-200 flex items-center justify-center overflow-hidden">
                            @if($memorial->photos->count() > 0)
                                @php
                                    $primaryPhoto = $memorial->photos->where('is_primary', true)->first() ?? $memorial->photos->first();
                                @endphp
                                <img
                                    src="{{ $primaryPhoto->url }}"
                                    alt="{{ $memorial->name }}"
                                    class="w-full h-full object-cover"
                                >
                            @else
                                <svg class="h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            @endif
                        </div>
                        <div class="p-4">
                            <h3 class="font-semibold text-gray-900 text-lg mb-1">{{ $memorial->name }}</h3>
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
        @else
            <div class="text-center py-12">
                <p class="text-gray-600">Non ci sono ancora memoriali pubblicati.</p>
            </div>
        @endif

        <div class="text-center mt-8">
            <a href="{{ route('memorials.index') }}" class="inline-block px-6 py-3 bg-primary text-white rounded-lg hover:bg-opacity-90 transition-all duration-200 font-medium">
                Vedi Tutti i Memoriali
            </a>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 bg-gradient-to-r from-primary to-secondary text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl sm:text-4xl font-bold mb-4">
            Hai Bisogno di Assistenza?
        </h2>
        <p class="text-xl mb-8 max-w-2xl mx-auto opacity-90">
            Il nostro team è qui per supportarti in questo momento difficile.
            Contattaci per qualsiasi domanda o per prenotare un servizio.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('contact') }}" class="inline-block px-8 py-3 bg-white text-primary rounded-lg hover:bg-gray-100 transition-all duration-200 font-medium">
                Contattaci
            </a>
            <a href="tel:+390123456789" class="inline-block px-8 py-3 bg-transparent text-white border-2 border-white rounded-lg hover:bg-white hover:text-primary transition-all duration-200 font-medium">
                Chiama Ora
            </a>
        </div>
    </div>
</section>
@endsection
