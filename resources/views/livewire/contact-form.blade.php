<div>
    @if($showSuccessMessage)
        <div class="mb-8 bg-green-50 border border-green-200 rounded-lg p-4 flex items-start gap-3">
            <svg class="h-6 w-6 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <h3 class="font-medium text-green-900">Messaggio Inviato!</h3>
                <p class="text-sm text-green-700 mt-1">Grazie per averci contattato. Ti risponderemo al più presto.</p>
            </div>
        </div>
    @endif

    <form wire:submit.prevent="submit" class="space-y-6">
        <!-- Name -->
        <div>
            <label for="contact-name" class="block text-sm font-medium text-gray-700 mb-2">
                Nome e Cognome <span class="text-danger">*</span>
            </label>
            <input
                type="text"
                id="contact-name"
                wire:model="name"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors @error('name') border-danger @enderror"
                placeholder="Mario Rossi"
            >
            @error('name')
                <p class="mt-1 text-sm text-danger">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email -->
        <div>
            <label for="contact-email" class="block text-sm font-medium text-gray-700 mb-2">
                Email <span class="text-danger">*</span>
            </label>
            <input
                type="email"
                id="contact-email"
                wire:model="email"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors @error('email') border-danger @enderror"
                placeholder="mario.rossi@example.com"
            >
            @error('email')
                <p class="mt-1 text-sm text-danger">{{ $message }}</p>
            @enderror
        </div>

        <!-- Phone -->
        <div>
            <label for="contact-phone" class="block text-sm font-medium text-gray-700 mb-2">
                Telefono <span class="text-gray-400">(opzionale)</span>
            </label>
            <input
                type="tel"
                id="contact-phone"
                wire:model="phone"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors @error('phone') border-danger @enderror"
                placeholder="+39 123 456 7890"
            >
            @error('phone')
                <p class="mt-1 text-sm text-danger">{{ $message }}</p>
            @enderror
        </div>

        <!-- Subject -->
        <div>
            <label for="contact-subject" class="block text-sm font-medium text-gray-700 mb-2">
                Oggetto <span class="text-danger">*</span>
            </label>
            <input
                type="text"
                id="contact-subject"
                wire:model="subject"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors @error('subject') border-danger @enderror"
                placeholder="Richiesta informazioni servizi"
            >
            @error('subject')
                <p class="mt-1 text-sm text-danger">{{ $message }}</p>
            @enderror
        </div>

        <!-- Message -->
        <div>
            <label for="contact-message" class="block text-sm font-medium text-gray-700 mb-2">
                Messaggio <span class="text-danger">*</span>
            </label>
            <textarea
                id="contact-message"
                wire:model="message"
                rows="6"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors resize-none @error('message') border-danger @enderror"
                placeholder="Scrivi qui il tuo messaggio..."
            ></textarea>
            @error('message')
                <p class="mt-1 text-sm text-danger">{{ $message }}</p>
            @enderror
            <p class="mt-1 text-sm text-gray-500">Massimo 5000 caratteri</p>
        </div>

        <!-- Submit Button -->
        <div class="flex items-center gap-4">
            <button
                type="submit"
                class="flex-1 px-8 py-4 bg-gradient-to-r from-primary to-secondary hover:from-primary/90 hover:to-secondary/90 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition-all duration-200 transform hover:scale-105"
                wire:loading.attr="disabled"
                wire:loading.class="opacity-50 cursor-wait"
            >
                <span wire:loading.remove>Invia Messaggio</span>
                <span wire:loading>Invio in corso...</span>
            </button>
        </div>

        <p class="text-sm text-gray-500">
            I campi contrassegnati con <span class="text-danger">*</span> sono obbligatori.
        </p>
    </form>
</div>
