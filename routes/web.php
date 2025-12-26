<?php

use App\Events\TestNotification;
use Illuminate\Support\Facades\Route;

Route::get('/fire', function () {
    // Отправляем событие с текстом
    TestNotification::dispatch('Привет из Laravel Reverb! ' . now());

    return 'Событие отправлено!';
});

Route::get('/', function () {
    return view('welcome');
});
