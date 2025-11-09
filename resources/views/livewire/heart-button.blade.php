<div>
    <button
        wire:click="addHeart"
        @if(!$this->canAddHeart) disabled @endif
        class="w-full flex items-center justify-center gap-3 px-6 py-4 rounded-lg font-medium transition-all duration-200
            @if($this->canAddHeart)
                bg-gradient-to-r from-heart to-heart/80 hover:from-heart/90 hover:to-heart/70 text-white shadow-md hover:shadow-lg transform hover:scale-105
            @else
                bg-gray-200 text-gray-500 cursor-not-allowed
            @endif
        "
        wire:loading.attr="disabled"
        wire:loading.class="opacity-50 cursor-wait"
    >
        <!-- Heart Icon -->
        <svg class="h-6 w-6 @if($this->canAddHeart) animate-pulse @endif" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
        </svg>

        <!-- Button Text -->
        <span wire:loading.remove>
            @if($this->canAddHeart)
                Invia un Cuore
            @else
                Cuore Inviato
            @endif
        </span>

        <!-- Loading Text -->
        <span wire:loading>
            Invio in corso...
        </span>

        <!-- Hearts Count Badge -->
        <span class="inline-flex items-center justify-center min-w-[2rem] px-2 py-1 text-sm font-bold rounded-full
            @if($this->canAddHeart)
                bg-white/20
            @else
                bg-gray-300
            @endif
        ">
            {{ $this->heartsCount }}
        </span>
    </button>
</div>
