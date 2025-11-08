<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Breadcrumbs -->
    <nav class="mb-8">
        <ol class="flex items-center gap-2 text-sm text-gray-600">
            <li>
                <a href="{{ route('home') }}" class="hover:text-primary">Home</a>
            </li>
            <li>
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </li>
            <li>
                <a href="{{ route('memorials.index') }}" class="hover:text-primary">Memoriali</a>
            </li>
            <li>
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </li>
            <li class="text-gray-900 font-medium">{{ $pet->name }}</li>
        </ol>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
        <!-- Left Column: Photo Gallery -->
        <div>
            <!-- Main Photo -->
            <div class="bg-gray-200 rounded-lg overflow-hidden aspect-square mb-4">
                @if($pet->primary_photo)
                    <img
                        src="{{ $pet->primary_photo->url }}"
                        alt="{{ $pet->name }}"
                        class="w-full h-full object-cover"
                    >
                @else
                    <div class="w-full h-full flex items-center justify-center">
                        <svg class="h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                @endif
            </div>

            <!-- Thumbnail Gallery -->
            @if($pet->photos->count() > 1)
                <div class="grid grid-cols-4 gap-2">
                    @foreach($pet->photos->take(4) as $photo)
                        <div class="aspect-square bg-gray-200 rounded overflow-hidden cursor-pointer hover:opacity-75 transition-opacity">
                            <img
                                src="{{ $photo->url }}"
                                alt="{{ $pet->name }}"
                                class="w-full h-full object-cover"
                            >
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Right Column: Pet Information -->
        <div>
            <!-- Header -->
            <div class="mb-6">
                <div class="flex items-center gap-3 mb-2">
                    <h1 class="text-4xl font-bold text-gray-900">{{ $pet->name }}</h1>
                    <span class="text-lg bg-gray-100 px-3 py-1 rounded">
                        {{ $pet->species->getLabel() }}
                    </span>
                </div>

                @if($pet->breed)
                    <p class="text-lg text-gray-600">{{ $pet->breed }}</p>
                @endif
            </div>

            <!-- Dates and Age -->
            <div class="bg-gray-50 rounded-lg p-6 mb-6">
                @if($pet->birth_date)
                    <div class="mb-4">
                        <span class="text-sm text-gray-600">Data di nascita</span>
                        <p class="text-lg font-medium text-gray-900">{{ $pet->birth_date->format('d/m/Y') }}</p>
                    </div>
                @endif

                @if($pet->death_date)
                    <div class="mb-4">
                        <span class="text-sm text-gray-600">Data di morte</span>
                        <p class="text-lg font-medium text-gray-900">{{ $pet->death_date->format('d/m/Y') }}</p>
                    </div>
                @endif

                @if($pet->age_years || $pet->age_months)
                    <div>
                        <span class="text-sm text-gray-600">Età</span>
                        <p class="text-lg font-medium text-gray-900">{{ $pet->age_display }}</p>
                    </div>
                @endif
            </div>

            <!-- Dedication -->
            @if($pet->dedication)
                <div class="mb-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-3">Dedica</h2>
                    <div class="prose prose-lg max-w-none text-gray-700">
                        <p class="italic">"{{ $pet->dedication }}"</p>
                    </div>
                </div>
            @endif

            <!-- Story -->
            @if($pet->story)
                <div class="mb-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-3">La Sua Storia</h2>
                    <div class="prose prose-lg max-w-none text-gray-700">
                        <p>{{ $pet->story }}</p>
                    </div>
                </div>
            @endif

            <!-- Reactions Stats -->
            <div class="bg-gradient-to-r from-heart/10 to-candle/10 rounded-lg p-6 mb-6">
                <div class="grid grid-cols-2 gap-4">
                    <div class="text-center">
                        <div class="flex items-center justify-center gap-2 mb-2">
                            <svg class="h-6 w-6 text-heart" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                            </svg>
                            <span class="text-2xl font-bold text-gray-900">{{ $pet->hearts_count ?? 0 }}</span>
                        </div>
                        <p class="text-sm text-gray-600">Cuori</p>
                    </div>

                    <div class="text-center">
                        <div class="flex items-center justify-center gap-2 mb-2">
                            <svg class="h-6 w-6 text-candle" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"/>
                            </svg>
                            <span class="text-2xl font-bold text-gray-900">{{ $this->activeCandlesCount }}</span>
                        </div>
                        <p class="text-sm text-gray-600">Candele Accese</p>
                    </div>
                </div>
            </div>

            <!-- Action Components -->
            <div class="space-y-4">
                <!-- HeartButton Component -->
                <livewire:heart-button :pet="$pet" :key="'heart-'.$pet->id" />

                <!-- CandleForm Component -->
                <livewire:candle-form :pet="$pet" :key="'candle-'.$pet->id" />
            </div>
        </div>
    </div>

    <!-- Owner Information (Optional) -->
    @if($pet->owner_name)
        <div class="mt-12 text-center">
            <p class="text-gray-600">
                Pubblicato da <span class="font-medium text-gray-900">{{ $pet->owner_name }}</span>
                @if($pet->published_at)
                    il {{ $pet->published_at->format('d/m/Y') }}
                @endif
            </p>
        </div>
    @endif
</div>
