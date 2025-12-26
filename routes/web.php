<?php

use App\Events\TestNotification;
use Illuminate\Support\Facades\Route;
use App\Events\ReactionSent;
use Illuminate\Http\Request;

Route::get('/fire', function () {
    // Отправляем событие с текстом
    TestNotification::dispatch('Привет из Laravel Reverb! ' . now());

    return 'Событие отправлено!';
});

Route::get('/', function () {
    return view('welcome');
});

// Страница с кнопками
Route::get('/likes', function () {
    return view('likes');
});

// Обработка нажатия (AJAX)
Route::post('/likes', function (Request $request) {
    // Валидация (просто чтобы не слали мусор)
    $request->validate(['type' => 'required|string']);

    // Отправляем событие всем
    ReactionSent::dispatch($request->type);

    return response()->json(['status' => 'ok']);
});
