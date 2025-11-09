@extends('layouts.app')

@section('title', 'Blog - La Rinascente Pet')

@section('content')
<div class="bg-gradient-to-b from-primary/10 via-white to-white">
    <!-- Hero Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center mb-16">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                Blog
            </h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Consigli, storie e supporto per affrontare la perdita del tuo amato animale domestico.
            </p>
        </div>

        <!-- Posts Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($posts as $post)
                <article class="bg-white rounded-xl shadow-md hover:shadow-xl transition-shadow duration-300 overflow-hidden group">
                    <!-- Post Image -->
                    @if($post->featured_image_path)
                        <a href="{{ route('blog.show', $post) }}" class="block relative h-56 overflow-hidden">
                            <img
                                src="{{ Storage::url($post->featured_image_path) }}"
                                alt="{{ $post->title }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                            >
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                        </a>
                    @else
                        <a href="{{ route('blog.show', $post) }}" class="block relative h-56 bg-gradient-to-br from-primary to-secondary flex items-center justify-center">
                            <svg class="h-20 w-20 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </a>
                    @endif

                    <!-- Post Content -->
                    <div class="p-6">
                        <!-- Meta -->
                        <div class="flex items-center gap-4 text-sm text-gray-500 mb-3">
                            <time datetime="{{ $post->published_at->format('Y-m-d') }}">
                                {{ $post->published_at->format('d M Y') }}
                            </time>
                            @if($post->reading_time_minutes)
                                <span class="flex items-center gap-1">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $post->reading_time_minutes }} min
                                </span>
                            @endif
                        </div>

                        <!-- Title -->
                        <h2 class="text-2xl font-bold text-gray-900 mb-3 group-hover:text-primary transition-colors">
                            <a href="{{ route('blog.show', $post) }}">
                                {{ $post->title }}
                            </a>
                        </h2>

                        <!-- Excerpt -->
                        @if($post->excerpt)
                            <p class="text-gray-600 mb-4 line-clamp-3">
                                {{ $post->excerpt }}
                            </p>
                        @endif

                        <!-- Read More -->
                        <a
                            href="{{ route('blog.show', $post) }}"
                            class="inline-flex items-center gap-2 text-primary hover:text-secondary font-medium transition-colors"
                        >
                            Continua a leggere
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </article>
            @empty
                <div class="col-span-full text-center py-12">
                    <svg class="mx-auto h-24 w-24 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    <h3 class="text-xl font-medium text-gray-600 mb-2">Nessun Articolo Disponibile</h3>
                    <p class="text-gray-500">Al momento non ci sono articoli pubblicati. Torna presto per nuovi contenuti.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($posts->hasPages())
            <div class="mt-12">
                {{ $posts->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
