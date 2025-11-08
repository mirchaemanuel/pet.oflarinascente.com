<div>
    <!-- Open Modal Button -->
    <button
        wire:click="openModal"
        class="w-full flex items-center justify-center gap-3 px-6 py-4 rounded-lg font-medium transition-all duration-200
            bg-gradient-to-r from-candle to-candle/80 hover:from-candle/90 hover:to-candle/70 text-gray-900 shadow-md hover:shadow-lg transform hover:scale-105"
    >
        <!-- Candle Icon -->
        <svg class="h-6 w-6 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"/>
        </svg>

        <span>Accendi una Candela</span>
    </button>

    <!-- Modal -->
    @if($showModal)
        <div
            class="fixed inset-0 z-50 overflow-y-auto"
            x-data="{ show: @entangle('showModal') }"
            x-show="show"
            x-transition.opacity
            @click.self="$wire.closeModal()"
        >
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm"></div>

            <!-- Modal Container -->
            <div class="flex min-h-screen items-center justify-center p-4">
                <!-- Modal Content -->
                <div
                    class="relative bg-white rounded-xl shadow-2xl max-w-md w-full p-6 space-y-6"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    @click.stop
                >
                    <!-- Close Button -->
                    <button
                        wire:click="closeModal"
                        class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors"
                        type="button"
                    >
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>

                    <!-- Title -->
                    <div class="text-center">
                        <div class="mx-auto w-16 h-16 bg-gradient-to-br from-candle to-candle/60 rounded-full flex items-center justify-center mb-4">
                            <svg class="h-8 w-8 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Accendi una Candela Virtuale</h3>
                        <p class="text-gray-600">In memoria di {{ $pet->name }}</p>
                    </div>

                    <!-- Form -->
                    <form wire:submit.prevent="lightCandle" class="space-y-4">
                        <!-- Name Input (Optional) -->
                        <div>
                            <label for="litByName" class="block text-sm font-medium text-gray-700 mb-2">
                                Il tuo nome <span class="text-gray-400">(opzionale)</span>
                            </label>
                            <input
                                type="text"
                                id="litByName"
                                wire:model="litByName"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-candle focus:border-candle transition-colors"
                                placeholder="Es. Mario Rossi"
                                maxlength="255"
                            >
                            @error('litByName')
                                <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Message Input (Optional) -->
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                                Messaggio <span class="text-gray-400">(opzionale)</span>
                            </label>
                            <textarea
                                id="message"
                                wire:model="message"
                                rows="4"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-candle focus:border-candle transition-colors resize-none"
                                placeholder="Scrivi un messaggio di ricordo..."
                                maxlength="500"
                            ></textarea>
                            <div class="mt-1 flex justify-between items-center">
                                <div class="flex-1">
                                    @error('message')
                                        <p class="text-sm text-danger">{{ $message }}</p>
                                    @else
                                        <span class="text-xs text-gray-400">Massimo 500 caratteri</span>
                                    @enderror
                                </div>
                                @if($this->message)
                                    <span class="text-xs text-gray-500">{{ strlen($this->message) }}/500</span>
                                @endif
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-3 pt-2">
                            <button
                                type="button"
                                wire:click="closeModal"
                                class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium"
                            >
                                Annulla
                            </button>
                            <button
                                type="submit"
                                class="flex-1 px-4 py-2 bg-gradient-to-r from-candle to-candle/80 hover:from-candle/90 hover:to-candle/70 text-gray-900 rounded-lg font-medium shadow-md hover:shadow-lg transition-all transform hover:scale-105"
                                wire:loading.attr="disabled"
                                wire:loading.class="opacity-50 cursor-wait"
                            >
                                <span wire:loading.remove>Accendi Candela</span>
                                <span wire:loading>Accensione...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
