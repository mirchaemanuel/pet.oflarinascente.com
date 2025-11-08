@extends('layouts.app')

@section('title', 'Prenota un Servizio - La Rinascente Pet')

@section('content')
<div class="bg-gradient-to-b from-primary/10 via-white to-white">
    <!-- Hero Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center mb-16">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                Prenota un Servizio
            </h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Compila il modulo sottostante per richiedere informazioni o prenotare uno dei nostri servizi. Ti contatteremo al più presto.
            </p>
        </div>

        <div class="max-w-4xl mx-auto">
            <!-- Booking Form Card -->
            <div class="bg-white rounded-xl shadow-lg p-8 md:p-12">
                <livewire:booking-form :service="request()->query('service')" />
            </div>

            <!-- Additional Information -->
            <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Info Card 1 -->
                <div class="bg-white rounded-lg shadow-md p-6 text-center">
                    <div class="w-12 h-12 bg-gradient-to-br from-primary to-secondary rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Risposta Rapida</h3>
                    <p class="text-sm text-gray-600">Ti ricontatteremo entro 24 ore</p>
                </div>

                <!-- Info Card 2 -->
                <div class="bg-white rounded-lg shadow-md p-6 text-center">
                    <div class="w-12 h-12 bg-gradient-to-br from-primary to-secondary rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Privacy Garantita</h3>
                    <p class="text-sm text-gray-600">I tuoi dati sono al sicuro con noi</p>
                </div>

                <!-- Info Card 3 -->
                <div class="bg-white rounded-lg shadow-md p-6 text-center">
                    <div class="w-12 h-12 bg-gradient-to-br from-primary to-secondary rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Supporto Compassionevole</h3>
                    <p class="text-sm text-gray-600">Con sensibilità e professionalità</p>
                </div>
            </div>

            <!-- Contact Alternative -->
            <div class="mt-12 bg-white rounded-xl shadow-lg p-8 text-center">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Preferisci Parlare con Noi?</h2>
                <p class="text-gray-600 mb-6">
                    Se preferisci parlare direttamente con il nostro team, siamo disponibili telefonicamente o via email.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a
                        href="tel:+390123456789"
                        class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-primary to-secondary hover:from-primary/90 hover:to-secondary/90 text-white font-medium rounded-lg transition-all duration-200 shadow-md hover:shadow-lg"
                    >
                        <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        Chiama Ora
                    </a>
                    <a
                        href="mailto:info@larinascentepet.it"
                        class="inline-flex items-center justify-center px-6 py-3 bg-white border-2 border-primary text-primary hover:bg-primary hover:text-white font-medium rounded-lg transition-all duration-200"
                    >
                        <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Invia Email
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
