<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Live Reactions</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Inter', sans-serif; overflow: hidden; }

        /* Контейнер, где летают частицы (поверх всего, но не мешает кликать) */
        #particles-container {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            pointer-events: none; /* Пропускает клики сквозь себя */
            z-index: 50;
        }

        /* Анимация полета вверх */
        @keyframes floatUp {
            0% { transform: translateY(0) scale(0.5); opacity: 0; }
            10% { opacity: 1; transform: translateY(-20px) scale(1.2); }
            100% { transform: translateY(-80vh) scale(1); opacity: 0; }
        }

        /* Анимация дрожания (для естественности) */
        @keyframes wobble {
            0%, 100% { margin-left: 0; }
            50% { margin-left: 15px; }
        }

        .emoji-particle {
            position: absolute;
            bottom: 100px; /* Старт чуть выше кнопок */
            font-size: 2rem;
            animation: floatUp 3s ease-out forwards, wobble 2s ease-in-out infinite alternate;
        }

        /* Эффект нажатия на кнопку */
        .btn-active { transform: scale(0.9); transition: 0.1s; }
    </style>
</head>
<body class="bg-[#0a0a0a] text-white h-screen flex flex-col items-center justify-center relative selection:bg-red-500 selection:text-white">

<div class="z-10 text-center mb-10">
    <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight mb-2">
        Make some noise! 🎉
    </h1>
    <p class="text-gray-400">Нажимай на кнопки — увидишь магию у всех.</p>
    <div class="mt-2 text-xs text-gray-600 font-mono" id="connection-status">Connecting...</div>
</div>

<div class="z-20 flex gap-6 p-6 bg-white/5 backdrop-blur-md rounded-2xl border border-white/10 shadow-2xl">
    <button onclick="sendReaction('❤️')" class="reaction-btn group relative flex items-center justify-center w-16 h-16 bg-[#1a1a1a] rounded-xl border border-white/5 hover:bg-red-500/20 hover:border-red-500/50 transition-all duration-300 text-3xl shadow-lg hover:shadow-red-900/50 hover:-translate-y-1">
        <span class="group-hover:scale-125 transition-transform duration-300">❤️</span>
    </button>

    <button onclick="sendReaction('🔥')" class="reaction-btn group relative flex items-center justify-center w-16 h-16 bg-[#1a1a1a] rounded-xl border border-white/5 hover:bg-orange-500/20 hover:border-orange-500/50 transition-all duration-300 text-3xl shadow-lg hover:shadow-orange-900/50 hover:-translate-y-1">
        <span class="group-hover:scale-125 transition-transform duration-300">🔥</span>
    </button>

    <button onclick="sendReaction('🚀')" class="reaction-btn group relative flex items-center justify-center w-16 h-16 bg-[#1a1a1a] rounded-xl border border-white/5 hover:bg-blue-500/20 hover:border-blue-500/50 transition-all duration-300 text-3xl shadow-lg hover:shadow-blue-900/50 hover:-translate-y-1">
        <span class="group-hover:scale-125 transition-transform duration-300">🚀</span>
    </button>

    <button onclick="sendReaction('🦄')" class="reaction-btn group relative flex items-center justify-center w-16 h-16 bg-[#1a1a1a] rounded-xl border border-white/5 hover:bg-purple-500/20 hover:border-purple-500/50 transition-all duration-300 text-3xl shadow-lg hover:shadow-purple-900/50 hover:-translate-y-1">
        <span class="group-hover:scale-125 transition-transform duration-300">🦄</span>
    </button>
</div>

<div id="particles-container"></div>

<script type="module">
    // 1. Ждем загрузки Echo и Axios
    // Функция отправки реакции (AJAX)
    window.sendReaction = function(type) {
        // Визуальный эффект нажатия
        const btn = event.currentTarget;
        btn.classList.add('btn-active');
        setTimeout(() => btn.classList.remove('btn-active'), 100);

        // Отправка на сервер
        axios.post('/likes', { type: type })
            .catch(err => console.error(err));
    };

    // 2. Функция создания летящего эмодзи
    function spawnParticle(emoji) {
        const container = document.getElementById('particles-container');
        const el = document.createElement('div');
        el.innerText = emoji;
        el.classList.add('emoji-particle');

        // Рандомная позиция по горизонтали (от 10% до 90% экрана)
        const randomLeft = Math.floor(Math.random() * 80) + 10;
        // Рандомный размер (для глубины)
        const randomSize = (Math.random() * 1.5 + 1) + 'rem';

        el.style.left = randomLeft + '%';
        el.style.fontSize = randomSize;

        // Немного разная длительность анимации
        el.style.animationDuration = (Math.random() * 2 + 2) + 's';

        container.appendChild(el);

        // Удаляем элемент после анимации, чтобы не засорять DOM
        setTimeout(() => {
            el.remove();
        }, 4000);
    }

    // 3. Подписка на Reverb
    // Ждем небольшую паузу, чтобы window.Echo успел инициализироваться в app.js
    setTimeout(() => {
        if (window.Echo) {
            document.getElementById('connection-status').innerText = '🟢 Connected & Listening';
            document.getElementById('connection-status').classList.add('text-green-500');

            window.Echo.channel('reactions')
                .listen('ReactionSent', (e) => {
                    console.log('Reaction received:', e.type);
                    // Запускаем несколько частиц для эффекта "взрыва"
                    spawnParticle(e.type);
                    setTimeout(() => spawnParticle(e.type), 100);
                    setTimeout(() => spawnParticle(e.type), 300);
                });
        } else {
            console.error('Echo not loaded correctly');
        }
    }, 500);
</script>
</body>
</html>
