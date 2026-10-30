<?php

use App\Jobs\HelloWorld;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'dashboard')->name('dashboard');

    Route::get('hello', fn () => inertia('hello', [
        'ping' => Redis::ping(),
        'logs' => Redis::lrange('hello:log', 0, -1),
    ]))->name('hello');

    Route::post('hello', function () {
        HelloWorld::dispatch('web');

        return back();
    })->name('hello.dispatch');
});

require __DIR__.'/settings.php';
