@extends('layouts.app')

@section('title', $post->meta_title ?? $post->title . ' - Blog - La Rinascente Pet')

@section('content')
<div class="bg-gradient-to-b from-primary/10 via-white to-white">
    <!-- Article Header -->
    <article class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <!-- Breadcrumb -->
        <nav class="mb-8">
            <ol class="flex items-center gap-2 text-sm text-gray-600">
                <li><a href="{{ route('home') }}" class="hover:text-primary">Home</a></li>
                <li><svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
                <li><a href="{{ route('blog.index') }}" class="hover:text-primary">Blog</a></li>
                <li><svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
                <li class="text-gray-900 font-medium truncate">{{ Str::limit($post->title, 50) }}</li>
            </ol>
        </nav>

        <!-- Meta Info -->
        <div class="flex items-center gap-4 text-sm text-gray-600 mb-6">
            <time datetime="{{ $post->published_at->format('Y-m-d') }}" class="flex items-center gap-1">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                {{ $post->published_at->format('d M Y') }}
            </time>
            @if($post->reading_time_minutes)
                <span class="flex items-center gap-1">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ $post->reading_time_minutes }} min di lettura
                </span>
            @endif
        </div>

        <!-- Title -->
        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-8">
            {{ $post->title }}
        </h1>

        <!-- Excerpt -->
        @if($post->excerpt)
            <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                {{ $post->excerpt }}
            </p>
        @endif

        <!-- Featured Image -->
        @if($post->featured_image_path)
            <div class="mb-12 rounded-xl overflow-hidden shadow-lg">
                <img
                    src="{{ Storage::url($post->featured_image_path) }}"
                    alt="{{ $post->title }}"
                    class="w-full h-auto"
                >
            </div>
        @endif

        <!-- Content -->
        <div class="prose prose-lg max-w-none mb-12">
            {!! nl2br(e($post->content)) !!}
        </div>

        <!-- Share & Actions -->
        <div class="border-t border-gray-200 pt-8 mt-12">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <!-- Share -->
                <div class="flex items-center gap-3">
                    <span class="text-sm font-medium text-gray-700">Condividi:</span>
                    <div class="flex gap-2">
                        <!-- Facebook -->
                        <a
                            href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('blog.show', $post)) }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="w-10 h-10 flex items-center justify-center rounded-full bg-blue-600 hover:bg-blue-700 text-white transition-colors"
                            aria-label="Condividi su Facebook"
                        >
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <!-- Twitter / X -->
                        <a
                            href="https://twitter.com/intent/tweet?url={{ urlencode(route('blog.show', $post)) }}&text={{ urlencode($post->title) }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="w-10 h-10 flex items-center justify-center rounded-full bg-black hover:bg-gray-800 text-white transition-colors"
                            aria-label="Condividi su X (Twitter)"
                        >
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                            </svg>
                        </a>
                        <!-- WhatsApp -->
                        <a
                            href="https://wa.me/?text={{ urlencode($post->title . ' - ' . route('blog.show', $post)) }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="w-10 h-10 flex items-center justify-center rounded-full bg-green-600 hover:bg-green-700 text-white transition-colors"
                            aria-label="Condividi su WhatsApp"
                        >
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Back to Blog -->
                <a
                    href="{{ route('blog.index') }}"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-primary to-secondary hover:from-primary/90 hover:to-secondary/90 text-white font-medium rounded-lg transition-all duration-200 shadow-md hover:shadow-lg"
                >
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Torna al Blog
                </a>
            </div>
        </div>
    </article>
</div>
@endsection
