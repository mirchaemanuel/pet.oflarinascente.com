<?php

declare(strict_types=1);

use App\Livewire\MemorialDetail;
use App\Livewire\MemorialGallery;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.home');
})->name('home');

Route::get('/memoriali', MemorialGallery::class)->name('memorials.index');

Route::get('/memoriali/{pet:uuid}', MemorialDetail::class)->name('memorials.show');

Route::get('/servizi', function () {
    $services = App\Models\Service::query()
        ->where('is_active', true)
        ->orderBy('display_order')
        ->get();

    return view('pages.services.index', ['services' => $services]);
})->name('services.index');

Route::get('/blog', function () {
    $posts = App\Models\Post::query()
        ->where('is_published', true)
        ->where('published_at', '<=', now())
        ->latest('published_at')
        ->paginate(9);

    return view('pages.blog.index', ['posts' => $posts]);
})->name('blog.index');

Route::get('/blog/{post:slug}', function (App\Models\Post $post) {
    abort_if(! $post->is_published || $post->published_at > now(), 404);

    return view('pages.blog.show', ['post' => $post]);
})->name('blog.show');

Route::get('/contatti', function () {
    return view('pages.contact');
})->name('contact');

Route::get('/prenota', function () {
    return view('pages.booking');
})->name('booking');
