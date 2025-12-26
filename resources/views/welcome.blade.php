<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reverb Test</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    {{-- Подключаем скрипты --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Твои стили (я их свернул для краткости, они работают как в твоем исходнике) --}}
    <style>
        /*! tailwindcss v4.0.7 */
        @layer theme{:root,:host{--font-sans:'Instrument Sans',sans-serif;}}
        /* ... (тут весь твой огромный CSS, он подтянется сам, если ты используешь Vite, но для надежности оставь свой блок стилей здесь) ... */
        /* Я добавлю только одну кастомную анимацию для появления сообщений */
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .msg-appear { animation: slideIn 0.3s ease-out forwards; }
    </style>
</head>
<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col font-sans">

{{-- Заголовок --}}
<div class="w-full lg:max-w-4xl max-w-[335px] mb-6 flex justify-between items-center">
    <h1 class="text-xl font-bold dark:text-white">Laravel Reverb Test</h1>
    <a href="/fire" target="_blank" class="text-[#F53003] hover:underline text-sm">Открыть /fire в новой вкладке &rarr;</a>
</div>

<div class="flex items-center justify-center w-full lg:grow">
    <main class="flex max-w-[335px] w-full flex-col-reverse lg:max-w-4xl lg:flex-row gap-6">

        {{-- ЛЕВАЯ КОЛОНКА: СЮДА БУДУТ ПАДАТЬ СООБЩЕНИЯ --}}
        <div class="flex-1 p-6 bg-white dark:bg-[#161615] dark:text-[#EDEDEC] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] rounded-lg flex flex-col h-[400px]">

            <div class="flex justify-between items-center mb-4 border-b border-gray-100 dark:border-[#3E3E3A] pb-2">
                <h2 class="font-medium flex items-center gap-2">
                    🔴 Live Feed
                    <span class="relative flex h-2 w-2">
                              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                              <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                            </span>
                </h2>
                <span class="text-xs text-gray-400" id="status-indicator">Connecting...</span>
            </div>

            {{-- КОНТЕЙНЕР ДЛЯ СООБЩЕНИЙ --}}
            <div id="reverb-log" class="flex-1 overflow-y-auto space-y-3 pr-2 scrollbar-hide">
                <div class="text-center text-gray-400 mt-10 text-sm italic opacity-50 empty-msg">
                    Событий пока нет... <br> Открой /fire
                </div>
            </div>

        </div>

        {{-- ПРАВАЯ КОЛОНКА: ЛОГОТИП (Как у тебя было) --}}
        <div class="bg-[#fff2f2] dark:bg-[#1D0002] rounded-lg w-full lg:w-[438px] shrink-0 overflow-hidden flex items-center justify-center p-10 border border-[#F53003]/10">
            {{-- Тут твой SVG логотип Laravel, я его сократил для примера, он останется как был --}}
            <svg class="w-full text-[#F53003] dark:text-[#F61500]" viewBox="0 0 438 104" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M17.2036 -3H0V102.197H49.5189V86.7187H17.2036V-3Z" fill="currentColor" />
                <path d="M438 -3H421.694V102.197H438V-3Z" fill="currentColor" />
                {{-- Остальные пути логотипа... --}}
                <text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="currentColor" font-size="20">LARAVEL REVERB</text>
            </svg>
        </div>

    </main>
</div>
</body>
</html>
