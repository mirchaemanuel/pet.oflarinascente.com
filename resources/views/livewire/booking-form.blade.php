<div>
    @if($showSuccessMessage)
        <div class="mb-8 bg-green-50 border border-green-200 rounded-lg p-4 flex items-start gap-3">
            <svg class="h-6 w-6 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <h3 class="font-medium text-green-900">Richiesta Inviata!</h3>
                <p class="text-sm text-green-700 mt-1">Ti contatteremo al più presto per confermare il servizio.</p>
            </div>
        </div>
    @endif

    <form wire:submit.prevent="submit" class="space-y-6">
        <!-- Service Selection -->
        <div>
            <label for="booking-service" class="block text-sm font-medium text-gray-700 mb-2">
                Servizio Richiesto <span class="text-danger">*</span>
            </label>
            <select
                id="booking-service"
                wire:model="service_id"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors @error('service_id') border-danger @enderror"
            >
                <option value="">Seleziona un servizio</option>
                @foreach($this->services as $service)
                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                @endforeach
            </select>
            @error('service_id')
                <p class="mt-1 text-sm text-danger">{{ $message }}</p>
            @enderror
        </div>

        <!-- Customer Information -->
        <div class="border-t border-gray-200 pt-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Informazioni di Contatto</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Customer Name -->
                <div>
                    <label for="booking-customer-name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nome e Cognome <span class="text-danger">*</span>
                    </label>
                    <input
                        type="text"
                        id="booking-customer-name"
                        wire:model="customer_name"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors @error('customer_name') border-danger @enderror"
                        placeholder="Mario Rossi"
                    >
                    @error('customer_name')
                        <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Customer Email -->
                <div>
                    <label for="booking-customer-email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email <span class="text-danger">*</span>
                    </label>
                    <input
                        type="email"
                        id="booking-customer-email"
                        wire:model="customer_email"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors @error('customer_email') border-danger @enderror"
                        placeholder="mario.rossi@example.com"
                    >
                    @error('customer_email')
                        <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Customer Phone -->
            <div class="mt-6">
                <label for="booking-customer-phone" class="block text-sm font-medium text-gray-700 mb-2">
                    Telefono <span class="text-danger">*</span>
                </label>
                <input
                    type="tel"
                    id="booking-customer-phone"
                    wire:model="customer_phone"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors @error('customer_phone') border-danger @enderror"
                    placeholder="+39 123 456 7890"
                >
                @error('customer_phone')
                    <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Pet Information -->
        <div class="border-t border-gray-200 pt-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Informazioni sull'Animale</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Pet Name -->
                <div>
                    <label for="booking-pet-name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nome dell'Animale <span class="text-gray-400">(opzionale)</span>
                    </label>
                    <input
                        type="text"
                        id="booking-pet-name"
                        wire:model="pet_name"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors @error('pet_name') border-danger @enderror"
                        placeholder="Es. Fido"
                    >
                    @error('pet_name')
                        <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Pet Species -->
                <div>
                    <label for="booking-pet-species" class="block text-sm font-medium text-gray-700 mb-2">
                        Tipo di Animale <span class="text-gray-400">(opzionale)</span>
                    </label>
                    <input
                        type="text"
                        id="booking-pet-species"
                        wire:model="pet_species"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors @error('pet_species') border-danger @enderror"
                        placeholder="Es. Cane, Gatto, etc."
                    >
                    @error('pet_species')
                        <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Additional Details -->
        <div class="border-t border-gray-200 pt-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Dettagli Aggiuntivi</h3>

            <!-- Preferred Date -->
            <div class="mb-6">
                <label for="booking-preferred-date" class="block text-sm font-medium text-gray-700 mb-2">
                    Data Preferita <span class="text-gray-400">(opzionale)</span>
                </label>
                <input
                    type="date"
                    id="booking-preferred-date"
                    wire:model="preferred_date"
                    min="{{ now()->addDay()->format('Y-m-d') }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors @error('preferred_date') border-danger @enderror"
                >
                @error('preferred_date')
                    <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                @enderror
            </div>

            <!-- Notes -->
            <div>
                <label for="booking-notes" class="block text-sm font-medium text-gray-700 mb-2">
                    Note o Richieste Speciali <span class="text-gray-400">(opzionale)</span>
                </label>
                <textarea
                    id="booking-notes"
                    wire:model="notes"
                    rows="4"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors resize-none @error('notes') border-danger @enderror"
                    placeholder="Eventuali informazioni aggiuntive che potrebbero essere utili..."
                ></textarea>
                @error('notes')
                    <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">Massimo 5000 caratteri</p>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex items-center gap-4 pt-6">
            <button
                type="submit"
                class="flex-1 px-8 py-4 bg-gradient-to-r from-primary to-secondary hover:from-primary/90 hover:to-secondary/90 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition-all duration-200 transform hover:scale-105"
                wire:loading.attr="disabled"
                wire:loading.class="opacity-50 cursor-wait"
            >
                <span wire:loading.remove>Invia Richiesta</span>
                <span wire:loading>Invio in corso...</span>
            </button>
        </div>

        <p class="text-sm text-gray-500">
            I campi contrassegnati con <span class="text-danger">*</span> sono obbligatori.
        </p>
    </form>
</div>
