@extends('layouts.app')

@section('title', 'Servizi - La Rinascente Pet')

@section('content')
<div class="bg-gradient-to-b from-primary/10 via-white to-white">
    <!-- Hero Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center mb-16">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                I Nostri Servizi
            </h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Offriamo una gamma completa di servizi funebri per animali domestici, con dignità, rispetto e cura professionale.
            </p>
        </div>

        <!-- Services Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($services as $service)
                <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-shadow duration-300 overflow-hidden group">
                    <!-- Service Image -->
                    @if($service->image_path)
                        <div class="relative h-48 overflow-hidden">
                            <img
                                src="{{ Storage::url($service->image_path) }}"
                                alt="{{ $service->name }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                            >
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                        </div>
                    @else
                        <div class="relative h-48 bg-gradient-to-br from-primary to-secondary flex items-center justify-center">
                            <svg class="h-20 w-20 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                        </div>
                    @endif

                    <!-- Service Content -->
                    <div class="p-6">
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">
                            {{ $service->name }}
                        </h3>

                        <p class="text-gray-600 mb-4 line-clamp-3">
                            {{ $service->description }}
                        </p>

                        <!-- Price -->
                        @if($service->price_from)
                            <div class="mb-4 flex items-baseline gap-2">
                                <span class="text-3xl font-bold text-primary">
                                    €{{ number_format($service->price_from, 2, ',', '.') }}
                                </span>
                                @if($service->price_notes)
                                    <span class="text-sm text-gray-500">
                                        {{ $service->price_notes }}
                                    </span>
                                @endif
                            </div>
                        @endif

                        <!-- CTA Button -->
                        <a
                            href="{{ route('booking') }}?service={{ $service->id }}"
                            class="inline-flex items-center justify-center w-full px-6 py-3 bg-gradient-to-r from-primary to-secondary hover:from-primary/90 hover:to-secondary/90 text-white font-medium rounded-lg transition-all duration-200 shadow-md hover:shadow-lg transform hover:scale-105"
                        >
                            Richiedi Informazioni
                            <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <svg class="mx-auto h-24 w-24 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                    <h3 class="text-xl font-medium text-gray-600 mb-2">Nessun Servizio Disponibile</h3>
                    <p class="text-gray-500">Al momento non ci sono servizi attivi. Contattaci per maggiori informazioni.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Info Section -->
    <div class="bg-primary/5 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="text-center">
                    <div class="w-16 h-16 bg-gradient-to-br from-primary to-secondary rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Professionalità</h3>
                    <p class="text-gray-600">Personale qualificato e servizi certificati</p>
                </div>

                <!-- Feature 2 -->
                <div class="text-center">
                    <div class="w-16 h-16 bg-gradient-to-br from-primary to-secondary rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Rispetto</h3>
                    <p class="text-gray-600">Trattamento dignitoso del vostro amico</p>
                </div>

                <!-- Feature 3 -->
                <div class="text-center">
                    <div class="w-16 h-16 bg-gradient-to-br from-primary to-secondary rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Disponibilità</h3>
                    <p class="text-gray-600">Assistenza 24/7 per ogni necessità</p>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="bg-gradient-to-r from-primary to-secondary rounded-2xl shadow-2xl overflow-hidden">
            <div class="p-8 md:p-12 text-center">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
                    Hai Bisogno di Assistenza?
                </h2>
                <p class="text-xl text-white/90 mb-8 max-w-2xl mx-auto">
                    Il nostro team è sempre disponibile per aiutarti in questo momento difficile.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a
                        href="{{ route('contact') }}"
                        class="inline-flex items-center justify-center px-8 py-4 bg-white text-primary font-medium rounded-lg hover:bg-gray-50 transition-colors shadow-lg hover:shadow-xl transform hover:scale-105"
                    >
                        Contattaci
                        <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </a>
                    <a
                        href="tel:+390123456789"
                        class="inline-flex items-center justify-center px-8 py-4 bg-white/10 text-white border-2 border-white font-medium rounded-lg hover:bg-white/20 transition-colors transform hover:scale-105"
                    >
                        Chiama Ora
                        <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
